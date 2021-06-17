<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\ExchangeRate;
use Transformers\ExchangeRateTransformer;

/**
 * Modulo de ExchangeRate
 *
 * @Resource("Group ExchangeRate")
 */
class ExchangeRateController extends Controller {

  	/**
	 * Obtener exchange rate
	 *
	 * @Get("exchange_rates{?include,company_id}")
	 * @Parameters({
	 * 		@Parameter("include", description="Tablas relacionadas", default=null),
 	 *      @Parameter("company_id", description="ID de la compañia padre", default=null),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"currency_id: "int",
     *  		"value": "double"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$exchangeRates = ExchangeRate::with('currency')->where('company_id', $request->company_id)->get();

  		return $this->response->collection($exchangeRates, new ExchangeRateTransformer);
  	}

  	/**
	 * Crear exchange rate
	 *
	 * @Post("exchange_rates")
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('currency_id') || !$request->has('company_id') || !$request->has('value'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $exchangeRate = ExchangeRate::create($data);

        if ($exchangeRate)
        {
        	return $this->response->item($exchangeRate, new ExchangeRateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener exchange rate
	 *
	 * @Get("exchange_rates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$exchangeRate = ExchangeRate::findOrFail($id);

  		return $this->response->item($exchangeRate, new ExchangeRateTransformer);
  	}

  	/**
	 * Editar exchange rate
	 *
	 * @Patch("exchange_rates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$exchangeRate = ExchangeRate::find($id);

  		if ($exchangeRate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $exchangeRate->update($data);

        if ($exchangeRate)
        {
        	return $this->response->item($exchangeRate, new ExchangeRateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un exchange rate
     *
     * @Delete("exchange_rates/{id}")
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
  		$exchangeRate = ExchangeRate::find($id);

        if ($exchangeRate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $exchangeRate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener templates de ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("exchange_rates/datatables")
	 */
  	public function datatables()
  	{
  		$query = DB::table('exchange_rates')
                    ->select(
                    	'exchange_rates.id', 'exchange_rates.currency_id', 'exchange_rates.company_id',
                    	'exchange_rates.value','exchange_rates.quotation_url','exchange_rates.quotation_date', 'companies.name AS company_name',
                    	'currencies.name AS currency_name');

        $query->join('companies', 'companies.id', '=', 'exchange_rates.company_id');
        $query->join('currencies', 'currencies.id', '=', 'exchange_rates.currency_id');

     	$exchangeRates = $query ->get();

  		return Datatables::of($exchangeRates)->make(true);
  	}

}

?>
