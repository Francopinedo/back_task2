<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\ProjectRole;
use Transformers\ProjectRoleTransformer;

/**
 * Modulo de ProjectRole
 *
 * @Resource("Group ProjectRole")
 */
class ProjectRoleController extends Controller {

  	/**
	 * Obtener project_roles
	 *
	 * @Get("project_roles{?company_id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID de una compañia", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = ProjectRole::select('project_roles.id', 'project_roles.title', 'project_roles.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('project_roles.company_id', $request->company_id);
  		}
        if ($request->has('title'))
        {
            $query->where('project_roles.title', $request->title);
        }

  		$project_roles = $query->get();

  		return $this->response->collection($project_roles, new ProjectRoleTransformer);
  	}

  	/**
	 * Crear company role
	 *
	 * @Post("project_roles")
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $projectRole = ProjectRole::create($data);

        if ($projectRole)
        {
        	return $this->response->item($projectRole, new ProjectRoleTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener una company role
	 *
	 * @Get("project_roles/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$projectRole = ProjectRole::findOrFail($id);

  		return $this->response->item($projectRole, new ProjectRoleTransformer);
  	}

  	/**
	 * Editar una company role
	 *
	 * @Patch("project_roles/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$projectRole = ProjectRole::find($id);

  		if ($projectRole == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $projectRole->update($data);

        if ($projectRole)
        {
        	return $this->response->item($projectRole, new ProjectRoleTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una company role
     *
     * @Delete("project_roles/{id}")
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
  		$projectRole = ProjectRole::find($id);

        if ($projectRole == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $projectRole->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener project_roles
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("project_roles/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = ProjectRole::select('project_roles.id', 'project_roles.title', 'project_roles.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('project_roles.company_id', $request->company_id);
  		}

  		$project_roles = $query->get();

  		return Datatables::of($project_roles)->make(true);
  	}

}

?>