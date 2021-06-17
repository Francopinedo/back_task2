<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SprintsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index($project_id)
    {
    		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
           $project = $this->getFromApi('GET', 'projects/' . $project_id);
        	$customers = $this->getFromApi('GET', 'customers?include=industry,city,currency&company_id='.$company->id);

    	$time_statuss=array('Not Started Yet','Started','Finish');
	$task_statuss=array('Not Completed Yet','Pending','Completed');


        return view('sprints/index', [

			'project' => $project,
			'customers' => $customers,
			'time_statuss'=>$time_statuss,
			'task_statuss'=>$task_statuss
        ]);
    }


    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'customer_id' => 'required',
			'project_id'  => 'required',
			'start_date'  => 'required',
			'finish_date'  => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'sprints', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
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


	$sprints = $this->getFromApi('GET', 'sprints/'.$id);
    		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
           $project = $this->getFromApi('GET', 'projects/' . $sprints->project_id);
        	$customers = $this->getFromApi('GET', 'customers?include=industry,city,currency&company_id='.$company->id);
	$time_statuss=array('Not Started Yet','Started','Finish');
	$task_statuss=array('Not Completed Yet','Pending','Completed');

    	

    	return response()->json([
    		'view' => view('sprints/edit', [
				'sprints'=>$sprints,	
				'project' => $project,
			'customers' => $customers,
			'time_statuss'=>$time_statuss,
			'task_statuss'=>$task_statuss
    		] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {


    	// validacion del formulario
    	$validator =Validator::make($request->all(), [
			'customer_id' => 'required',
			'project_id'  => 'required',
			'start_date'  => 'required',
			'finish_date'  => 'required'
		
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'sprints/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
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
    	$sprints = $this->getFromApi('GET', 'sprints/'.$id);

    	$res = $this->apiCall('DELETE', 'sprints/'.$id);

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

            return redirect('sprints/' . $sprints->project_id . '');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'sprints/'.$id);
    	$sprints = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('sprints/show', ['sprints' => $sprints] )->render(),
    	]);
    }
}
