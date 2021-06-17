<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Contract;
use Transformers\ContractTransformer;

/**
 * Modulo de Contractos
 *
 * @Resource("Group Contracts")
 */
class ContractController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("contracts{?customer_id,company_id,include}")
	 * @Parameters({
	 *      @Parameter("include", type="integer", required=true, description="Tablas relacionadas", default=null),
	 *      @Parameter("customer_id", type="integer", required=true, description="ID de customer", default=null),
	 *      @Parameter("company_id", type="integer", required=true, description="ID de company", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Contract::with('project');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		if ($request->has('company_id'))
  		{
			$query->where('company_id', $request->company_id);
  		}



        $contracts = $query->get();

  		return $this->response->collection($contracts, new ContractTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("contracts")
	 * @Request({
	 *      	"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 *   	})
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('customer_id') || !$request->has('sow_number'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $contract = Contract::create($data);

        if ($contract)
        {
        	return $this->response->item($contract, new ContractTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener
	 *
	 * @Get("contracts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$contract = Contract::findOrFail($id);

  		return $this->response->item($contract, new ContractTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("contracts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      	"name": "string",
     *  		"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int"
     *  		"project_id": "int",
     *  		"sow_number": "string",
     *  		"amendment_number": "string",
     *  		"date": "date",
     *  		"start_date": "date",
     *  		"finish_date": "date",
     *  		"engagement_id": "int",
     *  		"service_description": "string",
     *  		"workinghours_from": "int",
     *  		"workinghours_to": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$contract = Contract::find($id);

  		if ($contract == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $contract->update($data);

        if ($contract)
        {
        	return $this->response->item($contract, new ContractTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("contracts/{id}")
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
  		$contract = Contract::find($id);

        if ($contract == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $contract->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("contracts/datatables{?customer_id,company_id}")
	 * @Parameters({
	 *      @Parameter("customer_id", type="integer", required=true, description="ID de customer", default=null),
	 *      @Parameter("company_id", type="integer", required=true, description="ID de company", default=null),
	 * })
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('contracts')
                    ->select(
                    	'contracts.id',
                    	'contracts.customer_id',
                    	'contracts.project_id',
                    	'contracts.sow_number',
                    	'contracts.amendment_number',
                    	'contracts.date',
                    	'contracts.start_date',
                    	'contracts.finish_date',
                    	'contracts.engagement_id',
                    	'contracts.service_description',
                    	'contracts.workinghours_from',
                    	'contracts.workinghours_to',
                    	'projects.name AS project_name',
                    	'engagements.name AS engagement_name',
                    	'customers.name AS customer_name')
  					->join('customers', 'customers.id', '=', 'contracts.customer_id')
                    ->leftJoin('projects', 'projects.id', '=', 'contracts.project_id')
                    ->leftJoin('engagements', 'engagements.id', '=', 'contracts.engagement_id');

        if ($request->has('project_id'))
  		{
  			$query->where('contracts.project_id', $request->project_id);
  		}

  		if ($request->has('customer_id'))
  		{
			$query->where('contracts.customer_id', $request->customer_id);
  		}

  		if ($request->has('company_id'))
  		{
			$query->where('customers.company_id', $request->company_id);
  		}

  		$contracts = $query->get();

  		return Datatables::of($contracts)->make(true);
  	}

}

?>