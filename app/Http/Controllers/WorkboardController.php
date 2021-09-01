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
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
       
    	// para el form de edit
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        return view('workboard/index', [
			'contacts'   => $contacts,
			'company'  => $company,
			'users'  => $users,
        ]);
    }

    public function grouping($group){
        $tickets = [];
        $groupedby = [];

        if($group == 'phase'){
            $groupedby = $this->getFromApi('POST', 'tasks/phases', ['project_id' => session('project_id')]);
            // Tickets por Phase
            foreach ($groupedby as $phase)
            {
                $tickets[$phase->phase] = $this->getFromApi('GET', 'tickets/by_phase?phase='.$phase->phase.'&user_id='.Auth::id());
            }
        }
        if($group == 'version'){
            $groupedby = $this->getFromApi('POST', 'tasks/version', ['project_id' => session('project_id')]);
            // Tickets por Version
            foreach ($groupedby as $v)
            {
                $tickets[$v->version]   = $this->getFromApi('GET', 'tickets/by_version?version='.$v->version.'&user_id='.Auth::id());
            }
        }
        if($group == 'release'){
            $groupedby = $this->getFromApi('POST', 'tasks/release', ['project_id' => session('project_id')]);
            // Tickets por Release
            foreach ($groupedby as $release)
            {
                $tickets[$release->release]   = $this->getFromApi('GET', 'tickets/by_release?release='.$release->release.'&user_id='.Auth::id());
            }
        }
        if($group == 'label'){
            $groupedby = $this->getFromApi('POST', 'tasks/label', ['project_id' => session('project_id')]);
            // Tickets por Label
            foreach ($groupedby as $label)
            {
                $tickets[$label->label]   = $this->getFromApi('GET', 'tickets/by_label?label='.$label->label.'&user_id='.Auth::id());
            }
        }
        if($group == 'sprint'){
            $groupedby = $this->getFromApi('POST', 'sprints/sprint', ['project_id' => session('project_id')]);
            // Tickets por Sprint
            foreach ($groupedby as $sprint)
            {
                $tickets[$sprint->short_name]   = $this->getFromApi('GET', 'tickets/by_sprint?sprint_id='.$sprint->id.'&user_id='.Auth::id());
            }
        }
        // para el form de edit
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

        return response()->json([
            'view' => view('workboard/grouping', [
                'contacts' => $contacts,
                'company' => $company,
                'users' => $users,
                'groupedby' => $groupedby,
                'tickets'  => $tickets,
                'group' => $group
            ] )->render()
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
        $sprints = array();

    	return response()->json([
    		'view' => view('ticket/edit', [
				'ticket' => $ticket,
				'contacts' => $contacts,
				'redirect' => 'workboard',
				'users'       => $users,
				'users2'       => $users2,
                'sprints' => $sprints,
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
