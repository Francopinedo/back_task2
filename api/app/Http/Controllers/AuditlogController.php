<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Auditlog;
use Transformers\AuditlogTransformer;

/**
 * Modulo de Auditlog
 *
 * @Resource("Group Auditlog")
 */
class AuditlogController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("Auditlogs{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Auditlog::with('user')->orderBy('date_action','DESC');

  		$Auditlogs = $query->get();

  		return $this->response->collection($Auditlogs, new AuditlogTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("Auditlogs")
	 * @Request({
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{


    	$data = $request->all();
        $Auditlog = Auditlog::create($data);
//return $Auditlog;

        if ($Auditlog)
        {
        	return $this->response->item($Auditlog, new AuditlogTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("Auditlogs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$Auditlog = Auditlog::findOrFail($id);

  		return $this->response->item($Auditlog, new AuditlogTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("Auditlogs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"Auditlog_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$Auditlog = Auditlog::find($id);

  		if ($Auditlog == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $Auditlog->update($data);

        if ($Auditlog)
        {
        	return $this->response->item($Auditlog, new AuditlogTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("Auditlogs/{id}")
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
  		$Auditlog = Auditlog::find($id);

        if ($Auditlog == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $Auditlog->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("Auditlogs/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('audit_log')
                    ->select(
                    	'audit_log.id',
			'audit_log.date_action',
			'audit_log.action_name',
			'audit_log.process_name',
			'audit_log.user_comment',
			'audit_log.reason',
			'audit_log.role',

			'users.name AS user_name',
  			'projects.name AS project_name',
			'customers.name AS customer_name'		
					) 
		->leftJoin('users', 'users.id', '=', 'audit_log.user_id')
            	->leftJoin('customers', 'customers.id', '=', 'audit_log.customer_id')
 		->leftJoin('projects', 'projects.id', '=', 'audit_log.project_id')
       			->orderBy('audit_log.date_action','DESC');
		$Auditlogs = $query->get();

  		return Datatables::of($Auditlogs)->make(true);
  	}

}

?>
