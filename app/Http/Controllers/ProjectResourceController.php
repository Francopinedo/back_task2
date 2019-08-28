<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($project_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$countries = $this->getFromApi('GET', 'countries');


    	$projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	$seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);


    	$currencies = $this->getFromApi('GET', 'currencies');
    	$project = $this->getFromApi('GET', 'projects/'.$project_id);

    	$users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));
        $offices = [];
        $cities = [];

    	return response()->json([
    		'view' => view('project_resource/create', [
				'currencies'   => $currencies,
				'project'     => $project,
				'projectRoles' => $projectRoles,
				'seniorities'  => $seniorities,
				'countries'        => $countries,
                'offices'       => $offices,
                'cities'       => $cities,
				'users'        => $users,
				'company'        => $company,
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
			'project_id'     => 'required',
			'project_role_id' => 'required',
			'seniority_id'    => 'required',
			'rate'         => 'required',

			'currency_id'     => 'required',
            'city_id'     => 'required',
            'country_id'     => 'required',
            'office_id'     => 'required',
			'workplace'       => 'required',
			'load'            => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'project_resources', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

	    	var_dump($jsonRes);
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

    	$projectResource = $this->getFromApi('GET', 'project_resources/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
        $countries = $this->getFromApi('GET', 'countries');
        $rate = $this->getFromApi('GET', 'rates/'.$projectResource->rate_id);

        $offices = $this->getFromApi('GET', 'offices?city_id='.$projectResource->city_id);
        $cities = $this->getFromApi('GET', 'cities?country_id='.$projectResource->country_id);
        $users = $this->getFromApi('GET', 'team_users?project_id='.session('project_id'));

    	return response()->json([
    		'view' => view('project_resource/edit', [
				'projectResource' => $projectResource,
				'currencies'       => $currencies,
				'projectRoles'     => $projectRoles,
				'seniorities'      => $seniorities,
				'rate'            => $rate,
				'countries'            => $countries,
				'users'            => $users,
				'company'            => $company,
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
			 'workplace'       => 'required',
			 'load'            => 'required',
            'city_id'     => 'required',
            'country_id'     => 'required',
            'office_id'     => 'required',
			 'rate'            => 'required',
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'project_resources/'.$data['id'], $data);

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
    	$projectExpense = $this->getFromApi('GET', 'project_resources/'.$id);
    	$res = $this->apiCall('DELETE', 'project_resources/'.$id);

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

    	return redirect('project_board/rows');

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
