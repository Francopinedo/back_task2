<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ActivityHistory;
use Transformers\ActivityHistoryTransformer;

/**
 * Modulo de ActivityHistory
 *
 * @Resource("Group ActivityHistory")
 */
class ActivityHistoryController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("activities_history{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = ActivityHistory::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$activitiesHistory = $query->get();

  		return $this->response->collection($activitiesHistory, new ActivityHistoryTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("activities_history")
	 * @Request({
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('agenda_id') ||
  			!$request->has('date') ||
  			!$request->has('description') ||
  			!$request->has('follower_id') ||
  			!$request->has('due'))
    	{
    		dd('|');
    		return $this->response->error('Faltan datos', 452);
    	}

    	$data = $request->all();

        $activityHistory = ActivityHistory::create($data);

        if ($activityHistory)
        {
        	return $this->response->item($activityHistory, new ActivityHistoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("activities_history/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$activityHistory = ActivityHistory::findOrFail($id);

  		return $this->response->item($activityHistory, new ActivityHistoryTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("activities_history/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"agenda_id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"followe_id": "int",
     *  		"due": "date"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$activityHistory = ActivityHistory::find($id);

  		if ($activityHistory == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $activityHistory->update($data);

        if ($activityHistory)
        {
        	return $this->response->item($activityHistory, new ActivityHistoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("activities_history/{id}")
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
  		$activityHistory = ActivityHistory::find($id);

        if ($activityHistory == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $activityHistory->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("activities_history/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('activities_history')
                    ->select(
                    	'activities_history.id',
                    	'activities_history.agenda_id',
                    	'activities_history.date',
                    	'activities_history.description',
                    	'activities_history.follower_id',
                    	'activities_history.due',
                    	'users.name AS follower_name'
                    );

        $query->leftJoin('users', 'users.id', '=', 'activities_history.follower_id');

        if ($request->has('agenda_id'))
  		{
  			$query->where('activities_history.agenda_id', $request->agenda_id);
  		}

		$activitiesHistory = $query->get();

  		return Datatables::of($activitiesHistory)->make(true);
  	}

}

?>