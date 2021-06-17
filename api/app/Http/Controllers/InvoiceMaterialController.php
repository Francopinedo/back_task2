<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceMaterial;
use Transformers\InvoiceMaterialTransformer;

/**
 * Modulo de InvoiceMaterial
 *
 * @Resource("Group InvoiceMaterial")
 */
class InvoiceMaterialController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_materials{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = InvoiceMaterial::join('currencies','currencies.id','=','invoice_materials.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_materials.id');

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }
  		$invoiceMaterials = $query->get(['exchange_rates.currency_id','invoice_materials.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceMaterials, new InvoiceMaterialTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_materials")
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
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
  		if (!$request->has('invoice_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $invoiceMaterial = InvoiceMaterial::create($data);

        if ($invoiceMaterial)
        {
        	return $this->response->item($invoiceMaterial, new InvoiceMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$invoiceMaterial = InvoiceMaterial::findOrFail($id);

  		return $this->response->item($invoiceMaterial, new InvoiceMaterialTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
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
  		$invoiceMaterial = InvoiceMaterial::find($id);

  		if ($invoiceMaterial == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $invoiceMaterial->update($data);

        if ($invoiceMaterial)
        {
        	return $this->response->item($invoiceMaterial, new InvoiceMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_materials/{id}")
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
  		$invoiceMaterial = InvoiceMaterial::find($id);

        if ($invoiceMaterial == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $invoiceMaterial->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_materials/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_materials')
                    ->select(
                    	'invoice_materials.id',
                    	'invoice_materials.detail',
                    	'invoice_materials.cost',
                    	'invoice_materials.amount',
                        'invoices.emited',
                    	'invoice_materials.currency_id',
                    	'currencies.name AS currency_name')
            ->join('invoices', 'invoices.id', '=', 'invoice_materials.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_materials.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_materials.invoice_id', $request->invoice_id);
  		}

		$invoiceMaterials = $query->get();

  		return Datatables::of($invoiceMaterials)->make(true);
  	}

}

?>