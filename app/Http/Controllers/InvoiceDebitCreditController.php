<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class InvoiceDebitCreditController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($invoice_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$invoice = $this->getFromApi('GET', 'invoices/'.$invoice_id);
    	$debit_credits = $this->getFromApi('GET', 'debit_credits?company_id='.$company->id);

    	return response()->json([
    		'view' => view('invoice_debit_credit/create', [
				'currencies'   => $currencies,
				'invoice'     => $invoice,
				'debit_credits'     => $debit_credits,
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

			'invoice_id' => 'required',
			'cost'        => 'numeric|required',
			'amount'        => 'numeric|required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'invoice_debit_credit', $data);

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
            $this->apiCall('GET', 'invoices/'.$request->invoice_id."/update_total");
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
    	$invoicedebit_credit = $this->getFromApi('GET', 'invoice_debit_credit/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$debit_credits = $this->getFromApi('GET', 'debit_credits?company_id='.$company->id);
        $invoice = $this->getFromApi('GET', 'invoices/'.$invoicedebit_credit->invoice_id);
    	return response()->json([
    		'view' => view('invoice_debit_credit/edit', [
				'invoicedebit_credit'   => $invoicedebit_credit,
				'currencies'        => $currencies,
				'debit_credits'        => $debit_credits,
				'invoice'        => $invoice,
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
			 'amount'   => 'numeric|required',
			 'detail'   => 'required',
			 'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'invoice_debit_credit/'.$data['id'], $data);

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
            $this->apiCall('GET', 'invoices/'.$jsonRes['data']['invoice_id']."/update_total");
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
    	$invoicedebit_credit = $this->getFromApi('GET', 'invoice_debit_credit/'.$id);
    	$res = $this->apiCall('DELETE', 'invoice_debit_credit/'.$id);

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
            $this->apiCall('GET', 'invoices/'.$invoicedebit_credit->invoice_id."/update_total");

    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('invoices/rows/'.$invoicedebit_credit->invoice_id);

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project_board/project_rows/');
    	// }
    	// else
    	// {
    	// 	return redirect()->action('ProjectController@index');
    	// }
    }
}
