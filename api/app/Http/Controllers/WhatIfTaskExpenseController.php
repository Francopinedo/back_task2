<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\WhatIfTaskExpense;
use Transformers\WhatIfTaskExpenseTransformer;

/**
 * Modulo de WhatIfTaskExpense
 *
 * @Resource("Group WhatIfTaskExpense")
 */
class WhatIfTaskExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("whatif_task_expenses{?company_id}")
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
  		$query = WhatIfTaskExpense;

  		if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_id', $request->whatif_task_id);
  		}

  		$WhatIfTaskExpenses = $query->get();

  		return $this->response->collection($WhatIfTaskExpenses, new WhatIfTaskExpenseTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("whatif_task_expenses")
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

        $WhatIfTaskExpense = WhatIfTaskExpense::create($data);

        if ($WhatIfTaskExpense)
        {
        	return $this->response->item($WhatIfTaskExpense, new WhatIfTaskExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("whatif_task_expenses/{id}")
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
  		$WhatIfTaskExpense = WhatIfTaskExpense::findOrFail($id);

  		return $this->response->item($WhatIfTaskExpense, new WhatIfTaskExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("whatif_task_expenses/{id}")
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
  		$WhatIfTaskExpense = WhatIfTaskExpense::find($id);

  		if ($WhatIfTaskExpense == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $WhatIfTaskExpense->update($data);

        if ($WhatIfTaskExpense)
        {
        	return $this->response->item($WhatIfTaskExpense, new WhatIfTaskExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("whatif_task_expenses/{id}")
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
  		$WhatIfTaskExpense = WhatIfTaskExpense::find($id);

        if ($WhatIfTaskExpense == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $WhatIfTaskExpense->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("whatif_task_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('whatif_task_expenses')
                    ->select(
                    	'whatif_task_expenses.id',
                    	'whatif_task_expenses.whatif_task_id',
                        'whatif_task_expenses.cost',
                        'whatif_task_expenses.amount',
                        'whatif_task_expenses.quantity',
                        'whatif_task_expenses.reimbursable',
                        'currencies.name as currency_name',
                    	'whatif_task_expenses.detail');

        if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_expenses.whatif_task_id', $request->whatif_task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'whatif_task_expenses.currency_id');

  		if ($request->has('project_id'))
  		{
  			$query->join('whatif_tasks', 'whatif_tasks.id', '=', 'whatif_task_expenses.whatif_task_id');
  			$query->where('whatif_tasks.project_id', $request->project_id);
  		}

		$WhatIfTaskExpenses = $query->get();

  		return Datatables::of($WhatIfTaskExpenses)->make(true);
  	}

}

?>