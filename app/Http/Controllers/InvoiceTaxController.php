<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class InvoiceTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($invoice_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$invoice = $this->getFromApi('GET', 'invoices/'.$invoice_id);
    	$taxes = $this->getFromApi('GET', 'taxes?company_id='.$company->id);

    	return response()->json([
    		'view' => view('invoice_tax/create', [
				'currencies'   => $currencies,
				'invoice'     => $invoice,
				'taxes'     => $taxes,
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
			'invoice_id' => 'required',
			'amount'        => 'required',
			'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'invoice_taxes', $data);

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
    	$invoicetax = $this->getFromApi('GET', 'invoice_taxes/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$taxes = $this->getFromApi('GET', 'taxes?company_id='.$company->id);
        $invoice = $this->getFromApi('GET', 'invoices/'.$invoicetax->invoice_id);
    	return response()->json([
    		'view' => view('invoice_tax/edit', [
				'invoicetax'   => $invoicetax,
				'currencies'        => $currencies,
				'taxes'        => $taxes,
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
    	$this->validate($request, [
			// 'cost'        => 'required',
			// 'real_cost'   => 'required',
			// 'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'invoice_taxes/'.$data['id'], $data);

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
    	$invoicetax = $this->getFromApi('GET', 'invoice_taxes/'.$id);
    	$res = $this->apiCall('DELETE', 'invoice_taxes/'.$id);

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

    	return redirect('invoices/rows/'.$invoicetax->invoice_id);

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
