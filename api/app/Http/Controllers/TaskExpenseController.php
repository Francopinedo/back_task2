<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\TaskExpense;
use Transformers\TaskExpenseTransformer;

/**
 * Modulo de TaskExpense
 *
 * @Resource("Group TaskExpense")
 */
class TaskExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("task_expenses{?company_id}")
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
  		$query = TaskExpense::with('task');

  		if ($request->has('task_id'))
  		{
  			$query->where('task_id', $request->task_id);
  		}

  		$TaskExpenses = $query->get();

  		return $this->response->collection($TaskExpenses, new TaskExpenseTransformer);
  	}

    public function index_export(Request $request)
    {
      $query = DB::table('task_expenses')
                    ->select(
                       $request->has('project_id')? 'tasks.index' :
                      'task_expenses.detail',
                      'task_expenses.detail',
                        'task_expenses.cost',
                        'task_expenses.amount',
                        'task_expenses.quantity',
                        'task_expenses.reimbursable',
                        'currencies.name as currency_name',
                        DB::raw('"Expense" as `Type`')
                      );

        if ($request->has('task_id'))
      {
        $query->where('task_expenses.task_id', $request->task_id);
      }
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_expenses.currency_id');

      if ($request->has('project_id'))
      {
        $query->join('tasks', 'tasks.id', '=', 'task_expenses.task_id');
        $query->where('tasks.project_id', $request->project_id);
      }

    $TaskExpenses = $query->get();

          return response()->json(array('data' => $TaskExpenses));
    }

  	/**
	 * Crear
	 *
	 * @Post("task_expenses")
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
  		if (!$request->has('task_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $TaskExpense = TaskExpense::create($data);

        if ($TaskExpense)
        {
        	return $this->response->item($TaskExpense, new TaskExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("task_expenses/{id}")
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
  		$TaskExpense = TaskExpense::findOrFail($id);

  		return $this->response->item($TaskExpense, new TaskExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("task_expenses/{id}")
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
  		$TaskExpense = TaskExpense::find($id);

  		if ($TaskExpense == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $TaskExpense->update($data);

        if ($TaskExpense)
        {
        	return $this->response->item($TaskExpense, new TaskExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("task_expenses/{id}")
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
  		$TaskExpense = TaskExpense::find($id);

        if ($TaskExpense == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $TaskExpense->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("task_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('task_expenses')
                    ->select(
                    	'task_expenses.id',
                    	'task_expenses.task_id',
                        'task_expenses.cost',
                        'task_expenses.amount',
                        'task_expenses.quantity',
                        'task_expenses.reimbursable',
                        'currencies.name as currency_name',
                    	'task_expenses.detail');

        if ($request->has('task_id'))
  		{
  			$query->where('task_expenses.task_id', $request->task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_expenses.currency_id');

  		if ($request->has('project_id'))
  		{
  			$query->join('tasks', 'tasks.id', '=', 'task_expenses.task_id');
  			$query->where('tasks.project_id', $request->project_id);
  		}

		$TaskExpenses = $query->get();

  		return Datatables::of($TaskExpenses)->make(true);
  	}

}

?>