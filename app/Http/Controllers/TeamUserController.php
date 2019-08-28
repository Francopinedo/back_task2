<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class TeamUserController extends Controller
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
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $office = $this->getFromApi('GET', 'offices/?company_id'.Auth::id());
        $countries = $this->getFromApi('GET', 'countries/');
        $cities = $this->getFromApi('GET', 'cities/?company_id='.$company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);

        $companyRoles = $this->getFromApi('GET', 'company_roles?company_id='.$company->id);
        $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
        return view('team_user/index', [
			'projects' => $projects,
			'users'    => $users,
			'company'  => $company,
			'seniorities'  => $seniorities,
			'countries'  => $countries,
            'companyRoles' => $companyRoles,
            'projectRoles' => $projectRoles,
			'cities'  => $cities,
            'office'    => $office
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$teamUser = $this->getFromApi('GET', 'team_users/'.$id);
    	$workinghours = $this->getFromApi('GET', 'working_hours/?user_id='.$teamUser->user_id.'&project_id='.$teamUser->project_id);

    	$user =  $this->getFromApi('GET', 'users/'.$teamUser->user_id);
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $office = $this->getFromApi('GET', 'offices/'.$teamUser->office_id);
        $project = $this->getFromApi('GET', 'projects/'.$teamUser->project_id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id='.$company->id);


        $countries = $this->getFromApi('GET', 'countries/');

        $cities = $this->getFromApi('GET', 'cities/?country_id='.$teamUser->country_id.'&company_id='.$company->id);
        $offices = $this->getFromApi('GET', 'offices/?city_id='.$teamUser->city_id);
        $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
    	return response()->json([
    		'view' => view('team_user/edit', [
				'teamUser' => $teamUser,
				'projects' => $projects,
				'projectRoles' => $projectRoles,
				'seniorities' => $seniorities,

				'users'    => $users,
				'office'    => $office,
				'company'    => $company,

				'countries'    => $countries,
				'cities'    => $cities,
				'project'    => $project,
				'offices'    => $offices,
				'user'    => $user,
				'from'    => $workinghours[0]->date,
				'to'    => $workinghours[sizeof($workinghours)-1]->date,
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
			'project_id' => 'required',
			'user_id'    => 'required',
			'load'    => 'numeric|min:1|max:100',
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'team_users', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

	    	//var_dump($jsonRes);
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.team_user_store')]
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
			'project_id' => 'required',
			'user_id'    => 'required',
            'load'    => 'numeric|min:1|max:100',
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'team_users/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	var_dump($jsonRes);
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.team_user_store')]
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
    	$res = $this->apiCall('DELETE', 'team_users/'.$id);

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

    	return redirect()->action('TeamUserController@index');
    }
}
