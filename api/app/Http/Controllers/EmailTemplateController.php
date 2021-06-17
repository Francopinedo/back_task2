<?php

namespace App\Http\Controllers;

use App\EmailCategory;
use App\EmailCategoryTemplate;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\EmailTemplate;
use Transformers\EmailTemplateTransformer;

/**
 * Modulo de templates de email
 *
 * @Resource("Group EmailTemplates")
 */
class EmailTemplateController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("email_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$email_templates = EmailTemplate::all();

  		return $this->response->collection($email_templates, new EmailTemplateTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("email_templates")
	 * @Request({
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title') || !$request->has('subject') || !$request->has('body') || !$request->has('email_category_template_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $emailTemplate = EmailTemplate::create($data);

        if ($emailTemplate)
        {
        	return $this->response->item($emailTemplate, new EmailTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener
	 *
	 * @Get("email_templates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$emailTemplate = EmailTemplate::findOrFail($id);

  		return $this->response->item($emailTemplate, new EmailTemplateTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("emailTemplates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"subject": "string",
     *  		"body": "text",
     *  		"email_category_template_id": "id"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$emailTemplate = EmailTemplate::find($id);

  		if ($emailTemplate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $emailTemplate->update($data);

        if ($emailTemplate)
        {
        	return $this->response->item($emailTemplate, new EmailTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("emailTemplates/{id}")
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
  		$emailTemplate = EmailTemplate::find($id);

        if ($emailTemplate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $emailTemplate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("emailTemplates/datatables")
	 */
  	public function datatables()
  	{
  		$emailTemplates = DB::table('email_templates')
                    ->select(
                    	'email_templates.id', 'email_templates.title', 'email_templates.subject', 'email_templates.body', 'email_templates.email_category_template_id',
                    	'email_category_templates.title AS email_category_template_name')
                    ->join('email_category_templates', 'email_category_templates.id', '=', 'email_templates.email_category_template_id')
                    ->get();

  		return Datatables::of($emailTemplates)->make(true);
  	}




}

?>