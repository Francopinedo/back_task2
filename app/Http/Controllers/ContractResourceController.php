<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ContractResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($contract_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$rates = $this->getFromApi('GET', 'rates?company_id='.$company->id);
        $offices = [];
        $cities = [];
    	$currencies = $this->getFromApi('GET', 'currencies?company_id=' . $company->id);
    	$contract = $this->getFromApi('GET', 'contracts/'.$contract_id);
        $countries = $this->getFromApi('GET', 'countries');
    	return response()->json([
    		'view' => view('contract_resource/create', [
				'currencies'   => $currencies,
				'contract'     => $contract,
				'countries'     => $countries,
				'projectRoles' => $projectRoles,
				'seniorities'  => $seniorities,
				'rates'        => $rates,
				'company'      => $company,
                'offices'       => $offices,
                'cities'       => $cities,
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
			'contract_id'     => 'required',
			'project_role_id' => 'required',
			'seniority_id'    => 'required',
			'rate'            => 'required',

		//	'rate_id'            => 'required',
			'currency_id'     => 'required',
            'city_id'     => 'required',
            'country_id'     => 'required',
            'office_id'     => 'required',
			'workplace'       => 'required',
			'qty'             => 'required',
            'load'            => 'required|numeric|max:100'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'contract_resources', $data);

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


    	$projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);

        $countries = $this->getFromApi('GET', 'countries');
    	$contractResource = $this->getFromApi('GET', 'contract_resources/'.$id);
        $rate = $this->getFromApi('GET', 'rates/'.$contractResource->rate_id);
        $currencies = $this->getFromApi('GET', 'currencies?company_id=' . $company->id);
        $cities = $this->getFromApi('GET', 'cities?country_id='.$contractResource->country_id);
        $offices = $this->getFromApi('GET', 'offices?city_id='.$contractResource->city_id);
    	return response()->json([
    		'view' => view('contract_resource/edit', [
				'contractResource' => $contractResource,
				'currencies'       => $currencies,
				'projectRoles'     => $projectRoles,
				'seniorities'      => $seniorities,
				'rate'            => $rate,
				'countries'            => $countries,
				'company'          => $company,
                'offices'       => $offices,
                'cities'       => $cities,
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
			'project_role_id' => 'required',
			'seniority_id'    => 'required',
			'currency_id'     => 'required',
			//'rate_id'     => 'required',
            'city_id'     => 'required',
			'country_id'     => 'required',
			'office_id'     => 'required',
			'rate'     => 'required',
			'workplace'       => 'required',
			'qty'             => 'required',
			'load'            => 'required|numeric|max:100'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'contract_resources/'.$data['id'], $data);

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
    	$contractExpense = $this->getFromApi('GET', 'contract_resources/'.$id);
    	$res = $this->apiCall('DELETE', 'contract_resources/'.$id);

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
