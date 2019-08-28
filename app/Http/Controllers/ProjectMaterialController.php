<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($contract_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$project = $this->getFromApi('GET', 'projects/'.session('project_id'));
    	$materials = $this->getFromApi('GET', 'materials?company_id='.$company->id);

    	return response()->json([
    		'view' => view('project_material/create', [
				'currencies'   => $currencies,
				'project'     => $project,
				'materials'     => $materials,
			] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'project_id' => 'required',
			'cost'        => 'required',
			'frequency'        => 'required',
			'amount'        => 'required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'project_materials', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.item_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$projectMaterial = $this->getFromApi('GET', 'project_materials/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$materials = $this->getFromApi('GET', 'materials?company_id='.$company->id);

    	return response()->json([
    		'view' => view('project_material/edit', [
				'projectMaterial'   => $projectMaterial,
				'currencies'        => $currencies,
				'materials'        => $materials,
			] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			 'cost'        => 'required',
			 'amount'        => 'required',
			 'detail'        => 'required',
			 'frequency'        => 'required',
			//'real_cost'   => 'required',
			 'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'project_materials/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.item_store')]
	    	)->validate();
    	}
    	else
    	{
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
    	$projectMaterial = $this->getFromApi('GET', 'project_materials/'.$id);
    	$res = $this->apiCall('DELETE', 'project_materials/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	session()->flash('message', __('api_errors.delete'));
			session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.delete')]
	    	)->validate();

    	}
    	else
    	{
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('project_board/rows/');

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project_board/rows/');
    	// }
    	// else
    	// {
    	// 	return redirect()->action('ProjectController@index');
    	// }
    }
}
