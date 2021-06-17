<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\SeniorityTemplate;
use Transformers\SeniorityTemplateTransformer;

/**
 * Modulo de SeniorityTemplate
 *
 * @Resource("Group SeniorityTemplate")
 */
class SeniorityTemplateController extends Controller {

  	/**
	 * Obtener templates de seniorities
	 *
	 * @Get("seniority_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$seniority_templates = SeniorityTemplate::all();

  		return $this->response->collection($seniority_templates, new SeniorityTemplateTransformer);
  	}

  	/**
	 * Crear template de seniority
	 *
	 * @Post("seniority_templates")
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

        $seniorityTemplate = SeniorityTemplate::create($data);

        if ($seniorityTemplate)
        {
        	return $this->response->item($seniorityTemplate, new SeniorityTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener template de seniority
	 *
	 * @Get("seniority_templates/{id}")
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
  		$seniorityTemplate = SeniorityTemplate::findOrFail($id);

  		return $this->response->item($seniorityTemplate, new SeniorityTemplateTransformer);
  	}

  	/**
	 * Editar template de seniority
	 *
	 * @Patch("seniority_templates/{id}")
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
  		$seniorityTemplate = SeniorityTemplate::find($id);

  		if ($seniorityTemplate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $seniorityTemplate->update($data);

        if ($seniorityTemplate)
        {
        	return $this->response->item($seniorityTemplate, new SeniorityTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template de seniority
     *
     * @Delete("seniority_templates/{id}")
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
  		$seniorityTemplate = SeniorityTemplate::find($id);

        if ($seniorityTemplate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $seniorityTemplate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener templates de ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("seniority_templates/datatables")
	 */
  	public function datatables()
  	{
  		$seniority_templates = DB::table('seniority_templates')
                    ->select(
                    	'seniority_templates.id', 'seniority_templates.title')
                    ->get();

  		return Datatables::of($seniority_templates)->make(true);
  	}

}

?>