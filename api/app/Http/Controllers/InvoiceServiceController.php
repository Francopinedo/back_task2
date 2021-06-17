<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceService;
use Transformers\InvoiceServiceTransformer;

/**
 * Modulo de InvoiceService
 *
 * @Resource("Group InvoiceService")
 */
class InvoiceServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_services{?company_id}")
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
  		$query = InvoiceService::join('currencies','currencies.id','=','invoice_services.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_services.id');

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }

  		$invoiceServices = $query->get(['exchange_rates.currency_id','invoice_services.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceServices, new InvoiceServiceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_services")
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

        $invoiceService = InvoiceService::create($data);

        if ($invoiceService)
        {
        	return $this->response->item($invoiceService, new InvoiceServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_services/{id}")
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
  		$invoiceService = InvoiceService::findOrFail($id);

  		return $this->response->item($invoiceService, new InvoiceServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_services/{id}")
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
  		$invoiceService = InvoiceService::find($id);

  		if ($invoiceService == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $invoiceService->update($data);

        if ($invoiceService)
        {
        	return $this->response->item($invoiceService, new InvoiceServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_services/{id}")
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
  		$invoiceService = InvoiceService::find($id);

        if ($invoiceService == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $invoiceService->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_services/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_services')
                    ->select(
                    	'invoice_services.id',
                    	'invoice_services.detail',
                    	'invoice_services.cost',
                    	'invoice_services.amount',
                    	'invoice_services.currency_id',
                    	'invoice_services.invoice_id',
                    	'invoices.emited',
                    	'currencies.name AS currency_name')
                    ->join('invoices', 'invoices.id', '=', 'invoice_services.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_services.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_services.invoice_id', $request->invoice_id);
  		}

		$invoiceServices = $query->get();

  		return Datatables::of($invoiceServices)->make(true);
  	}

}

?>