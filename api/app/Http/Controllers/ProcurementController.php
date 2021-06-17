<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Dingo\Api\Routing\Helpers;

use App\Models\Procurement;
use Transformers\ProcurementTransformer;

/**
 * Modulo de Procurement
 *
 * @Resource("Group Procurement")
 */
class ProcurementController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("procurements{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Procurement::select('procurements.*');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$procurements = $query->get();

  		return $this->response->collection($procurements, new ProcurementTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("procurements")
	 * @Request({
     *  		"name": "string",
     *  		"address": "string (opt)",
     *  		"city_id": "int (opt)",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string (opt)",
     *  		"billing_address": "string (opt)",
     *  		"tax_number": "string (opt)",
     *  		"bank_name": "string (opt)",
     *  		"account_number": "string (opt)",
     *  		"swiftcode": "string (opt)",
     *  		"aba": "string (opt)",
     *  		"currency_id": "int (opt)",
     *  		"industry_id": "int (opt)",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('project_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $procurement = Procurement::create($data);

        if ($procurement)
        {
        	return $this->response->item($procurement, new ProcurementTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener
	 *
	 * @Get("procurements/{id}{?include}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$procurement = Procurement::findOrFail($id);

  		return $this->response->item($procurement, new ProcurementTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("procurements/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"name": "string",
     *  		"address": "string" (opt),
     *  		"city_id": "int" (opt),
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string" (opt),
     *  		"billing_address": "string" (opt),
     *  		"tax_number": "string" (opt),
     *  		"bank_name": "string" (opt),
     *  		"account_number": "string" (opt),
     *  		"swiftcode": "string" (opt),
     *  		"aba": "string" (opt),
     *  		"currency_id": "int" (opt),
     *  		"industry_id": "int (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$procurement = Procurement::find($id);

  		if ($procurement == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $procurement->update($data);

        if ($procurement)
        {
        	return $this->response->item($procurement, new ProcurementTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("procurements/{id}")
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
  		$procurement = Procurement::find($id);

        if ($procurement == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $procurement->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("procurements/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('procurements')
                    ->select(
                    	'procurements.id',
                    	'procurements.project_id',
                    	'procurements.type',
                    	'procurements.date',
                    	'procurements.description',
                    	'procurements.RFPID',
                    	'procurements.ContractID',
                    	'procurements.specifications',
                    	'procurements.approver_name',
                    	'procurements.responsable_id',
                    	'procurements.due_date',
                    	'procurements.cost',
                    	'procurements.cost_currency_id',
                    	'procurements.quality_required',
                    	'procurements.contract_status',
                    	'procurements.provider_id',
                    	'procurements.provider_feedback',
                    	'procurements.delivery',
                    	'procurements.quality',
                    	'procurements.overallscore',
                    	'procurements.requirement_status',
                    	'procurements.delivered_date'
                    );

        if ($request->has('project_id'))
  		{
  			$query->where('procurements.project_id', $request->project_id);
  		}

        $procurements = $query->get();

  		return Datatables::of($procurements)->make(true);
  	}

}

?>