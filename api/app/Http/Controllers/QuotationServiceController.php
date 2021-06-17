<?php

namespace App\Http\Controllers;

use App\Models\QuotationService;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;


use Transformers\QuotationServiceTransformer;

/**
 * Modulo de QuotationService
 *
 * @Resource("Group QuotationService")
 */
class QuotationServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("quotation_services{?company_id}")
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
  		$query = QuotationService::join('currencies','currencies.id','=','quotation_services.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left');

  		if($request->has('grouped') && $request->grouped==1){
            $query->groupBy('quotation_services.detail');
        }else{
            $query ->groupBy('quotation_services.id');
        }



        if ($request->has('quotation_id'))
        {
            $query->where('quotation_id', $request->quotation_id);
        }

  		$quotationServices = $query->get(['exchange_rates.currency_id','quotation_services.*','exchange_rates.value', 'currencies.code',
            DB::raw('sum(quotation_services.amount) as amount_grouped')]);

  		return $this->response->collection($quotationServices, new QuotationServiceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("quotation_services")
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

        $quotationService = QuotationService::create($data);

        if ($quotationService)
        {
        	return $this->response->item($quotationService, new QuotationServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("quotation_services/{id}")
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
  		$quotationService = QuotationService::findOrFail($id);

  		return $this->response->item($quotationService, new QuotationServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("quotation_services/{id}")
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
  		$quotationService = QuotationService::find($id);

  		if ($quotationService == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $quotationService->update($data);

        if ($quotationService)
        {
        	return $this->response->item($quotationService, new QuotationServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("quotation_services/{id}")
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
  		$quotationService = QuotationService::find($id);

        if ($quotationService == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $quotationService->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("quotation_services/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('quotation_services')
                    ->select(
                    	'quotation_services.id',
                    	'quotation_services.detail',
                    	'quotation_services.cost',
                    	'quotation_services.amount',
                    	'quotation_services.currency_id',
                    	'quotation_services.quotation_id',
                    	'quotations.emited',
                    	'currencies.name AS currency_name')
                    ->join('quotations', 'quotations.id', '=', 'quotation_services.quotation_id')
                    ->join('currencies', 'currencies.id', '=', 'quotation_services.currency_id');

        if ($request->has('quotation_id'))
  		{
  			$query->where('quotation_services.quotation_id', $request->quotation_id);
  		}

		$quotationServices = $query->get();

  		return Datatables::of($quotationServices)->make(true);
  	}



    public function datatables_grouped(Request $request)
    {


        $query = DB::table('quotation_services')
            ->select(
                'quotation_services.id',
                DB::raw('sum(quotation_services.amount) as amount'),
                'quotation_services.detail',
                'quotation_services.cost',
               // 'quotation_services.amount',
                'quotation_services.currency_id',
                'quotation_services.quotation_id',
                'quotations.emited',
                'currencies.name AS currency_name')
            ->join('quotations', 'quotations.id', '=', 'quotation_services.quotation_id')
            ->join('currencies', 'currencies.id', '=', 'quotation_services.currency_id');

        if ($request->has('quotation_id'))
        {
            $query->where('quotation_services.quotation_id', $request->quotation_id);
        }

        $quotationServices = $query->get();
        $query->groupby('quotation_services.detail');
        return Datatables::of($quotationServices)->make(true);


    }

}

?>