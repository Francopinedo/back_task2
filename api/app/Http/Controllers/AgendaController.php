<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Agenda;
use Transformers\AgendaTransformer;

/**
 * Modulo de Agenda
 *
 * @Resource("Group Agenda")
 */
class AgendaController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("agendas{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Agenda::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$agendas = $query->get();

  		return $this->response->collection($agendas, new AgendaTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("agendas")
	 * @Request({
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('knowledge_area') ||  !$request->has('description') || !$request->has('start') || !$request->has('status') || !$request->has('creator_id') || !$request->has('owner_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();
        $agenda = Agenda::create($data);

        if ($agenda)
        {
        	return $this->response->item($agenda, new AgendaTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("agendas/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$agenda = Agenda::findOrFail($id);

  		return $this->response->item($agenda, new AgendaTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("agendas/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"knowledge_area": "string",
     *  		"item_number": "int",
     *  		"description": "string",
     *  		"start": "date",
     *  		"status": "string",
     *  		"due": "date",
     *  		"creator_id": "int",
     *  		"owner_id": "int",
     *  		"detail": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$agenda = Agenda::find($id);

  		if ($agenda == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $agenda->update($data);

        if ($agenda)
        {
        	return $this->response->item($agenda, new AgendaTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("agendas/{id}")
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
  		$agenda = Agenda::find($id);

        if ($agenda == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $agenda->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("agendas/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('agenda')
                    ->select(
                    	'agenda.id',
                    	'agenda.company_id',
                    	'agenda.project_id',
                    	'agenda.knowledge_area',
                    	'agenda.item_number',
                    	'agenda.description',
                    	'agenda.start',
                    	'agenda.status',
                    	'agenda.due',
                    	'agenda.creator_id',
                    	'agenda.owner_id',
                    	'agenda.detail',
                    	'projects.name AS project_name',
                    	'users.name AS owner_name'
                    );
        $query->leftJoin('projects', 'projects.id', '=', 'agenda.project_id');
        $query->leftJoin('users', 'users.id', '=', 'agenda.owner_id');

        if ($request->has('company_id'))
  		{
  			$query->where('agenda.company_id', $request->company_id);
  		}

        if ($request->has('project_id'))
  		{
  			$query->where('agenda.project_id', $request->project_id);
  		}

		$agendas = $query->get();

  		return Datatables::of($agendas)->make(true);
  	}

}

?>