<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$countries = $this->getFromApi('GET', 'countries');
        $offices = $this->getFromApi('GET', 'offices?company_id='.$company->id);
    	$cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);
    	$project_roles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$currencies = $this->getFromApi('GET', 'currencies');

        return view('rate/index', [
			'countries'     => $countries,
			'cities'        => $cities,
			'project_roles' => $project_roles,
			'seniorities' => $seniorities,
			'currencies'    => $currencies,
			'company'       => $company,
			'offices'       => $offices,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$rate = $this->getFromApi('GET', 'rates/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$countries = $this->getFromApi('GET', 'countries');

        $cities = $this->getFromApi('GET', 'cities?company_id='.$company->id."&country_id=".$rate->country_id);
        $offices = $this->getFromApi('GET', 'offices?company_id='.$company->id."&city_id=".$rate->city_id);
    	$project_roles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$currencies = $this->getFromApi('GET', 'currencies');

    	return response()->json([
    		'view' => view('rate/edit', [
    			'rate' => $rate,
    			'countries'     => $countries,
				'cities'        => $cities,
				'project_roles' => $project_roles,
				'seniorities'   => $seniorities,
				'offices'   => $offices,
				'currencies'    => $currencies
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

			'company_id'      => 'required',
			'country_id'      => 'required',
			'title'           => 'required',
			'value'           => 'numeric|required',
			'currency_id'     => 'required',
			'workplace'       => 'required',
			'project_role_id' => 'required',
			'office_id' => 'required',
			'seniority_id'    => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'rates', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.rate_store')]
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
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'country_id'  => 'required',
			'title'       => 'required',
			'value'       => 'numeric|required',
			'currency_id' => 'required',
			'office_id' => 'required',
			'workplace'   => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'rates/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.rate_store')]
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
    	$res = $this->apiCall('DELETE', 'rates/'.$id);

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

    	return redirect()->action('RateController@index');
    }
}
