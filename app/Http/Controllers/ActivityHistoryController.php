<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ActivityHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'agenda_id'   => 'required',
			'date'        => 'required',
			'description' => 'required',
			'follower_id' => 'required',
			'due'         => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'activities_history', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.agenda_store')]
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
    	$activityHistory = $this->getFromApi('GET', 'activities_history/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$agenda = $this->getFromApi('GET', 'agendas/'.$activityHistory->agenda_id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

    	return response()->json([
    		'view' => view('activity_history/edit', [
				'activityHistory'   => $activityHistory,
				'company'   => $company,
				'agenda'  => $agenda,
				'users' => $users
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
			'date'        => 'required',
			'description' => 'required',
			'follower_id' => 'required',
			'due'         => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'activities_history/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.agenda_store')]
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
    	$activityHistory = $this->getFromApi('GET', 'activities_history/'.$id);
    	$res = $this->apiCall('DELETE', 'activities_history/'.$id);

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
    		return redirect('agenda/rows/'.$activityHistory->agenda_id);
    	}
    	else
    	{
    		return redirect()->action('AgendaController@index');
    	}
    }
}
