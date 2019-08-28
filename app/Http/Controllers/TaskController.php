<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
    	$project = $this->getFromApi('GET', 'projects/'.session('project_id'));
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
    	$requirements = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));
    	//$tasks = $this->getFromApi('GET', 'tasks?project_id='.session('project_id'));
    	$holidays = $this->getFromApi('GET', 'holidays?country_id='.$company->city->data->country_id.'&company_id='.$company->id);
    	$holidaysForGantt = '';
    	foreach ($holidays as $holiday)
    	{
    		$holidaysForGantt .= '#'.date('m', strtotime($holiday->date)).'_'.date('d', strtotime($holiday->date)).'#';
    	}

        return view('task/index', [
			'users'        => $users,
			//'tasks'        => $tasks,
			'requirements' => $requirements,
			'project' => $project,
			'holidaysForGantt' => $holidaysForGantt
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'description' => 'required',
			'project_id'  => 'required',
			'start_date'  => 'required',
			'due_date'  => 'required',
			'phase'       => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'tasks', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
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
    	$task = $this->getFromApi('GET', 'tasks/'.$id);
    	$project = array();
    	if(session()->has('project_id')){
            $project = $this->getFromApi('GET', 'projects/'.session('project_id'));
        }

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
    	$requirements = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));

    	return response()->json([
    		'view' => view('task/edit', [
				'task'  => $task,
				'project'  => $project,
				'users' => $users,
				'requirements' => $requirements,
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
			'description'     => 'required',
			'phase'     => 'required',
            'start_date'  => 'required',
            'due_date'  => 'required',
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'tasks/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
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
    	$res = $this->apiCall('DELETE', 'requirements/'.$id);

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

    	return redirect()->action('RequirementController@index');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'requirements/'.$id);
    	$company = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('task/show', ['company' => $company] )->render(),
    	]);
    }
}
