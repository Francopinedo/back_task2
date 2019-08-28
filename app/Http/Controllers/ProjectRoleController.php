<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class ProjectRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra listado
     */
    public function index()
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        return view('project_role/index', [
            'company' => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $project_role = $this->getFromApi('GET', 'project_roles/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        return response()->json([
            'view' => view('project_role/edit', [
                'project_role' => $project_role
            ])->render()
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = $request->all();

        $res = $this->apiCall('POST', 'project_roles', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_roles_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    public function update(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'title' => 'required'
        ]);

        $data = $request->all();

        $res = $this->apiCall('PATCH', 'project_roles/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_role_store')]
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
    public function delete($id)
    {
        $res = $this->apiCall('DELETE', 'project_roles/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');

            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_role_delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('ProjectRoleController@index');
    }

    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('project_role/import', [

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

                if (isset($value[0])) {
                    $item = array();


                    $item['title'] = $value[0];
                    $item['company_id'] = $company->id;

                    $this->apiCall('POST', 'project_roles', $item);

                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }




    /**
     * Form para crear template de studios
     */
    // public function create()
    // {
    // 	return view('studio_template/create');
    // }

    /**
     * Form para editar template de studio
     * @param  int $id ID
     */
    // public function edit($id){
    // 	$studioTemplate = StudioTemplate::find($id);

    // 	return response()->json([
    // 		'view' => view('studio_template/edit', ['studioTemplate' => $studioTemplate] )->render(),
    // 	]);
    // }

    /**
     * Crear nuevo template de studio
     */
    //  public function store(Request $request)
    //  {
    //  	// validacion del formulario
    //  	$this->validate($request, [
    // 'title'     => 'required'
    //   ]);

    //  	$data = $request->all();

    //  	$res = $this->apiCall('POST', 'seniorities_roles', $data);


    //  	// validacion de la respuesta del api
    //  	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    //  	{
    //   	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
    //   	Validator::make($jsonRes,
    //   		['status_code' => [Rule::in(['201', '200'])]],
    //   		['in' => __('api_errors.seniorities_roles_store')]
    //   	)->validate();
    //  	}
    //  	else
    //  	{
    //  		session()->flash('message', __('general.added'));
    // session()->flash('alert-class', 'success');
    //  	}

    //  	return response()->json();
    //  }

    /**
     * Actualizo idioma
     */
    //  public function update(Request $request)
    //  {
    //  	// validacion del formulario
    //  	$this->validate($request, [
    // 'title'     => 'required'
    //   ]);

    //  	$data = $request->all();

    //  	$res = $this->apiCall('PATCH', 'seniorities_roles/'.$data['id'], $data);

    //  	// validacion de la respuesta del api
    //  	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    //  	{
    //   	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
    //   	Validator::make($jsonRes,
    //   		['status_code' => [Rule::in(['201', '200'])]],
    //   		['in' => __('api_errors.seniorities_roles_store')]
    //   	)->validate();
    //  	}
    //  	else
    //  	{
    //  		session()->flash('message', __('general.updated'));
    // session()->flash('alert-class', 'success');
    //  	}

    //  	return response()->json();
    //  }

    /**
     * Elimina una seniority
     * @param  int $id ID
     */
    //  public function delete($id)
    //  {
    //  	$res = $this->apiCall('GET', 'project_roles/'.$id);
    //  	$projectRole = json_decode($res->getBody()->__toString(), TRUE);

    //  	$res = $this->apiCall('DELETE', 'project_roles/'.$id);

    //  	// validacion de la respuesta del api
    //  	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    //  	{
    //   	session()->flash('message', __('api_errors.delete'));
    // session()->flash('alert-class', 'danger');

    //   	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
    //   	Validator::make($jsonRes,
    //   		['status_code' => [Rule::in(['201', '200'])]],
    //   		['in' => __('api_errors.delete')]
    //   	)->validate();

    //  	}
    //  	else
    //  	{
    //  		session()->flash('message', __('general.deleted'));
    // session()->flash('alert-class', 'success');
    //  	}

    //  	return redirect('companies/'.$projectRole['data']['company_id'].'/preferences');
    //  }
}
