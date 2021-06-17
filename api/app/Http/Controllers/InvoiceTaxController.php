<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceTax;
use Transformers\InvoiceTaxTransformer;

/**
 * Modulo de InvoiceTax
 *
 * @Resource("Group InvoiceTax")
 */
class InvoiceTaxController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_taxes{?company_id}")
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
  		$query = InvoiceTax::join('currencies','currencies.id','=','invoice_taxes.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_taxes.id');

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }

  		$invoiceTaxes = $query->get(['exchange_rates.currency_id','invoice_taxes.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceTaxes, new InvoiceTaxTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_taxes")
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

        $invoiceTax = InvoiceTax::create($data);

        if ($invoiceTax)
        {
        	return $this->response->item($invoiceTax, new InvoiceTaxTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_taxes/{id}")
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
  		$invoiceTax = InvoiceTax::findOrFail($id);

  		return $this->response->item($invoiceTax, new InvoiceTaxTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_taxes/{id}")
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
  		$invoiceTax = InvoiceTax::find($id);

  		if ($invoiceTax == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $invoiceTax->update($data);

        if ($invoiceTax)
        {
        	return $this->response->item($invoiceTax, new InvoiceTaxTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_taxes/{id}")
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
  		$invoiceTax = InvoiceTax::find($id);

        if ($invoiceTax == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $invoiceTax->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_taxes/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_taxes')
                    ->select(
                    	'invoice_taxes.id',
                    	'invoice_taxes.name',
                    	'invoice_taxes.amount',
                    	'invoice_taxes.percentage',
                    	'invoice_taxes.currency_id',
                    	'invoices.emited',
                    	'currencies.name AS currency_name')
            ->join('invoices', 'invoices.id', '=', 'invoice_taxes.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_taxes.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_taxes.invoice_id', $request->invoice_id);
  		}

		$invoiceTaxes = $query->get();

  		return Datatables::of($invoiceTaxes)->make(true);
  	}

}

?>