<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Cost;

class CostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

    	$countries = $this->getFromApi('GET', 'countries');
    	$cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$project_roles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$currencies = $this->getFromApi('GET', 'currencies');



        return view('cost/index', [
			'countries'     => $countries,
			'cities'        => $cities,
			'seniorities'   => $seniorities,
			'project_roles' => $project_roles,
			'currencies'    => $currencies,
			'company'       => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$cost = $this->getFromApi('GET', 'costs/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

    	$countries = $this->getFromApi('GET', 'countries');
    	$cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$project_roles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$currencies = $this->getFromApi('GET', 'currencies');

    	return response()->json([
    		'view' => view('cost/edit', [
    			'cost' => $cost,
    			'countries'     => $countries,
				'cities'        => $cities,
				'seniorities'   => $seniorities,
				'project_roles' => $project_roles,
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
    	$this->validate($request, [
			'value'       => 'required',
			'project_role_id'   => 'required'
	    ]);

    	$data = $request->all();

    	// dd($data);

    	$res = $this->apiCall('POST', 'costs', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.cost_store')]
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
    	$this->validate($request, [
			'value'     => 'required',
			'project_role_id'   => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'costs/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.cost_store')]
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
    	$res = $this->apiCall('DELETE', 'costs/'.$id);

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

    	return redirect()->action('CostController@index');
    }
}
