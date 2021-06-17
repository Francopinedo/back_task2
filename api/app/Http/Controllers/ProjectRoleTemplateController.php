<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\ProjectRoleTemplate;
use Transformers\ProjectRoleTemplateTransformer;

/**
 * Modulo de ProjectRoleTemplate
 *
 * @Resource("Group ProjectRoleTemplate")
 */
class ProjectRoleTemplateController extends Controller {

  	/**
	 * Obtener templates
	 *
	 * @Get("project_role_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$project_role_templates = ProjectRoleTemplate::all();

  		return $this->response->collection($project_role_templates, new ProjectRoleTemplateTransformer);
  	}

  	/**
	 * Crear template
	 *
	 * @Post("project_role_templates")
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

        $projectRoleTemplate = ProjectRoleTemplate::create($data);

        if ($projectRoleTemplate)
        {
        	return $this->response->item($projectRoleTemplate, new ProjectRoleTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener template
	 *
	 * @Get("project_role_templates/{id}")
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
  		$projectRoleTemplate = ProjectRoleTemplate::findOrFail($id);

  		return $this->response->item($projectRoleTemplate, new ProjectRoleTemplateTransformer);
  	}

  	/**
	 * Editar template
	 *
	 * @Patch("project_role_templates/{id}")
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
  		$projectRoleTemplate = ProjectRoleTemplate::find($id);

  		if ($projectRoleTemplate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $projectRoleTemplate->update($data);

        if ($projectRoleTemplate)
        {
        	return $this->response->item($projectRoleTemplate, new ProjectRoleTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template
     *
     * @Delete("project_role_templates/{id}")
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
  		$projectRoleTemplate = ProjectRoleTemplate::find($id);

        if ($projectRoleTemplate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $projectRoleTemplate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener templates de ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("project_role_templates/datatables")
	 */
  	public function datatables()
  	{
  		$project_role_templates = DB::table('project_role_templates')
                    ->select(
                    	'project_role_templates.id', 'project_role_templates.title')
                    ->get();

  		return Datatables::of($project_role_templates)->make(true);
  	}

}

?>