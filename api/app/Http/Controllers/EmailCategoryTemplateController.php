<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\EmailCategoryTemplate;
use Transformers\EmailCategoryTemplateTransformer;

/**
 * Modulo de EmailCategoryTemplate
 *
 * @Resource("Group EmailCategoryTemplate")
 */
class EmailCategoryTemplateController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("email_category_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$email_category_templates = EmailCategoryTemplate::all();

  		return $this->response->collection($email_category_templates, new EmailCategoryTemplateTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("email_category_templates")
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

        $emailCategoryTemplate = EmailCategoryTemplate::create($data);

        if ($emailCategoryTemplate)
        {
        	return $this->response->item($emailCategoryTemplate, new EmailCategoryTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener
	 *
	 * @Get("email_category_templates/{id}")
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
  		$emailCategoryTemplate = EmailCategoryTemplate::findOrFail($id);

  		return $this->response->item($emailCategoryTemplate, new EmailCategoryTemplateTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("email_category_templates/{id}")
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
  		$emailCategoryTemplate = EmailCategoryTemplate::find($id);

  		if ($emailCategoryTemplate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $emailCategoryTemplate->update($data);

        if ($emailCategoryTemplate)
        {
        	return $this->response->item($emailCategoryTemplate, new EmailCategoryTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("email_category_templates/{id}")
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
  		$emailCategoryTemplate = EmailCategoryTemplate::find($id);

        if ($emailCategoryTemplate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $emailCategoryTemplate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener templates de ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("email_category_templates/datatables")
	 */
  	public function datatables()
  	{
  		$email_category_templates = DB::table('email_category_templates')
                    ->select(
                    	'email_category_templates.id', 'email_category_templates.title')
                    ->get();

  		return Datatables::of($email_category_templates)->make(true);
  	}

}

?>