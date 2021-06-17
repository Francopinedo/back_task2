<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ProcurementOffer;
use Transformers\ProcurementOfferTransformer;

/**
 * Modulo de ProcurementOffer
 *
 * @Resource("Group ProcurementOffer")
 */
class ProcurementOfferController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("procurement_offers{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = ProcurementOffer::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$procurementOffers = $query->get();

  		return $this->response->collection($procurementOffers, new ProcurementOfferTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("procurement_offers")
	 * @Request({
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (
  			!$request->has('procurement_id')
  			|| !$request->has('description')
  			|| !$request->has('cost')
  		)
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $procurementOffer = ProcurementOffer::create($data);

        if ($procurementOffer)
        {
        	return $this->response->item($procurementOffer, new ProcurementOfferTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("procurement_offers/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$procurementOffer = ProcurementOffer::findOrFail($id);

  		return $this->response->item($procurementOffer, new ProcurementOfferTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("procurement_offers/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"invoice_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$procurementOffer = ProcurementOffer::find($id);

  		if ($procurementOffer == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $procurementOffer->update($data);

        if ($procurementOffer)
        {
        	return $this->response->item($procurementOffer, new ProcurementOfferTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("procurement_offers/{id}")
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
  		$procurementOffer = ProcurementOffer::find($id);

        if ($procurementOffer == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $procurementOffer->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("procurement_offers/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('procurement_offers')
                    ->select(
                    	'procurement_offers.id',
                    	'procurement_offers.procurement_id',
                    	'procurement_offers.description',
                    	'procurement_offers.specifications',
                    	'procurement_offers.delivery_max_days_offered',
                    	'procurement_offers.delivery_responsable',
                    	'procurement_offers.cost',
                    	'procurement_offers.quality',
                    	'procurement_offers.provider_id',
                    	'procurement_offers.comment'
                    );

        if ($request->has('procurement_id'))
  		{
  			$query->where('procurement_offers.procurement_id', $request->procurement_id);
  		}

		$procurementOffers = $query->get();

  		return Datatables::of($procurementOffers)->make(true);
  	}

}

?>