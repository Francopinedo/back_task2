<?php

namespace App\Http\Controllers;

use App\Models\QuotationExpense;
use Illuminate\Http\Request;
use Transformers\QuotationExpenseTransformer;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceExpense;
use Transformers\InvoiceExpenseTransformer;

/**
 * Modulo de InvoiceExpense
 *
 * @Resource("Group InvoiceExpense")
 */
class QuotationExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("quotation_expenses{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = QuotationExpense::join('currencies','currencies.id','=','quotation_expenses.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('quotation_expenses.id');

        if ($request->has('quotation_id'))
        {
            $query->where('quotation_id', $request->quotation_id);
        }
  		$quotationExpenses = $query->get(['exchange_rates.currency_id','quotation_expenses.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($quotationExpenses, new quotationExpenseTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("quotation_expenses")
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('quotation_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $contractExpense = QuotationExpense::create($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new QuotationExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("quotation_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$contractExpense = QuotationExpense::findOrFail($id);

  		return $this->response->item($contractExpense, new QuotationExpenseTransformer());
  	}

  	/**
	 * Editar
	 *
	 * @Patch("quotation_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"quotation_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$contractExpense = quotationExpense::find($id);

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
        	return $this->response->item($contractExpense, new quotationExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("quotation_expenses/{id}")
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
  		$contractExpense = quotationExpense::find($id);

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
	 * @Get("quotation_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('quotation_expenses')
                    ->select(
                    	'quotation_expenses.id',
                    	'quotation_expenses.detail',
                    	'quotation_expenses.cost',
                    	'quotation_expenses.amount',
                    	'quotation_expenses.currency_id',
                    	'quotation_expenses.quotation_id',
                    	'quotations.emited',
                    	'currencies.name AS currency_name')
            ->join('quotations', 'quotations.id', '=', 'quotation_expenses.quotation_id')
                    ->join('currencies', 'currencies.id', '=', 'quotation_expenses.currency_id');

        if ($request->has('quotation_id'))
  		{
  			$query->where('quotation_expenses.quotation_id', $request->quotation_id);
  		}

		$quotationExpenses = $query->get();

  		return Datatables::of($quotationExpenses)->make(true);
  	}

}

?>