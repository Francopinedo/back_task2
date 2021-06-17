<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\WhatIfTaskService;
use Transformers\WhatIfTaskServiceTransformer;

/**
 * Modulo de WhatIfwhatif_taskservice
 *
 * @Resource("Group WhatIfwhatif_taskservice")
 */
class WhatIfTaskServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("whatif_task_services{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = WhatIfTaskService::all();

  		if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_id', $request->whatif_task_id);
  		}

  		$WhatIfwhatif_taskservices = $query->get();

  		return $this->response->collection($WhatIfwhatif_taskservices, new WhatIfTaskServiceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("whatif_task_services")
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('whatif_task_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $WhatIfwhatif_taskservice = WhatIfTaskService::create($data);

        if ($WhatIfwhatif_taskservice)
        {
        	return $this->response->item($WhatIfwhatif_taskservice, new WhatIfTaskServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("whatif_task_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$WhatIfwhatif_taskservice = WhatIfTaskService::findOrFail($id);

  		return $this->response->item($WhatIfwhatif_taskservice, new WhatIfTaskServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("whatif_task_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$WhatIfwhatif_taskservice = WhatIfTaskService::find($id);

  		if ($WhatIfwhatif_taskservice == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $WhatIfwhatif_taskservice->update($data);

        if ($WhatIfwhatif_taskservice)
        {
        	return $this->response->item($WhatIfwhatif_taskservice, new WhatIfTaskServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("whatif_task_services/{id}")
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
  		$WhatIfwhatif_taskservice = WhatIfTaskService::find($id);

        if ($WhatIfwhatif_taskservice == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $WhatIfwhatif_taskservice->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("whatif_task_services/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('whatif_task_services')
                    ->select(
                    	'whatif_task_services.id',
                    	'whatif_task_services.whatif_task_id',
                        'whatif_task_services.cost',
                        'whatif_task_services.amount',
                        'whatif_task_services.quantity',
                        'whatif_task_services.reimbursable',
                        'currencies.name as currency_name',
                    	'whatif_task_services.detail');

        if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_services.whatif_task_id', $request->whatif_task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'whatif_task_services.currency_id');

  		if ($request->has('project_id'))
  		{
  			$query->join('whatif_tasks', 'whatif_tasks.id', '=', 'whatif_task_services.whatif_task_id');
  			$query->where('whatif_tasks.project_id', $request->project_id);
  		}

		$WhatIfwhatif_taskservices = $query->get();

  		return Datatables::of($WhatIfwhatif_taskservices)->make(true);
  	}

}

?>