<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Tax;
use Transformers\TaxTransformer;

/**
 * Modulo de Tax
 *
 * @Resource("Group Tax")
 */
class TaxController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("taxes{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Tax::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$taxes = $query->get();

  		return $this->response->collection($taxes, new TaxTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("taxes")
	 * @Request({
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('detail') || !$request->has('country_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $tax = Tax::create($data);

        if ($tax)
        {
        	return $this->response->item($tax, new TaxTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("taxes/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "int",
     *  		"value: "float",
     *  		"company_id": "int",
     *  		"currency_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$tax = Tax::findOrFail($id);

  		return $this->response->item($tax, new TaxTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("taxes/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "int",
     *  		"value: "float",
     *  		"company_id": "int",
     *  		"currency_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		*   		"id": "int",
     *  		"detail": "string",
     *  		"percentage": "int",
     *  		"country_id": "int",
     *  		"value: "float",
     *  		"company_id": "int",
     *  		"currency_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$tax = Tax::find($id);

  		if ($tax == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $tax->update($data);

        if ($tax)
        {
        	return $this->response->item($tax, new TaxTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("taxes/{id}")
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
  		$tax = Tax::find($id);

        if ($tax == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $tax->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("taxes/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('taxes')
                    ->select(
                    	'taxes.id',
                    	'taxes.detail',
                    	'taxes.percentage',
                    	'taxes.value',
                    	'taxes.country_id',
                    	'taxes.currency_id',
                    	'taxes.company_id',
                    	'countries.name AS country_name',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'taxes.currency_id')
                    ->join('countries', 'countries.id', '=', 'taxes.country_id');

        if ($request->has('company_id'))
  		{
  			$query->where('taxes.company_id', $request->company_id);
  		}

		$taxes = $query->get();

  		return Datatables::of($taxes)->make(true);
  	}

}

?>