<?php

namespace App\Http\Controllers;

use DB;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use Dingo\Api\Routing\Helpers;
use Yajra\Datatables\Datatables;
use Transformers\TicketTransformer;

/**
 * Modulo de Ticket
 *
 * @Resource("Group Ticket")
 */
class TicketController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("tickets{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Ticket::select('tickets.*');

  		if ($request->has('task_id'))
  		{
  			$query->where('tickets.task_id', $request->task_id);
  		}
        if ($request->has('type'))
      {
        $query->where('tickets.type', $request->type);
      }

        if ($request->has('project_id'))
      {
        $query->where('tasks.project_id', $request->project_id);
      }
        if ($request->has('status'))
      {
        $query->where('tickets.status', $request->status);
      }
        if ($request->has('due_date_from') && $request->has('due_date_to'))
      {
        $query->where('tickets.due_date','>', $request->due_date_from)->where('tickets.due_date','<=', $request->due_date_to);
      }

  		$tickets = $query->get();

  		return $this->response->collection($tickets, new TicketTransformer);
  	}


  	/**
	 * Obtener por phase
	 *
	 * @Get("tickets/by_phase{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function byPhase(Request $request)
  	{
  		if (!$request->has('phase') || !$request->has('user_id'))
  		{
  			return ['data' => []];
  		}

  		$user = User::find($request->user_id);

  		$query = Ticket::select(
  			'tickets.*',
  			'tasks.description as task_description',
  			'users.name AS owner_name', 'users.id AS owner_id',
  			'workgroups.title AS workgroup_title',
  			'workgroups.id AS workgroup_id',
				'customers.id as customer_id',
				'projects.id as project_id'
  		);

			$query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
			$query->join('projects', 'tasks.project_id', '=', 'projects.id');
			$query->join('customers', 'projects.customer_id', '=', 'customers.id');
			$query->leftJoin('ticket_histories', 'tickets.id', '=', 'ticket_histories.ticket_id');
			$query->leftJoin('users', 'users.id', '=', 'tickets.owner_id');
			$query->leftJoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');
			$query->where('tasks.phase', $request->phase);
			//	$query->where('workgroups.id', $user->workgroup_id);
			$query->groupBy('tickets.id');

			$tickets = $query->get();

			return ['data' => $tickets];
  	}

		/**
		* Obtener por version
		*
		* @Get("tickets/by_version{?include}")
		* @Parameters({
		 *      @Parameter("include", description="Tablas relacionadas", default=1),
		 * })
		* @Transaction({
		*   	@Response(200, body={
		*   		"id": "int"
		*   	})
		* })
		*/
  	public function byVersion(Request $request)
  	{
  		if (!$request->has('version') || !$request->has('user_id'))
  		{
  			return ['data' => []];
  		}

  		$user = User::find($request->user_id);

  		$query = Ticket::select(
  			'tickets.*',
  			'tasks.description as task_description',
  			'users.name AS owner_name', 'users.id AS owner_id',
  			'workgroups.title AS workgroup_title',
  			'workgroups.id AS workgroup_id',
				'customers.id as customer_id',
				'projects.id as project_id'
  		);

			$query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
			$query->join('projects', 'tasks.project_id', '=', 'projects.id');
			$query->join('customers', 'projects.customer_id', '=', 'customers.id');
			$query->leftJoin('ticket_histories', 'tickets.id', '=', 'ticket_histories.ticket_id');
			$query->leftJoin('users', 'users.id', '=', 'tickets.owner_id');
			$query->leftJoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');

			$query->where('tasks.version', $request->version);
			//	$query->where('workgroups.id', $user->workgroup_id);
			$query->groupBy('tickets.id');

			$tickets = $query->get();

			return ['data' => $tickets];
  	}

  	/**
	 * Obtener por release
	 *
	 * @Get("tickets/by_release{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function byRelease(Request $request)
  	{
  		if (!$request->has('release') || !$request->has('user_id'))
  		{
  			return ['data' => []];
  		}

  		$user = User::find($request->user_id);

  		$query = Ticket::select(
  			'tickets.*',
  			'tasks.description as task_description',
  			'users.name AS owner_name', 'users.id AS owner_id',
  			'workgroups.title AS workgroup_title',
  			'workgroups.id AS workgroup_id',
				'customers.id as customer_id',
				'projects.id as project_id'
  		);

			$query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
			$query->join('projects', 'tasks.project_id', '=', 'projects.id');
			$query->join('customers', 'projects.customer_id', '=', 'customers.id');
			$query->leftJoin('ticket_histories', 'tickets.id', '=', 'ticket_histories.ticket_id');
			$query->leftJoin('users', 'users.id', '=', 'tickets.owner_id');
			$query->leftJoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');

			$query->where('tasks.release', $request->release);
			//	$query->where('workgroups.id', $user->workgroup_id);
			$query->groupBy('tickets.id');

			$tickets = $query->get();

			return ['data' => $tickets];
  	}

  	/**
	 * Obtener por label
	 *
	 * @Get("tickets/by_label{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function byLabel(Request $request)
  	{
  		if (!$request->has('label') || !$request->has('user_id'))
  		{
  			return ['data' => []];
  		}

  		$user = User::find($request->user_id);

  		$query = Ticket::select(
  			'tickets.*',
  			'tasks.description as task_description',
  			'users.name AS owner_name', 'users.id AS owner_id',
  			'workgroups.title AS workgroup_title',
  			'workgroups.id AS workgroup_id',
				'customers.id as customer_id',
				'projects.id as project_id'
  		);

			$query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
			$query->join('projects', 'tasks.project_id', '=', 'projects.id');
			$query->join('customers', 'projects.customer_id', '=', 'customers.id');
			$query->leftJoin('ticket_histories', 'tickets.id', '=', 'ticket_histories.ticket_id');
			$query->leftJoin('users', 'users.id', '=', 'tickets.owner_id');
			$query->leftJoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');
			$query->where('tasks.label', $request->label);
			//	$query->where('workgroups.id', $user->workgroup_id);
			$query->groupBy('tickets.id');

			$tickets = $query->get();

			return ['data' => $tickets];
  	}

  	/**
	 * Obtener por sprint
	 *
	 * @Get("tickets/by_sprint{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function bySprint(Request $request)
  	{
  		if (!$request->has('sprint_id') || !$request->has('user_id'))
  		{
  			return ['data' => []];
  		}

  		$user = User::find($request->user_id);

  		$query = Ticket::select(
  			'tickets.*',
  			'tasks.description as task_description',
  			'users.name AS owner_name', 'users.id AS owner_id',
  			'workgroups.title AS workgroup_title',
  			'workgroups.id AS workgroup_id',
				'customers.id as customer_id',
				'projects.id as project_id'
  		);

			$query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
			$query->join('projects', 'tasks.project_id', '=', 'projects.id');
			$query->join('customers', 'projects.customer_id', '=', 'customers.id');
			$query->join('sprints', 'sprints.id', '=', 'tickets.sprint_id');
			$query->leftJoin('ticket_histories', 'tickets.id', '=', 'ticket_histories.ticket_id');
			$query->leftJoin('users', 'users.id', '=', 'tickets.owner_id');
			$query->leftJoin('workgroups', 'workgroups.id', '=', 'users.workgroup_id');
			$query->where('sprints.id', $request->sprint_id);
			//	$query->where('workgroups.id', $user->workgroup_id);
			$query->groupBy('tickets.id');

			$tickets = $query->get();

			return ['data' => $tickets];
  	}


  	/**
	 * Crear compania
	 *
	 * @Post("tickets")
	 * @Request({
     *  		"description": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('description') || !$request->has('assignee_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $ticket = Ticket::create($data);

        if ($ticket)
        {
        	// creo el primer ticket history
        	$data = [
				'ticket_id'            => $ticket->id,
				'date'                 => date('Y-m-d'),
				'internal_or_external' => 'internal',
				'comment'              => 'Ticket created',
				'owner_id'             => $ticket->assignee_id
        	];

        	TicketHistory::create($data);

        	return $this->response->item($ticket, new TicketTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener compania
	 *
	 * @Get("tickets/{id}{?include}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$ticket = Ticket::findOrFail($id);

  		return $this->response->item($ticket, new TicketTransformer);
  	}

  	/**
	 * Editar compania
	 *
	 * @Patch("tickets/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"description": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$ticket = Ticket::find($id);
  		if ($ticket == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $ticket->update($data);

        if ($ticket)
        {
        	// Creo otro ticket history
        	$data = [
				'ticket_id'            => $ticket->id,
				'date'                 => date('Y-m-d'),
				'internal_or_external' => 'internal',
				'comment'              => $ticket->comment,
				'owner_id'             => $ticket->owner_id
        	];

        	TicketHistory::create($data);

        	return $this->response->item($ticket, new TicketTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una compania
     *
     * @Delete("tickets/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
  	public function destroy($id)
  	{
  		$ticket = Ticket::find($id);

        if ($ticket == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $ticket->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener companias
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("tickets/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('tickets')
                    ->select(
                    	'tickets.id',
                    	'tickets.task_id',
                    	'tickets.description',
                    	'tickets.type',
                    	'tickets.assignee_id',
                    	'tickets.status',
                    	'tickets.group',
                    	'tickets.last_updater_id',
                    	'tickets.due_date',
                    	'tickets.requester_name',
                    	'tickets.requester_email',
                    	'tickets.requester_type',
                    	'tickets.priority',
                    	'tickets.severity',
                    	'tickets.probability',
                    	'tickets.impact',
                    	'tickets.estimated_hours',
                    	'tickets.burned_hours',
                    	'tickets.story_points',
                    	'tickets.approval_date',
                    	'tickets.approver_name',
                    	'tickets.acceptance_criteria',
                    	'tickets.testing_criteria',
                    	'tickets.done_criteria',
                    	'tickets.label',
                    	'tickets.comment',
                    	'owner.name as owner_name',
                    	'tickets.owner_id',
			                 'tickets.sprint_id',
                        DB::raw('CONCAT(projects.customer_id, tasks.project_id, tickets.id) as ticket_id'),
                    	'users.name AS assignee_name'
                    );
        $query->leftJoin('task_resources', 'task_resources.id', '=', 'tickets.assignee_id');
        $query->leftJoin('users as owner', 'owner.id', '=', 'tickets.owner_id');
        $query->join('tasks', 'tasks.id', '=', 'tickets.task_id');
        $query->join('projects', 'tasks.project_id', '=', 'projects.id');
        $query->join('customers', 'projects.customer_id', '=', 'customers.id');
        $query->join('users', 'users.id', '=', 'task_resources.user_id');

        if ($request->has('task_id'))
  		{
  			$query->where('tickets.task_id', $request->task_id);
  		}

        if ($request->has('project_id'))
      {
        $query->where('tasks.project_id', $request->project_id);
      }
    if ($request->has('type'))
      {
        $query->where('tickets.type', $request->type);
      }
        if ($request->has('status'))
      {
        $query->where('tickets.status', $request->status);
      }
         if ($request->has('due_date_from') && $request->has('due_date_to'))
      {
        $query->where('tickets.due_date','>', $request->due_date_from)->where('tickets.due_date','<=', $request->due_date_to);
      }

 	if ($request->has('sprint_id'))
  		{
        $query->join('sprints', 'sprints.id', '=', 'tickets.sprint_id');
  			$query->where('tickets.sprint_id', $request->sprint_id);
  		}

        $tickets = $query->get();
  		return Datatables::of($tickets)->make(true);
  	}

}

?>
