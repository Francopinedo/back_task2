<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Wiki;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use Yajra\Datatables\Datatables;
use Transformers\WikiTransformer;

/**
 * Modulo de Wiki
 *
 * @Resource("Group Wiki")
 */
class WikiController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("Wiki")
	 
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"customer_id": "int",
     *  		"project_id": "int",
     *      "user_id": "int",
     *  		"process_group_code": "string",
     *  		"knowledge_code": "string",
     *  		"swot_code": "string",
     *  		"explanation": "string",
     *  		"action_taken": "string",
     *  		"additionals_comments": "string",
     *  		"attached_file": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Wiki::with('customer', 'project', 'user');

      if ($request->has('customer_id')){
        $query->where('customer_id', $request->customer_id);
      }

      if ($request->has('project_id')){
        $query->where('project_id', $request->project_id);
      }

      if ($request->has('user_id')) {
        $query->where('user_id', $request->user_id);
      }

  		$wiki = $query->get();

  		return $this->response->collection($wiki, new WikiTransformer);
  	}

    /**
    * Obtener ciudad
    *
    * @Get("contacts/{id}")
    * @Parameters({
    *      @Parameter("id", type="integer", required=true, description="ID", default=null),
    * })
    * @Transaction({
    *    @Response(200, body={
    *      "customer_id": "int",
     *      "project_id": "int",
     *      "user_id": "int",
     *      "process_group_code": "string",
     *      "knowledge_code": "string",
     *      "swot_code": "string",
     *      "explanation": "string",
     *      "action_taken": "string",
     *      "additionals_comments": "string",
     *      "attached_file": "string"
    *    })
    * })
    */
    public function show($id)
    {
      $wiki = Wiki::findOrFail($id);

      return $this->response->item($wiki, new WikiTransformer);
    }

    /**
   * Crear wiki
   *
   * @Post("wiki")
   * @Request({
     *      "customer_id": "int",
     *      "project_id": "int",
     *      "user_id": "int",
     *      "process_group_code": "string",
     *      "knowledge_code": "string",
     *      "swot_code": "string",
     *      "explanation": "string",
     *      "action_taken": "string",
     *      "additionals_comments": "string",
     *      "attached_file": "string(opt)"
   * })
   * @Transaction({
   *    @Response(200, body={
   *      "id": "int",
     *      "customer_code": "int",
     *      "project_code": "int",
     *      "user_id": "int",
     *      "process_group_code": "string",
     *      "knowledge_code": "string",
     *      "swot_code": "string",
     *      "explanation": "string",
     *      "action_taken": "string",
     *      "additionals_comments": "string",
     *      "attached_file": "string"
   *    }),
   *    @Response(450, body={"error": {"message": "Faltan datos"}}),
   *    @Response(451, body={"error": {"message": "Error al crear"}})
   * })
   */

    public function store(Request $request)
    {
      if (!$request->has('customer_id') || !$request->has('project_id') || !$request->has('process_group_code')
        || !$request->has('knowledge_code') || !$request->has('swot_code') || !$request->has('explanation') || !$request->has('action_taken') || !$request->has('additionals_comments'))
      {
        return $this->response->error('Faltan datos', 450);
      }

      $data = $request->all();
      $wiki = Wiki::create($data);

      if ($wiki)
      {
        return $this->response->item($wiki, new WikiTransformer);
      }
      else
      {
        return $this->response->error('Error al crear', 451);
      }
    }

 
  	/**
	 * Editar
	 *
	 * @Patch("Wiki")
	
	 * @Request({
  	 *   		"customer_id": "int",
     *  		"project_id": "int",
     *      "user_id": "int"
     *  		"process_group_code": "string",
     *  		"knowledge_code": "string",
     *  		"swot_code": "string",
     *  		"explanation": "string",
     *  		"action_taken": "string",
     *  		"additionals_comments": "string",
     *  		"attached_file": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"customer_code": "iint",
     *  		"project_code": "int",
     *      "user_id": "int",
     *  		"process_group_code": "string",
     *  		"knowledge_code": "string",
     *  		"swot_code": "string",
     *  		"explanation": "string",
     *  		"action_taken": "string",
     *  		"additionals_comments": "string",
     *  		"attached_file": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$Wiki =  Wiki::find($id);

  		if ($Wiki == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $Wiki->update($data);

        if ($Wiki)
        {
        	return $this->response->item($Wiki, new WikiTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

    /**
     * Elimina una compania
     *
     * @Delete("providers/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *    @Response(204),
     *    @Response(450, body={"error": {"message": "No existe"}})
     * })
     */
    public function destroy($id)
    {
      $wiki = Wiki::find($id);

        if ($wiki == NULL)
        {
          return $this->response->error('No existe', 450);
        }

        $wiki->delete();

        return $this->response->noContent();
    }

  /**
  * Obtener
  *
  * Con formato listo para datatables con ajax
  * @Get("wiki/datatables")
  */

  public function datatables(Request $request)
  {
    $query = DB::table('wiki')
      ->select(
          'wiki.id',
          'wiki.customer_id',
          'wiki.project_id',
          'wiki.user_id',
          'wiki.process_group_code',
          'wiki.knowledge_code',
          'wiki.swot_code',
          'wiki.explanation',
          'wiki.action_taken',
          'wiki.additionals_comments',
          'wiki.attached_file',
          'projects.name AS project_name',
          'customers.name AS customer_name'
        );
    $query->join('customers', 'customers.id', '=', 'wiki.customer_id');
    $query->join('projects', 'projects.id', '=', 'wiki.project_id');
    $query->join('users', 'users.id', '=', 'wiki.user_id');

    if ($request->has('customer_id')) {
        $query->where('wiki.customer_id', $request->customer_id);
    }

    if ($request->has('project_id')) {
      $query->where('wiki.project_id', $request->project_id);
    }

    if($request->has('user_id')) {
      $query->where('wiki.user_id', $request->user_id);
    }

    $wiki = $query->get();

    return Datatables::of($wiki)->make(true);
  }

}//Fin de la Clase WikiController

?>