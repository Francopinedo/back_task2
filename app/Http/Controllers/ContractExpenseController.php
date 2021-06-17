<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ContractExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($contract_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$contract = $this->getFromApi('GET', 'contracts/'.$contract_id);
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('contract_expense/create', [
				'currencies'   => $currencies,
				'contract'     => $contract,
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
    	$validator =Validator::make($request->all(), [

			'contract_id' => 'required',
			'cost'        => 'numeric|required',
			'amount'        => 'numeric|required',
			'frequency'        => 'required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'contract_expenses', $data);

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
    	$contractExpense = $this->getFromApi('GET', 'contract_expenses/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('contract_expense/edit', [
				'contractExpense'   => $contractExpense,
				'currencies'        => $currencies,
				'expenses'          => $expenses,
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
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'contract_expenses/'.$data['id'], $data);

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
    	$contractExpense = $this->getFromApi('GET', 'contract_expenses/'.$id);
    	$res = $this->apiCall('DELETE', 'contract_expenses/'.$id);

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
    		return redirect('contract/rows/'.$contractExpense->contract_id);
    	}
    	else
    	{
    		return redirect()->action('ContractController@index');
    	}
    }
}
