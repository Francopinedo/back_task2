<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class QuotationExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($quotation_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$quotation = $this->getFromApi('GET', 'quotation/'.$quotation_id);
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);

    	return response()->json([
    		'view' => view('quotation_expense/create', [
				'currencies'   => $currencies,
				'quotation'     => $quotation,
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

			'quotation_id'  => 'required',
			'cost'        => 'numeric|required',
			'amount'        => 'numeric|required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'quotation_expenses', $data);

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

             $this->apiCall('GET', 'quotations/'.$request->quotation_id."/update_total");


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
    	$quotationExpense = $this->getFromApi('GET', 'quotation_expenses/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$expenses = $this->getFromApi('GET', 'expenses?company_id='.$company->id);
        $quotation = $this->getFromApi('GET', 'quotation/'.$quotationExpense->quotation_id);
    	return response()->json([
    		'view' => view('quotation_expense/edit', [
				'quotationExpense'   => $quotationExpense,
				'currencies'        => $currencies,
				'expenses'        => $expenses,
				'quotation'        => $quotation
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
			 'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'quotation_expenses/'.$data['id'], $data);

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
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);
            $this->apiCall('GET', 'quotation/'.$jsonRes['data']['quotation_id']."/update_total");
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
    	$quotationExpense = $this->getFromApi('GET', 'quotation_expenses/'.$id);
    	$res = $this->apiCall('DELETE', 'quotation_expenses/'.$id);

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
            $this->apiCall('GET', 'quotation/'.$quotationExpense->quotation_id."/update_total");
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('quotations/rows/'.$quotationExpense->quotation_id);

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('quotation/rows/'.$quotationExpense->quotation_id);
    	// }
    	// else
    	// {
    	// 	return redirect()->action('quotationController@index');
    	// }
    }
}
