<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectKpiAlertController extends Controller
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
			'kpi_id'       => 'required',
			'project_id'   => 'required',
			'red_alert'    => 'required',
			'yellow_alert' => 'required',
			'green_alert'  => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'project_kpi_alerts', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.project_kpi_alert_store')]
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
    	$projectKpiAlert = $this->getFromApi('GET', 'project_kpi_alerts/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$kpis = $this->getFromApi('GET', 'kpis?company_id='.$company->id);

    	return response()->json([
    		'view' => view('project_kpi_alert/edit', [
				'projectKpiAlert'   => $projectKpiAlert,
				'company'   => $company,
				'kpis' => $kpis
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
			'id'           => 'required',
			'red_alert'    => 'required',
			'yellow_alert' => 'required',
			'green_alert'  => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'project_kpi_alerts/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.project_kpi_alert_store')]
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
    	$projectKpiAlert = $this->getFromApi('GET', 'project_kpi_alerts/'.$id);
    	$res = $this->apiCall('DELETE', 'project_kpi_alerts/'.$id);

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
    		return redirect('project/rows/'.$projectKpiAlert->project_id);
    	}
    	else
    	{
    		return redirect()->action('ProjectController@index');
    	}
    }
}
