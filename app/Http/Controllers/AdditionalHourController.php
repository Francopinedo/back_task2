<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdditionalHourController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$users=[];

    	if(session()->has('project_id')){
            $users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));
        }




        $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);

        $offices = [];
        $cities = [];
        $currencies = $this->getFromApi('GET', 'currencies?company_id=' . $company->id);
        $countries = $this->getFromApi('GET', 'countries');

        return view('additional_hour/index', [
			'currencies'        => $currencies,
			'countries'        => $countries,
			'cities'        => $cities,
			'offices'        => $offices,
			'seniorities'        => $seniorities,
			'projectRoles'        => $projectRoles,
            'company'          => $company,

			'users'        => $users,

        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$additionalHour = $this->getFromApi('GET', 'additional_hours/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $users=[];

        if(session()->has('project_id')){
            $users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));
        }

        $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);

        $countries = $this->getFromApi('GET', 'countries');


        $currencies = $this->getFromApi('GET', 'currencies?company_id=' . $company->id);
        $cities = $this->getFromApi('GET', 'cities?country_id='.$additionalHour->country_id);
        $offices = $this->getFromApi('GET', 'offices?city_id='.$additionalHour->city_id);


    	return response()->json([
    		'view' => view('additional_hour/edit', [
				'additionalHour' => $additionalHour,
				'users'          => $users,

				'projectRoles'          => $projectRoles,
				'seniorities'          => $seniorities,
				'countries'          => $countries,
				'company'          => $company,

				'currencies'          => $currencies,
				'cities'          => $cities,
				'offices'          => $offices,
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

			'project_id' => 'required',
			'user_id'    => 'required',
			'project_role_id'    => 'required',
			'seniority_id'    => 'required',
			'office_id'    => 'required',
			'workplace'    => 'required',
			'city_id'    => 'required',
			'country_id'    => 'required',
			'currency_id'    => 'required',
			'rate'    => 'numeric|required',
			'date'       => 'required',
			'hours'      => 'numeric|required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        
            $rateres = $this->apiCall('GET', 'team_users/get_rate/'.$request->user_id);

            $rateapi=json_decode($rateres->getBody()->__toString(), TRUE);

        $rate=$rateapi+$request->rate;
        //var_dump($load);
        if($rateapi>100)
            {
          return response()->json(array('rate' => array('Total Rate is mayor than 100%')), 422);

                }else{
                    $data['rate']=$rateapi;
                }
      $get_sum_hoursres = $this->apiCall('GET', 'additional_hours/get_sum_hours/'.$request->user_id);

            $ratesumhours=json_decode($get_sum_hoursres->getBody()->__toString(), TRUE);
 
        if($ratesumhours>=24)
            {
          return response()->json(array('rate' => array('Total Additional Hours is mayor than 24')), 422);
                }
    	$res = $this->apiCall('POST', 'additional_hours', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.additional_hour_store')]
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

			'user_id'    => 'required',
			'date'       => 'required',
			'rate'       => 'numeric|required',
            'project_role_id'    => 'required',
            'seniority_id'    => 'required',
            'office_id'    => 'required',
            'currency_id'    => 'required',
            'workplace'    => 'required',
            'city_id'    => 'required',
            'country_id'    => 'required',
			'hours'      => 'numeric|required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

            $rateres = $this->apiCall('GET', 'team_users/get_rate/'.$request->user_id);

            $rateapi=json_decode($rateres->getBody()->__toString(), TRUE);

        $rate=$rateapi+$request->rate;
        //var_dump($load);
        if($rateapi>100)
            {
          return response()->json(array('rate' => array('Total Rate is mayor than 100%')), 422);

                }else{
                    $data['rate']=$rateapi;
                }

                  $get_sum_hoursres = $this->apiCall('GET', 'additional_hours/get_sum_hours/'.$request->user_id);

            $ratesumhours=json_decode($get_sum_hoursres->getBody()->__toString(), TRUE);
 
        if($ratesumhours>=24)
            {
          return response()->json(array('rate' => array('Total Additional Hours is mayor than 24')), 422);
                }

    	$res = $this->apiCall('PATCH', 'additional_hours/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.additional_hour_store')]
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
    	$res = $this->apiCall('DELETE', 'additional_hours/'.$id);

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

    	return redirect()->action('AdditionalHourController@index');
    }
}
