<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Discount;
use Transformers\DiscountTransformer;

/**
 * Modulo de Discounts
 *
 * @Resource("Group Discounts")
 */
class DiscountController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("discounts{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Discount::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$discounts = $query->get();

  		return $this->response->collection($discounts, new DiscountTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("discounts")
	 * @Request({
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
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

        $discount = Discount::create($data);

        if ($discount)
        {
        	return $this->response->item($discount, new DiscountTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("discounts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$discount = Discount::findOrFail($id);

  		return $this->response->item($discount, new DiscountTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("discounts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"detail": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"company_id": "int
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$discount = Discount::find($id);

  		if ($discount == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $discount->update($data);

        if ($discount)
        {
        	return $this->response->item($discount, new DiscountTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("discounts/{id}")
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
  		$discount = Discount::find($id);

        if ($discount == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $discount->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("discounts/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('discounts')
                    ->select(
                    	'discounts.id',
                    	'discounts.detail',
                    	'discounts.amount',
                    	'discounts.percentage',
                    	'discounts.currency_id',
                    	'discounts.company_id',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'discounts.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('discounts.company_id', $request->company_id);
  		}

		$discounts = $query->get();

  		return Datatables::of($discounts)->make(true);
  	}

}

?>