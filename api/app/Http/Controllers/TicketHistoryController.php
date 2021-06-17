<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Dingo\Api\Routing\Helpers;

use App\Models\TicketHistory;
use Transformers\TicketHistoryTransformer;

/**
 * Modulo de TicketHistory
 *
 * @Resource("Group TicketHistory")
 */
class TicketHistoryController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("ticket_histories{?include}")
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
  		$query = TicketHistory::select('ticket_histories.*');

  		if ($request->has('ticket_id'))
  		{
  			$query->where('ticket_id', $request->ticket_id);
  		}

  		$ticketHistories = $query->get();

  		return $this->response->collection($ticketHistories, new TicketHistoryTransformer);
  	}

  	/**
	 * Crear compania
	 *
	 * @Post("ticket_histories")
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
  		if (!$request->has('date'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $ticketHistory = TicketHistory::create($data);

        if ($ticketHistory)
        {
        	return $this->response->item($ticketHistory, new TicketHistoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener compania
	 *
	 * @Get("ticket_histories/{id}{?include}")
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
  		$ticketHistory = TicketHistory::findOrFail($id);

  		return $this->response->item($ticketHistory, new TicketHistoryTransformer);
  	}

  	/**
	 * Editar compania
	 *
	 * @Patch("ticket_histories/{id}")
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
  		$ticketHistory = TicketHistory::find($id);

  		if ($ticketHistory == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $ticketHistory->update($data);

        if ($ticketHistory)
        {
        	return $this->response->item($ticketHistory, new TicketHistoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una compania
     *
     * @Delete("ticket_histories/{id}")
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
  		$ticketHistory = TicketHistory::find($id);

        if ($ticketHistory == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $ticketHistory->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener companias
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("ticket_histories/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('ticket_histories')
                    ->select(
                    	'ticket_histories.id',
                    	'ticket_histories.ticket_id',
                    	'ticket_histories.date',
                    	'ticket_histories.owner_id',
                    	'ticket_histories.internal_or_external',
                    	'ticket_histories.comment',
                    	'users.name AS owner_name'
                    );

        $query->leftJoin('users', 'users.id', '=', 'ticket_histories.owner_id');

        if ($request->has('ticket_id'))
  		{
  			$query->where('ticket_histories.ticket_id', $request->ticket_id);
  		}

        $ticketHistories = $query->get();

  		return Datatables::of($ticketHistories)->make(true);
  	}

}

?>