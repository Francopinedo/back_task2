<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class QuotationServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($quotation_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$quotation = $this->getFromApi('GET', 'quotation/'.$quotation_id);
    	$services = $this->getFromApi('GET', 'services?company_id='.$company->id);

    	return response()->json([
    		'view' => view('quotation_service/create', [
				'currencies'   => $currencies,
				'quotation'     => $quotation,
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

			'quotation_id' => 'required',
			'cost'        => 'numeric|required',
			'amount'        => 'numeric|required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'quotation_services', $data);

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

            $this->apiCall('GET', 'quotation/'.$request->quotation_id."/update_total");
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
    	$quotationService = $this->getFromApi('GET', 'quotation_services/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$services = $this->getFromApi('GET', 'services?company_id='.$company->id);
        $quotation = $this->getFromApi('GET', 'quotation/'.$quotationService->quotation_id);
    	return response()->json([
    		'view' => view('quotation_service/edit', [
				'quotationService'   => $quotationService,
				'currencies'        => $currencies,
				'services'        => $services,
				'quotation'        => $quotation,
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

    	$res = $this->apiCall('PATCH', 'quotation_services/'.$data['id'], $data);

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
            $this->apiCall('GET', 'quotation/'.$request->quotation_id."/update_total");
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
    	$quotationService = $this->getFromApi('GET', 'quotation_services/'.$id);
    	$res = $this->apiCall('DELETE', 'quotation_services/'.$id);

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
            $this->apiCall('GET', 'quotation/'.$jsonRes['data']['quotation_id']."/update_total");
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('quotations/rows/'.$quotationService->quotation_id);

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project/rows/'.$quotationService->quotation_id);
    	// }
    	// else
    	// {
    	// 	return redirect()->action('ProjectController@index');
    	// }
    }
}
