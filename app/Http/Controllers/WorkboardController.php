<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class WorkboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$phases = $this->getFromApi('POST', 'tasks/phases', ['project_id' => session('project_id')]);

    	$tickets = [];
    	foreach ($phases as $phase)
    	{
    		$tickets[$phase->phase]	= $this->getFromApi('GET', 'tickets/by_phase?phase='.$phase->phase.'&user_id='.Auth::id());
    	}

    	// para el form de edit
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        return view('workboard/index', [
			'phases'   => $phases,
			'contacts'   => $contacts,
			'tickets'  => $tickets,
			'company'  => $company,
			'users'  => $users,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$ticket = $this->getFromApi('GET', 'tickets/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	//$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $users = $this->getFromApi('GET', 'task_resources?task_id=' . $ticket->task_id);
        $users2 = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

    	return response()->json([
    		'view' => view('ticket/edit', [
				'ticket' => $ticket,
				'contacts' => $contacts,
				'redirect' => 'workboard',
				'users'       => $users,
				'users2'       => $users2
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

			'description'     => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'tickets/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.ticket_store')]
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
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'tickets/'.$id);
    	$company = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('ticket/show', ['company' => $company] )->render(),
    	]);
    }
}
