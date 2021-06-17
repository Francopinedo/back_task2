<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceExpense;
use Transformers\InvoiceExpenseTransformer;

/**
 * Modulo de InvoiceExpense
 *
 * @Resource("Group InvoiceExpense")
 */
class InvoiceExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_expenses{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = InvoiceExpense::join('currencies','currencies.id','=','invoice_expenses.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_expenses.id');

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }
  		$invoiceExpenses = $query->get(['exchange_rates.currency_id','invoice_expenses.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceExpenses, new invoiceExpenseTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_expenses")
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('invoice_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $contractExpense = invoiceExpense::create($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new invoiceExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$contractExpense = InvoiceExpense::findOrFail($id);

  		return $this->response->item($contractExpense, new invoiceExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$contractExpense = invoiceExpense::find($id);

  		if ($contractExpense == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $contractExpense->update($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new invoiceExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_expenses/{id}")
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
  		$contractExpense = invoiceExpense::find($id);

        if ($contractExpense == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $contractExpense->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_expenses')
                    ->select(
                    	'invoice_expenses.id',
                    	'invoice_expenses.detail',
                    	'invoice_expenses.cost',
                    	'invoice_expenses.amount',
                    	'invoice_expenses.currency_id',
                    	'invoice_expenses.invoice_id',
                    	'invoices.emited',
                    	'currencies.name AS currency_name')
            ->join('invoices', 'invoices.id', '=', 'invoice_expenses.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_expenses.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_expenses.invoice_id', $request->invoice_id);
  		}

		$invoiceExpenses = $query->get();

  		return Datatables::of($invoiceExpenses)->make(true);
  	}

}

?>