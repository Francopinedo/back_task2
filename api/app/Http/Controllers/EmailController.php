<?php

namespace App\Http\Controllers;

use App\Email;
use App\EmailCategory;
use App\EmailCategoryTemplate;
use App\EmailTemplate;
use DB;
use Illuminate\Http\Request;
use Transformers\EmailTransformer;

/**
 * Modulo de email
 *
 * @Resource("Group Emails")
 */
class EmailController extends Controller
{

    /**
     * Crear
     *
     * @Post("emails")
     * @Request({
     *        "title": "string",
     *        "subject": "string",
     *        "body": "text",
     *        "email_category_id": "id"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string",
     *        "subject": "string",
     *        "body": "text",
     *        "email_category_id": "id"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('title') || !$request->has('subject') || !$request->has('body') || !$request->has('email_category_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $email = Email::create($data);

        if ($email) {
            return $this->response->item($email, new EmailTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener
     *
     * @Get("emails/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string",
     *        "subject": "string",
     *        "body": "text",
     *        "email_category_id": "id"
     *    })
     * })
     */
    public function show($id)
    {
        $email = Email::findOrFail($id);

        return $this->response->item($email, new EmailTransformer);
    }

    /**
     * Editar
     *
     * @Patch("emails/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "title": "string",
     *        "subject": "string",
     *        "body": "text",
     *        "email_category_id": "id"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string",
     *        "subject": "string",
     *        "body": "text",
     *        "email_category_id": "id"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $email = Email::find($id);

        if ($email == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $email->update($data);

        if ($email) {
            return $this->response->item($email, new EmailTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("emails/{id}")
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
        $email = Email::find($id);

        if ($email == NULL) {
            return $this->response->error('No existe', 450);
        }

        $email->delete();

        return $this->response->noContent();
    }


    public function reload(Request $request)
    {
        if (!$request->has('company_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        // obtengo los holidays base
        $templates = EmailTemplate::all();
        // obtengo los holidays base
        $category_templates = EmailCategoryTemplate::all();

        // elimino los holidays para este compañia
        Email::join('email_categories', 'email_categories.id', '=', 'emails.email_category_id')
            ->where('company_id', $data['company_id'])->where('emails.added_by', 'reload')->where('emails.user_id', $data['user_id'])->delete();

        // creo los nuevos holidays
        foreach ($templates as $template) {
            try {
                // creo los nuevos holidays
                foreach ($category_templates as $templatec) {
                    // elimino los holidays para este compañia
                    $existc = EmailCategory::where('company_id', $data['company_id'])->where('added_by', 'reload')
                        ->where('title', '=', $templatec->title)->where('user_id', $data['user_id'])->get()->first();
                    if (!is_object($existc)) {
                        EmailCategory::create(
                            [
                                'id' => $templatec->id,
                                'title' => $templatec->title,
                                'company_id' => $data['company_id'],
                                'added_by' => 'reload',
				'user_id'=>$data['user_id']
                            ]
                        );
                    }

                }


                $exist = EmailCategoryTemplate::where('id', '=', $template->email_category_template_id)->get()->first();
                if (is_object($exist)) {
                    $exist1 = EmailCategory::where('company_id', $data['company_id'])->where('user_id', $data['user_id'])->where('title', '=', $exist->title)->get()->first();
                }

                if(is_object($exist1)){
                    Email::create(
                        [
                            'title' => $template->title,
                            'subject' => $template->subject,
                            'body' => $template->body,
                            'email_category_id' => $exist1->id,
                            //'company_id'  => $data['company_id'],
                            'added_by' => 'reload',
				'user_id'=> $data['user_id']
                        ]
                    );
                }

            } catch (\Exception $exception) {

            }
        }

        return $this->response->noContent();
    }

}

?>
