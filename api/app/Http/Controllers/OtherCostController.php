<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\OtherCost;
use Transformers\OtherCostTransformer;

/**
 * Modulo de OtherCosts
 *
 * @Resource("Group OtherCosts")
 */
class OtherCostController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("other_costs{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = OtherCost::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$otherCosts = $query->get();

  		return $this->response->collection($otherCosts, new OtherCostTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("other_costs")
	 * @Request({
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('detail') || !$request->has('value'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $otherCost = OtherCost::create($data);

        if ($otherCost)
        {
        	return $this->response->item($otherCost, new OtherCostTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("other_costs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$otherCost = OtherCost::findOrFail($id);

  		return $this->response->item($otherCost, new OtherCostTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("other_costs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"from": "date",
     *  		"to": "date",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$otherCost = OtherCost::find($id);

  		if ($otherCost == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $otherCost->update($data);

        if ($otherCost)
        {
        	return $this->response->item($otherCost, new OtherCostTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("other_costs/{id}")
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
  		$otherCost = OtherCost::find($id);

        if ($otherCost == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $otherCost->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("other_costs/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('other_costs')
                    ->select(
                    	'other_costs.id', 'other_costs.detail', 'other_costs.value',
                    	'other_costs.currency_id', 'other_costs.company_id',
                    	'other_costs.from', 'other_costs.to',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'other_costs.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('other_costs.company_id', $request->company_id);
  		}

		$otherCosts = $query->get();

  		return Datatables::of($otherCosts)->make(true);
  	}

}

?>