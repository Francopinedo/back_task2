<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class TaskExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($task_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$task = $this->getFromApi('GET', 'tasks/'.$task_id);
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('task_expense/create', [
				'currencies'   => $currencies,
				'task'     => $task,
				'expenses'     => $expenses
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
			'task_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'task_expenses', $data);

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
        $taskExpense = $this->getFromApi('GET', 'task_expenses/'.$id);
        $currencies = $this->getFromApi('GET', 'currencies');
        $expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('task_expense/edit', [
				'taskExpense'   => $taskExpense ,
				 'currencies'        => $currencies,
				'expenses'          => $expenses
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
			// 'cost'        => 'required',
			// 'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'task_expenses/'.$data['id'], $data);

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
    	$taskService = $this->getFromApi('GET', 'task_expenses/'.$id);
    	$res = $this->apiCall('DELETE', 'task_expenses/'.$id);

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
