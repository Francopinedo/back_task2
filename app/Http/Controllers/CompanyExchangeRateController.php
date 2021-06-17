<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\ExchangeRate;

class CompanyExchangeRateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index($company_id)
    {
    	$res = $this->apiCall('GET', 'currencies');
    	$currencies = json_decode($res->getBody()->__toString())->data;

		$res = $this->apiCall('GET', 'companies/'.$company_id);
    	$company = json_decode($res->getBody()->__toString())->data;

        return view('company_exchange_rate/index', [
        	'currencies' => $currencies,
        	'company' => $company,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($company_id, $id){
    	$exchangeRate = ExchangeRate::find($id);

    	$res = $this->apiCall('GET', 'currencies');
    	$currencies = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('company_exchange_rate/edit', [
    			'exchangeRate' => $exchangeRate,
    			'currencies' => $currencies,
    			'company_id' => $company_id
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

			'currency_id' => 'required',
			'company_id'  => 'required',
			'value'       => 'numeric|required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'exchange_rates', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.exchange_rate_store')]
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
     * Actualizo
     */
    public function update($company_id, Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'currency_id' => 'required',
			'company_id'  => 'required',
			'value'       => 'numeric|required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'exchange_rates/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.exchage_rate_store')]
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
    public function delete($company_id, $id)
    {
    	$res = $this->apiCall('DELETE', 'exchange_rates/'.$id);

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

    	// return redirect()->route('companies', ['id' => 1]);
    	return redirect()->action('CompanyExchangeRateController@index', ['company_id' => $company_id]);
    }
}
