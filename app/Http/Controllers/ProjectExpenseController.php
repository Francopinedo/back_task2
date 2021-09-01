<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol', 'loglevel']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($project_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$project = $this->getFromApi('GET', 'projects/'.$project_id);
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('project_expense/create', [
				'currencies'   => $currencies,
				'project'     => $project,
				'expenses'     => $expenses,
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

			'project_id' => 'required',
			'cost'        => 'numeric|required',
			'amount'        => 'numeric|required',
			'frequency'        => 'required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'project_expenses', $data);

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
    	$projectExpense = $this->getFromApi('GET', 'project_expenses/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('project_expense/edit', [
				'projectExpense'   => $projectExpense,
				'currencies'        => $currencies,
				'expenses'        => $expenses
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

			 'cost'        => 'numeric|required',
			 'amount'        => 'numeric|required',
			 'detail'        => 'required',
			 'frequency'        => 'required',
			//'real_cost'        => 'required',
			 'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'project_expenses/'.$data['id'], $data);

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
    	$projectExpense = $this->getFromApi('GET', 'project_expenses/'.$id);
    	$res = $this->apiCall('DELETE', 'project_expenses/'.$id);

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

    	return redirect('project_board/project_rows');

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project/rows/'.$projectExpense->project_id);
    	// }
    	// else
    	// {
    	// 	return redirect()->action('ProjectController@index');
    	// }
    }
}
