<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceDiscount;
use Transformers\InvoiceDiscountTransformer;

/**
 * Modulo de InvoiceDiscount
 *
 * @Resource("Group InvoiceDiscount")
 */
class InvoiceDiscountController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_discounts{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = InvoiceDiscount::join('currencies','currencies.id','=','invoice_discounts.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_discounts.id');


        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }
  		$invoiceDiscounts = $query->get(['exchange_rates.currency_id','invoice_discounts.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceDiscounts, new InvoiceDiscountTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_discounts")
	 * @Request({
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"invoice_id": "int",
     *  		"file": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('invoice_id') || !$request->has('amount') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $invoiceDiscount = InvoiceDiscount::create($data);

        if ($invoiceDiscount)
        {
        	return $this->response->item($invoiceDiscount, new InvoiceDiscountTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_discounts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$invoiceDiscount = InvoiceDiscount::findOrFail($id);

  		return $this->response->item($invoiceDiscount, new InvoiceDiscountTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_discounts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$invoiceDiscount = InvoiceDiscount::find($id);

  		if ($invoiceDiscount == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $invoiceDiscount->update($data);

        if ($invoiceDiscount)
        {
        	return $this->response->item($invoiceDiscount, new InvoiceDiscountTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_discounts/{id}")
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
  		$invoiceDiscount = InvoiceDiscount::find($id);

        if ($invoiceDiscount == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $invoiceDiscount->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_discounts/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_discounts')
                    ->select(
                    	'invoice_discounts.id',
                    	'invoice_discounts.name',
                    	'invoice_discounts.amount',
                    	'invoice_discounts.percentage',
                    	'invoice_discounts.currency_id',
                    	'invoices.emited',
                    	'currencies.name AS currency_name')
            ->join('invoices', 'invoices.id', '=', 'invoice_discounts.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_discounts.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_discounts.invoice_id', $request->invoice_id);
  		}

		$invoiceDiscounts = $query->get();

  		return Datatables::of($invoiceDiscounts)->make(true);
  	}

}

?>