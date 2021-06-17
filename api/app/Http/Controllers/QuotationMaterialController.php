<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\QuotationMaterial;
use Transformers\QuotationMaterialTransformer;

/**
 * Modulo de QuotationMaterial
 *
 * @Resource("Group QuotationMaterial")
 */
class QuotationMaterialController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("quotation_materials{?company_id}")
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
  		$query = QuotationMaterial::join('currencies','currencies.id','=','quotation_materials.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left');
          if($request->has('grouped') && $request->grouped==1){
              $query->groupBy('quotation_materials.detail');
          }else{
              $query ->groupBy('quotation_materials.id');
          }

        if ($request->has('quotation_id'))
        {
            $query->where('quotation_id', $request->quotation_id);
        }
  		$quotationMaterials = $query->get(['exchange_rates.currency_id','quotation_materials.*','exchange_rates.value', 'currencies.code',
            DB::raw('sum(quotation_materials.amount) as amount_grouped')]);

  		return $this->response->collection($quotationMaterials, new QuotationMaterialTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("quotation_materials")
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
     *  		"quotation_id": "int",
     *  		"file": "string"
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

        $quotationMaterial = QuotationMaterial::create($data);

        if ($quotationMaterial)
        {
        	return $this->response->item($quotationMaterial, new QuotationMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("quotation_materials/{id}")
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
  		$quotationMaterial = QuotationMaterial::findOrFail($id);

  		return $this->response->item($quotationMaterial, new QuotationMaterialTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("quotation_materials/{id}")
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
  		$quotationMaterial = QuotationMaterial::find($id);

  		if ($quotationMaterial == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $quotationMaterial->update($data);

        if ($quotationMaterial)
        {
        	return $this->response->item($quotationMaterial, new QuotationMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("quotation_materials/{id}")
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
  		$quotationMaterial = QuotationMaterial::find($id);

        if ($quotationMaterial == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $quotationMaterial->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("quotation_materials/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('quotation_materials')
                    ->select(
                    	'quotation_materials.id',
                    	'quotation_materials.detail',
                    	'quotation_materials.cost',
                    	'quotation_materials.amount',
                        'quotations.emited',
                    	'quotation_materials.currency_id',
                    	'currencies.name AS currency_name')
            ->join('quotations', 'quotations.id', '=', 'quotation_materials.quotation_id')
                    ->join('currencies', 'currencies.id', '=', 'quotation_materials.currency_id');

        if ($request->has('quotation_id'))
  		{
  			$query->where('quotation_materials.quotation_id', $request->quotation_id);
  		}

		$quotationMaterials = $query->get();

  		return Datatables::of($quotationMaterials)->make(true);
  	}

}

?>