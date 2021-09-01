<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProcurementOfferController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($procurement_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$currencies = $this->getFromApi('GET', 'currencies');
    	$procurement = $this->getFromApi('GET', 'procurements/'.$procurement_id);
    	$providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);

    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

    	return response()->json([
    		'view' => view('procurement_offer/create', [
				'currencies'   => $currencies,
				'procurement'     => $procurement,
				'users'        => $users,
				'company'      => $company,
				'providers'      => $providers,
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

			'procurement_id'      => 'required',
			'cost'     => 'numeric|required',
			'description'         => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'procurement_offers', $data);

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
    	$procurementOffer = $this->getFromApi('GET', 'procurement_offers/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$currencies = $this->getFromApi('GET', 'currencies');
    	$providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);

    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

    	return response()->json([
    		'view' => view('procurement_offer/edit', [
				'procurementOffer' => $procurementOffer,
				'company'          => $company,
				'currencies'       => $currencies,
				'providers'        => $providers,
				'users'            => $users
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

			// 'project_role_id' => 'required',
			// 'seniority_id'    => 'required',
			// 'currency_id'     => 'required',
			// 'workplace'       => 'required',
			// 'load'            => 'required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'procurement_offers/'.$data['id'], $data);

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
    	$procurementOffer = $this->getFromApi('GET', 'procurement_offers/'.$id);
    	$res = $this->apiCall('DELETE', 'procurement_offers/'.$id);

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

    	return redirect('procurements/'.$procurementOffer->invoice_id.'/rows');

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project/rows/'.$projectExpense->project_id);
    	// }
    	// else
    	// {
    	// 	return redirect()->action('projectController@index');
    	// }
    }
}
