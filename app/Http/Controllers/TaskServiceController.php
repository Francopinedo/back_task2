<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class TaskServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($task_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$task = $this->getFromApi('GET', 'tasks/'.$task_id);
    	$services = $this->getFromApi('GET', 'services?company_id='.$company->id);

    	return response()->json([
    		'view' => view('task_service/create', [
				'currencies'   => $currencies,
				'task'     => $task,
				'services'     => $services
			] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'task_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'task_services', $data);

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
    	$taskService = $this->getFromApi('GET', 'task_services/'.$id);
        $currencies = $this->getFromApi('GET', 'currencies');
    	$services = $this->getFromApi('GET', 'services?company_id='.$company->id);

    	return response()->json([
    		'view' => view('task_service/edit', [
				'taskService'   => $taskService,
				 'currencies'        => $currencies,
				'services'          => $services
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

			// 'cost'        => 'numeric|required'
			// 'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'task_services/'.$data['id'], $data);

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
    	$taskService = $this->getFromApi('GET', 'task_services/'.$id);
    	$res = $this->apiCall('DELETE', 'task_services/'.$id);

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

    	if (!isset($jsonRes))
    	{
    		return redirect('tasks/'.$taskService->task_id.'/rows');
    	}
    	else
    	{
    		return redirect()->action('TaskController@index');
    	}
    }
}
