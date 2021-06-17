<?php

namespace App\Http\Controllers;

use App\EmailCategoryTemplate;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\EmailCategory;
use Transformers\EmailCategoryTransformer;

/**
 * Modulo de EmailCategory
 *
 * @Resource("Group EmailCategory")
 */
class EmailCategoryController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("email_categories{?company_id,include}")
	 * @Parameters({
	 *      @Parameter("company_id", type="integer", required=true, description="ID de una compañia", default=null),
	 *      @Parameter("incldue", type="integer", required=true, description="Tablas relacionadas", default=null),
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
  		$query = EmailCategory::with('emails')->select('email_categories.id', 'email_categories.title', 'email_categories.company_id','email_categories.user_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('email_categories.company_id', $request->company_id);
  		}
		if ($request->has('user_id'))
  		{
  			$query->where('email_categories.user_id', $request->user_id);
  		}

  		$emailCategories = $query->get();

  		return $this->response->collection($emailCategories, new EmailCategoryTransformer);
  	}

  	/**
	 * Mostrar
	 *
	 * @Get("email_categories/{id}{?include}")
	 * @Parameters({
	 *      @Parameter("incldue", type="integer", required=true, description="Tablas relacionadas", default=null),
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
  		$query = EmailCategory::with('emails')->select('email_categories.id', 'email_categories.title', 'email_categories.company_id');
  		$query->where('id', $id);

  		$emailCategories = $query->first();

  		return $this->response->item($emailCategories, new EmailCategoryTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("email_categories")
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

        $emailCategory = EmailCategory::create($data);

        if ($emailCategory)
        {
        	return $this->response->item($emailCategory, new EmailCategoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Editar
	 *
	 * @Patch("email_categories/{id}")
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
  		$emailCategory = EmailCategory::find($id);

  		if ($emailCategory == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $emailCategory->update($data);

        if ($emailCategory)
        {
        	return $this->response->item($emailCategory, new EmailCategoryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("email_categories/{id}")
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
  		$emailCategory = EmailCategory::find($id);

        if ($emailCategory == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $emailCategory->delete();

        return $this->response->noContent();
  	}

    public function reload(Request $request)
    {
        if (!$request->has('company_id'))
        {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        // obtengo los holidays base
        $templates = EmailCategoryTemplate::all();

        // elimino los holidays para este compañia
        EmailCategory::where('company_id', $data['company_id'])->where('added_by', 'reload')->delete();

        // creo los nuevos holidays
        foreach ($templates as $template)
        {

            try{
                EmailCategory::create(
                    [
                        'id'        => $template->id,
                        'title'        => $template->title,
                        'company_id'  => $data['company_id'],
                        'added_by'    => 'reload'
                    ]
                );
            }catch (\Exception $exception){

            }

        }

        return $this->response->noContent();
    }

}

?>
