<?php

namespace App\Http\Controllers;

use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra listado de usuarios
     */
    public function index()
    {

        $data['offices'] = $this->getFromApi('GET', 'offices');

        $data['company_id'] = '';
        $data['companyRoles'] = [];

        if (!Auth::user()->hasRole('admin')) {
            $data['company'] = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $data['countries'] = $this->getFromApi('GET', 'countries');
            $data['cities'] = $this->getFromApi('GET', 'cities?company_id=' . $data['company']->id);
            $data['company_id'] = $data['company']->id;
            $data['seniorities'] = $this->getFromApi('GET', 'seniorities?company_id=' . $data['company']->id);
            $data['companyRoles'] = $this->getFromApi('GET', 'company_roles?company_id=' . $data['company']->id);
            $data['projectRoles'] = $this->getFromApi('GET', 'project_roles?company_id=' . $data['company']->id);
            $data['workgroups'] = $this->getFromApi('GET', 'workgroups?company_id=' . $data['company']->id);

        }

        if (!Auth::user()->hasRole('admin')) {
            $view = 'users/index';
        } else {
            $view = 'users/indexadmin';
        }

        //var_dump($data);
        return view($view, $data);
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
        $res = $this->apiCall('GET', 'users/' . $id);
        $user = json_decode($res->getBody()->__toString())->data;


        return response()->json([
            'view' => view('users/show', ['user' => $user])->render(),
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $user = $this->getFromApi('GET', 'users/' . $id);


        $companyRoles = [];
        $cities = [];
        if (!Auth::user()->hasRole('admin')) {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        } else {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . $user->id);

        }
        $cities = $this->getFromApi('GET', 'cities?company_id=' . $company->id.'&country_id='.$user->country_id);

        if (is_object($user)) {
            $offices = $this->getFromApi('GET', 'offices?city_id=' . $user->city_id . "&city_id=" . $user->city_id);
        } else {
            $offices = array();
        }


        $companyRoles = $this->getFromApi('GET', 'company_roles?company_id=' . $company->id);
        $projectRoles = $this->getFromApi('GET', 'project_roles?company_id=' . $company->id);

        $workgroups = $this->getFromApi('GET', 'workgroups?company_id=' . $company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id=' . $company->id);
        // obtengo el company_role_id



        return response()->json([
            'view' => view('users/edit', [
                'user' => $user,
                'company' => $company,
                'seniorities' => $seniorities,
                'offices' => $offices,
                'cities' => $cities,
                'companyRoles' => $companyRoles,
                'projectRoles' => $projectRoles,
                'workgroups' => $workgroups
            ])->render(),
        ]);
    }


    public function password($id)
    {
        $user = $this->getFromApi('GET', 'users/' . $id);


        if (is_object($user)) {
            $offices = $this->getFromApi('GET', 'offices?city_id=' . $user->city_id);
        } else {
            $offices = array();
        }

        $companyRoles = [];

        if (!Auth::user()->hasRole('admin')) {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());


        } else {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . $user->id);

        }

        $companyRoles = $this->getFromApi('GET', 'company_roles?company_id=' . $company->id);
        $cities = $this->getFromApi('GET', 'cities?company_id=' . $company->id);
        $workgroups = $this->getFromApi('GET', 'workgroups?company_id=' . $company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id=' . $company->id);


        // obtengo el company_role_id
        $roleUser = RoleUser::where('user_id', $id)->first();
        if (is_object($roleUser)) {
            $role = $this->getFromApi('GET', 'roles/' . $roleUser->role_id);
            $company_role_id = $role->company_role_id;
        } else {
            $role = array();
        }
        $company_role_id = '';


        return response()->json([
            'view' => view('users/password', [
                'user' => $user,
                'company' => $company,
                'seniorities' => $seniorities,
                'offices' => $offices,
                'cities' => $cities,
                'companyRoles' => $companyRoles,
                'workgroups' => $workgroups,
                'company_role_id' => $company_role_id
            ])->render(),
        ]);
    }


    /**
     * Crear nuevo usuario
     */
    public
    function store(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'office_id' => 'required',
            'seniority_id' => 'required',
            'city_id' => 'required',
            'project_role_id' => 'required',
            'workgroup_id' => 'required'
        ]);

        $data = $request->all();

        $res = $this->apiCall('POST', 'users', $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->getContents(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->getContents(), TRUE)['error'];
            Validator::make($jsonRes, [
                'status_code' => [Rule::in(['201', '200'])]
            ], ['in' => __('api_errors.users_store')])->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }


        return response()->json();
    }

    /**
     * Actualizo
     */
    public
    function update(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'name' => 'required',
            'email' => 'sometimes|required|email|unique:users,email,' . $request->id,
            'office_id' => 'required',
            'seniority_id' => 'required',
            'city_id' => 'required',

            'project_role_id' => 'required',

            'workgroup_id' => 'required',
        ]);

        $data = $request->all();

        $res = $this->apiCall('PATCH', 'users/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];


            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.users_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }


    public
    function update_password(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'password' => 'required',
        ]);

        $data = $request->all();

        $user = $this->getFromApi('GET', 'users/' . Auth::id());


        $res = $this->apiCall('PATCH', 'users/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.users_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }


        return response()->json();
    }


    /**
     * Elimina
     * @param  int $id ID
     */
    public
    function delete($id)
    {
        $res = $this->apiCall('DELETE', 'users/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');

            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('UsersController@index');
    }


    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('users/import', [

                'company' => $company,
                'cities' => $cities
            ])->render()
        ]);
    }

    public function do_import(Request $request)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $array = array();
        try {
            $this->validate($request, [
                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);



            foreach ($array as $value) {


                if (isset($value[12]) && isset($value[11])  && isset($value[10])) {
                    $item = array();


                    $city = $this->getFromApi('GET', 'cities/?name=' . $value[7] . '&company_id=' . $company->id);
                    $company_role = $this->getFromApi('GET', 'company_roles/?title=' . $value[8]. '&company_id=' . $company->id);
                    $project_role = $this->getFromApi('GET', 'project_roles/?title=' . $value[9]. '&company_id=' . $company->id);
                    $seniority = $this->getFromApi('GET', 'seniorities/?title=' . $value[10]. '&company_id=' . $company->id);
                    $office = $this->getFromApi('GET', 'offices/?title=' . $value[11]. '&company_id=' . $company->id);
                    $workgroup = $this->getFromApi('GET', 'workgroups/?title=' . $value[12]. '&company_id=' . $company->id);

                    //var_dump($city);

                    if (isset($city[0]) && isset($company_role[0]) && isset($project_role[0])
                        && isset($seniority[0]) && isset($office[0]) && isset($workgroup[0])) {

                        $item['city_id'] = $city[0]->id;
                        $item['company_role_id'] = $company_role[0]->id;
                        $item['project_role_id'] = $project_role[0]->id;
                        $item['seniority_id'] = $seniority[0]->id;
                        $item['office_id'] = $office[0]->id;
                        $item['company_id'] = $company->id;
                        $item['workgroup_id'] = $workgroup[0]->id;
                        $item['user_id'] = Auth::id();
                        $item['name'] = $value[0];
                        $item['email'] = $value[1];
                        $item['password'] =  app('hash')->make($value['2']);
                        $item['address'] = $value[3];
                        $item['office_phone'] = $value[4];
                        $item['home_phone'] = $value[5];
                        $item['cell_phone'] = $value[6];

                        $item['workplace'] = $value[13];



                        $this->apiCall('POST', 'users', $item);

                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }


}
