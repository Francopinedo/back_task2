<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\CompanyRoleTemplate;
use Transformers\CompanyRoleTemplateTransformer;

/**
 * Modulo de CompanyRoleTemplate
 *
 * @Resource("Group CompanyRoleTemplate")
 */
class CompanyRoleTemplateController extends Controller {

  	/**
	 * Obtener templates
	 *
	 * @Get("company_role_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$company_role_templates = CompanyRoleTemplate::all();

  		return $this->response->collection($company_role_templates, new CompanyRoleTemplateTransformer);
  	}

  	/**
	 * Crear template
	 *
	 * @Post("company_role_templates")
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

        $companyRoleTemplate = CompanyRoleTemplate::create($data);

        if ($companyRoleTemplate)
        {
        	return $this->response->item($companyRoleTemplate, new CompanyRoleTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener template
	 *
	 * @Get("company_role_templates/{id}")
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
  		$companyRoleTemplate = CompanyRoleTemplate::findOrFail($id);

  		return $this->response->item($companyRoleTemplate, new CompanyRoleTemplateTransformer);
  	}

  	/**
	 * Editar template
	 *
	 * @Patch("company_role_templates/{id}")
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
  		$companyRoleTemplate = CompanyRoleTemplate::find($id);

  		if ($companyRoleTemplate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $companyRoleTemplate->update($data);

        if ($companyRoleTemplate)
        {
        	return $this->response->item($companyRoleTemplate, new CompanyRoleTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template
     *
     * @Delete("company_role_templates/{id}")
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
  		$companyRoleTemplate = CompanyRoleTemplate::find($id);

        if ($companyRoleTemplate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $companyRoleTemplate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener templates de ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("company_role_templates/datatables")
	 */
  	public function datatables()
  	{
  		$company_role_templates = DB::table('company_role_templates')
                    ->select(
                    	'company_role_templates.id', 'company_role_templates.title')
                    ->get();

  		return Datatables::of($company_role_templates)->make(true);
  	}

}

?>