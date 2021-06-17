<?php

namespace App\Http\Controllers;

use App\Models\QuotationResource;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;


use Transformers\QuotationResourceTransformer;

/**
 * Modulo de QuotationResource
 *
 * @Resource("Group QuotationResource")
 */
class QuotationResourceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("quotation_resources{?company_id}")
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
     *  		"quotation_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = QuotationResource::join('currencies','currencies.id','=','quotation_resources.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('quotation_resources.id')
            ->with('seniority')
            ->with('projectRole')
            ->with('user');


  		/*if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}*/

        if ($request->has('quotation_id'))
        {
            $query->where('quotation_id', $request->quotation_id);
        }
  		$quotationResources = $query->get(['exchange_rates.currency_id','quotation_resources.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($quotationResources, new QuotationResourceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("quotation_resources")
	 * @Request({
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"rate_id": "int",
     *  		"currency_id": "int",
     *  		"load": "int",
     *  		"workplace": "enum",
     *  		"quotation_id": "int"
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
     *  		"quotation_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (
  			!$request->has('currency_id')
  			|| !$request->has('load')
  			|| !$request->has('user_id')
  			|| !$request->has('rate')
  		)
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $quotationResource = QuotationResource::create($data);

        if ($quotationResource)
        {
        	return $this->response->item($quotationResource, new QuotationResourceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("quotation_resources/{id}")
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
     *  		"quotation_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$quotationResource = QuotationResource::findOrFail($id);

  		return $this->response->item($quotationResource, new QuotationResourceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("quotation_resources/{id}")
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
     *  		"quotation_id": "int"
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
     *  		"quotation_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$quotationResource = QuotationResource::find($id);

  		if ($quotationResource == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $quotationResource->update($data);

        if ($quotationResource)
        {
        	return $this->response->item($quotationResource, new QuotationResourceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("quotation_resources/{id}")
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
  		$quotationResource = QuotationResource::find($id);

        if ($quotationResource == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $quotationResource->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("quotation_resources/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('quotation_resources')
                    ->select(
                    	'quotation_resources.id',
                    	'quotation_resources.user_id',
                    	'quotation_resources.currency_id',
                    	'quotation_resources.load',
                    	'quotation_resources.rate',
                    	'quotation_resources.hours',
                        DB::raw('hours * rate AS total'),
                    	'quotation_resources.type',
                    	'quotation_resources.project_role_id',
                    	'quotation_resources.seniority_id',
                    	'quotation_resources.workplace',
                    	'quotation_resources.comments',
                    	'quotations.emited',
                    	'currencies.name AS currency_name',
                    	'project_roles.title AS project_role_title',
                    	'seniorities.title AS seniority_title',
                    	'users.name AS user_name'
                    )
                    ->leftJoin('users', 'users.id', '=', 'quotation_resources.user_id')
                    ->leftJoin('project_roles', 'project_roles.id', '=', 'quotation_resources.project_role_id')
                    ->leftJoin('seniorities', 'seniorities.id', '=', 'quotation_resources.seniority_id')
                    ->leftJoin('quotations', 'quotations.id', '=', 'quotation_resources.quotation_id')
                    ->join('currencies', 'currencies.id', '=', 'quotation_resources.currency_id');

        if ($request->has('quotation_id'))
  		{
  			$query->where('quotation_resources.quotation_id', $request->quotation_id);
  		}

		$quotationResources = $query->get();

  		return Datatables::of($quotationResources)->make(true);
  	}

}

?>