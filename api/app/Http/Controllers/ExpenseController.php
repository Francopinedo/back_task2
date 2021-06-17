<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Expense;
use Transformers\ExpenseTransformer;

/**
 * Modulo de Expenses
 *
 * @Resource("Group Expenses")
 */
class ExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("expenses{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Expense::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}
       if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        

  		$expenses = $query->get();

  		return $this->response->collection($expenses, new ExpenseTransformer);
  	}

 public function index_export(Request $request)
    {
    $query = DB::table('expenses')
                    ->select(
                       'expenses.reimbursable', 'expenses.detail',
                      'expenses.amount', 'expenses.cost',
                      'currencies.name AS currency_name',
                     DB::raw('"Expense" as `Type`'))
                    ->join('currencies', 'currencies.id', '=', 'expenses.currency_id');

        if ($request->has('company_id'))
      {
        $query->where('expenses.company_id', $request->company_id);
      }
       if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        


    $expenses = $query->get();
    return response()->json(array('data' => $expenses));
    }
  	/**
	 * Crear
	 *
	 * @Post("expenses")
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('detail') || !$request->has('amount'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $expense = Expense::create($data);

        if ($expense)
        {
        	return $this->response->item($expense, new ExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$expense = Expense::findOrFail($id);

  		return $this->response->item($expense, new ExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$expense = Expense::find($id);

  		if ($expense == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $expense->update($data);

        if ($expense)
        {
        	return $this->response->item($expense, new ExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("expenses/{id}")
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
  		$expense = Expense::find($id);

        if ($expense == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $expense->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('expenses')
                    ->select(
                    	'expenses.id', 'expenses.reimbursable', 'expenses.detail',
                    	'expenses.amount', 'expenses.cost',
                    	'expenses.cost_currency_id', 'expenses.currency_id',
                    	'expenses.company_id',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'expenses.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('expenses.company_id', $request->company_id);
  		}

		$expenses = $query->get();

  		return Datatables::of($expenses)->make(true);
  	}

}

?>