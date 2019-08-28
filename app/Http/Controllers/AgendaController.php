<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class AgendaController extends Controller
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

        return view('agenda/index', [
			'company'  => $company,
			'projects' => $projects,
			'users'     => $users
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'company_id'     => 'required',
			'knowledge_area' => 'required',
			'item_number'    => 'required',
			'description'    => 'required',
			'start'          => 'required',
			'status'         => 'required',
			'due'            => 'required',
			'creator_id'     => 'required',
			'owner_id'       => 'required',
			'detail'         => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'agendas', $data);

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
    	$agenda = $this->getFromApi('GET', 'agendas/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

    	return response()->json([
    		'view' => view('agenda/edit', [
				'agenda'   => $agenda,
				'company'  => $company,
				'projects' => $projects,
				'users'    => $users
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
			'knowledge_area' => 'required',
			'item_number'    => 'required',
			'description'    => 'required',
			'start'          => 'required',
			'status'         => 'required',
			'due'            => 'required',
			'owner_id'       => 'required',
			'detail'         => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'agendas/'.$data['id'], $data);

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
    	$res = $this->apiCall('DELETE', 'agendas/'.$id);

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

    	return redirect()->action('AgendaController@index');
    }
}
