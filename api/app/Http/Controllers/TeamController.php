<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Team;
use Transformers\TeamTransformer;

/**
 * Modulo de Team
 *
 * @Resource("Group Team")
 */
class TeamController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("teams{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"name": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Team::with('user');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$teams = $query->get();

  		return $this->response->collection($teams, new TeamTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("teams")
	 * @Request({
     *  		"project_id": "int",
     *  		"name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"name": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('project_id') || !$request->has('name'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $team = Team::create($data);

        if ($team)
        {
        	return $this->response->item($team, new TeamTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("teams/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"name": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$team = Team::findOrFail($id);

  		return $this->response->item($team, new TeamTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("teams/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"project_id": "int",
     *  		"name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"name": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$team = Team::find($id);

  		if ($team == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $team->update($data);

        if ($team)
        {
        	return $this->response->item($team, new TeamTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("teams/{id}")
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
  		$team = Team::find($id);

        if ($team == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $team->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("teams/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('teams')
                    ->select(
                    	'teams.id',
                    	'teams.name');

        if ($request->has('project_id'))
  		{
  			$query->where('teams.project_id', $request->project_id);
  		}

		$teams = $query->get();

  		return Datatables::of($teams)->make(true);
  	}

}

?>