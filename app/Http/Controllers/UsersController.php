<?php

namespace App\Http\Controllers;

use App\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Exception;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
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

        }else{
			//return Auth::id();
		  //$data['company'] = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $data['countries'] = $this->getFromApi('GET', 'countries');
            $data['cities'] = $this->getFromApi('GET', 'cities');
            //$data['company_id'] = $data['company']->id;
            //$data['seniorities'] = $this->getFromApi('GET', 'seniorities?company_id=' . $data['company']->id);
            $data['companyRoles'] = $this->getFromApi('GET', 'company_roles');
            //$data['projectRoles'] =$this->getFromApi('GET', 'project_roles?company_id=' . $data['company']->id);
            $data['workgroups'] = $this->getFromApi('GET', 'workgroups?title=ALL PERSONNEL');


		}
        // Timezone - Zona Horaria
        $data['timezones'] = $this->getFromApi('GET', 'timezones');
        
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
        $timezones = $this->getFromApi('GET', 'timezones');
        if (!Auth::user()->hasRole('admin')) {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $cities = $this->getFromApi('GET', 'cities?company_id=' . $company->id.'&country_id='.$user->country_id);
            $companyRoles = $this->getFromApi('GET', 'company_roles?company_id=' . $company->id);
            $projectRoles = $this->getFromApi('GET', 'project_roles?company_id=' . $company->id);
        } else {
            $company = $this->getFromApi('GET', 'companies/fromUser/' . $user->id);
            $cities = $this->getFromApi('GET', 'cities?company_id='.$company->id.'&cities?country_id='.$user->country_id);
            $companyRoles = $this->getFromApi('GET', 'company_roles?company_id=' . $company->id);
            $projectRoles = $this->getFromApi('GET', 'project_roles?company_id=' . $company->id);

        }

        if (is_object($user)) {
            $offices = $this->getFromApi('GET', 'offices?company_id='.$company->id.'&offices?city_id=' . $user->city_id);
        } else {
            $offices = array();
        }

        $countries = $this->getFromApi('GET', 'countries');
        if(Auth::user()->hasRole('admin')){
            // $workgroups = $this->getFromApi('GET', 'workgroups?company_id=' . $company->id.'&title=ALL PERSONNEL');
                $workgroups = $this->getFromApi('GET', 'workgroups?title=ALL PERSONNEL');

        }else{
        	$workgroups = $this->getFromApi('GET', 'workgroups?company_id=' . $company->id);
        }

		if(!Auth::user()->hasRole('admin')){
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id=' . $company->id);
			  return response()->json([
            'view' => view('users/edit', [
                'user' => $user,
                'company' => $company,
                'seniorities' => $seniorities,
                'countries' => $countries,
                'offices' => $offices,
                'cities' => $cities,
                'companyRoles' => $companyRoles,
                'projectRoles' => $projectRoles,
                'workgroups' => $workgroups,
                'timezones' => $timezones
            ])->render(),
        ]);
        // obtengo el company_role_id
		}else{
		  return response()->json([
            'view' => view('users/edit', [
                'user' => $user,
                'company' => $company,
              //  'seniorities' => $seniorities,
                'offices' => $offices,
                'cities' => $cities,
                'companyRoles' => $companyRoles,
                'projectRoles' => $projectRoles,
                'workgroups' => $workgroups,
                'timezones' => $timezones
            ])->render(),
        ]);
		}


      
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
    public function store(Request $request)
    {

        if (!Auth::user()->hasRole('admin'))
        {
            // validacion del formulario
            $validator =Validator::make($request->all(), [

                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&.,]/', // must contain a special character
                ],
                'office_id' => 'required',
                'seniority_id' => 'required',
                'city_id' => 'required',
                'project_role_id' => 'required',
                'workgroup_id' => 'required'
            ]);

        }
        else
        {
            // validacion del formulario
            $validator =Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8',             // must be at least 8 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&.,]/', // must contain a special character
                ],
                'office_id' => 'required',
                //'seniority_id' => 'required',
                'city_id' => 'required',
                //'project_role_id' => 'required',
                // 'workgroup_id' => 'required'
            ]);
        }

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->all();

        $apiRoutes = ['users','irmmail','rcuser'];

        foreach ($apiRoutes as $route) {
            $res = $this->apiCall('POST', $route, $data);
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
        }

        // $company = $this->getFromApi('GET', 'companies/'. $request->company_id);
        // $domain = $company->domain->domain;
        // $dataFromTC = $data + ['dom' => $domain];
        // $res = $this->apiCall('POST', 'rcjoingeneralrooms', $dataFromTC);

        // if(env('IREDMAIL_API_HOST'))
        // {
        //     //creacion del mail llamando a iredmailapi.
        //     $res = $this->iredmailApiCall('POST', 'mailbox', $dataFromTC);
        //     $res = $this->iredmailApiCall('POST', 'rcuser', $dataFromTC);
        // }

        return response()->json();
    }

    /**
     * Actualizo
     */
    public
    function update(Request $request)
    {
		
        if (!Auth::user()->hasRole('admin')) 
        {
            // validacion del formulario
            $validator =Validator::make($request->all(), [

                'name' => 'required',
                'email' => 'sometimes|required|email|unique:users,email,' . $request->id,
                'office_id' => 'required',
                'seniority_id' => 'required',
                'city_id' => 'required',

            

                'workgroup_id' => 'required',
            ]);
        }
        else
        {
			// validacion del formulario
            $validator =Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'sometimes|required|email|unique:users,email,' . $request->id,
                    'office_id' => 'required',
                // 'seniority_id' => 'required',
                    'city_id' => 'required',
        
                
        
                //  'workgroup_id' => 'required',
            ]);
        }
        if(RoleUser::where('user_id',Auth::id())->first()->role_id!=1)
        {
                $validator =Validator::make($request->all(), [

                    'project_role_id' => 'required',
                ]);

        }
        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        } 
        
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
        $validator =Validator::make($request->all(), [

            'password' => 'required',
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

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
		try {
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

		} catch (Exception $ex)
		{
			return $ex;
		}
        return redirect()->back();
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
            $validator =Validator::make($request->all(), [

                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);



            foreach ($array as $value) {


                if (isset($value[12]) && isset($value[11])  && isset($value[10])) {
                    $item = array();


                    $city = $this->getFromApi('GET', 'cities?name=' . $value[7] . '&company_id=' . $company->id);
                    $company_role = $this->getFromApi('GET', 'company_roles?title=' . $value[8]. '&company_id=' . $company->id);
                    $project_role = $this->getFromApi('GET', 'project_roles?title=' . $value[9]. '&company_id=' . $company->id);
                    $seniority = $this->getFromApi('GET', 'seniorities?title=' . $value[10]. '&company_id=' . $company->id);
                    $office = $this->getFromApi('GET', 'offices?title=' . $value[11]. '&company_id=' . $company->id);
                    $workgroup = $this->getFromApi('GET', 'workgroups?title=' . $value[12]. '&company_id=' . $company->id);

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
                        $item['timezone'] = $value[14];



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
