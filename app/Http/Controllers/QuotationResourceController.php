<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class QuotationResourceController extends Controller
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

    	$projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$rates = $this->getFromApi('GET', 'rates?company_id='.$company->id);

    	$currencies = $this->getFromApi('GET', 'currencies');
    	$quotation = $this->getFromApi('GET', 'quotation/'.$quotation_id);

        $users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));
        $offices = [];
        $cities = [];
        $countries = $this->getFromApi('GET', 'countries?company_id=' . $company->id);
    	return response()->json([
    		'view' => view('quotation_resource/create', [
				'currencies'   => $currencies,
				'quotation'     => $quotation,
				'projectRoles' => $projectRoles,
				'seniorities'  => $seniorities,
				'rates'        => $rates,
				'users'        => $users,
				'company'      => $company,
                'countries'        => $countries,
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
    	$validator =Validator::make($request->all(), [

			'quotation_id'      => 'required',
			'currency_id'     => 'required',
			'user_id'         => 'required',
            'city_id'     => 'required',
            'country_id'     => 'required',
            'office_id'     => 'required',
			'load'            => 




'numeric|required',
			'rate'            => 




'numeric|required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'quotation_resources', $data);

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

    	$projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);
    	$rates = $this->getFromApi('GET', 'rates?company_id='.$company->id);

    	$quotationResource = $this->getFromApi('GET', 'quotation_resources/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');

        $users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));
        $countries = $this->getFromApi('GET', 'countries');
        $offices = $this->getFromApi('GET', 'offices?city_id='.$quotationResource->city_id);
        $cities = $this->getFromApi('GET', 'cities?country_id='.$quotationResource->country_id);
        $rate = $this->getFromApi('GET', 'rates/'.$quotationResource->rate_id);
        $quotation = $this->getFromApi('GET', 'quotation/'.$quotationResource->quotation_id);

    	return response()->json([
    		'view' => view('quotation_resource/edit', [
				'quotationResource'  => $quotationResource,
				'currencies'       => $currencies,
				'projectRoles'     => $projectRoles,
				'seniorities'      => $seniorities,
				'rates'            => $rates,
				'users'            => $users,
				'company'      => $company,
				'quotation'      => $quotation,
                'rate'            => $rate,
                'countries'            => $countries,
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
    	$validator =Validator::make($request->all(), [

            'city_id'     => 'required',
            'country_id'     => 'required',
            'office_id'     => 'required',
			 'project_role_id' => 'required',
			 'seniority_id'    => 'required',
			 'currency_id'     => 'required',
			 'workplace'       => 'required',
			 'load'            => 'numeric|required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'quotation_resources/'.$data['id'], $data);

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
    	$quotationResource = $this->getFromApi('GET', 'quotation_resources/'.$id);
    	$res = $this->apiCall('DELETE', 'quotation_resources/'.$id);

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
            $this->apiCall('GET', 'quotation/'.$quotationResource->quotation_id."/update_total");
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('quotations/rows/'.$quotationResource->quotation_id);

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
