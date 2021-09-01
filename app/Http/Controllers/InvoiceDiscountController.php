<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class InvoiceDiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($invoice_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$invoice = $this->getFromApi('GET', 'invoices/'.$invoice_id);
    	$discounts = $this->getFromApi('GET', 'discounts?company_id='.$company->id);

    	return response()->json([
    		'view' => view('invoice_discount/create', [
				'currencies'   => $currencies,
				'invoice'     => $invoice,
				'discounts'     => $discounts,
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
			'amount'        => 'numeric|required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'invoice_discounts', $data);

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
    	$invoicediscount = $this->getFromApi('GET', 'invoice_discounts/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$discounts = $this->getFromApi('GET', 'discounts?company_id='.$company->id);
        $invoice = $this->getFromApi('GET', 'invoices/'.$invoicediscount->invoice_id);
    	return response()->json([
    		'view' => view('invoice_discount/edit', [
				'invoicediscount'   => $invoicediscount,
				'currencies'        => $currencies,
				'discounts'        => $discounts,
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

			// 'cost'        => 'numeric|required'
			// 'real_cost'   => 'required',
			// 'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'invoice_discounts/'.$data['id'], $data);

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
    	$invoicediscount = $this->getFromApi('GET', 'invoice_discounts/'.$id);
    	$res = $this->apiCall('DELETE', 'invoice_discounts/'.$id);

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
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);
            $this->apiCall('GET', 'invoices/'.$jsonRes['data']['invoice_id']."/update_total");
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('invoices/rows/'.$invoicediscount->invoice_id);

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
