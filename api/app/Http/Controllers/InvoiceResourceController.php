<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceResource;
use Transformers\InvoiceResourceTransformer;

/**
 * Modulo de InvoiceResource
 *
 * @Resource("Group InvoiceResource")
 */
class InvoiceResourceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_resources{?company_id}")
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
  		$query = InvoiceResource::join('currencies','currencies.id','=','invoice_resources.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_resources.id')
            ->with('seniority')
            ->with('projectRole')
            ->with('user');


  		/*if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}*/

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }
  		$invoiceResources = $query->get(['exchange_rates.currency_id','invoice_resources.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($invoiceResources, new InvoiceResourceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_resources")
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
  			!$request->has('currency_id')
  			|| !$request->has('load')
  			|| !$request->has('user_id')
  			|| !$request->has('rate')
  		)
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $invoiceResource = InvoiceResource::create($data);

        if ($invoiceResource)
        {
        	return $this->response->item($invoiceResource, new InvoiceResourceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_resources/{id}")
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
  		$invoiceResource = InvoiceResource::findOrFail($id);

  		return $this->response->item($invoiceResource, new InvoiceResourceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_resources/{id}")
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
  		$invoiceResource = InvoiceResource::find($id);

  		if ($invoiceResource == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $invoiceResource->update($data);

        if ($invoiceResource)
        {
        	return $this->response->item($invoiceResource, new InvoiceResourceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_resources/{id}")
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
  		$invoiceResource = InvoiceResource::find($id);

        if ($invoiceResource == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $invoiceResource->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_resources/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_resources')
                    ->select(
                    	'invoice_resources.id',
                    	'invoice_resources.user_id',
                    	'invoice_resources.currency_id',
                    	'invoice_resources.load',
                    	'invoice_resources.rate',
                    	'invoice_resources.hours',
                        DB::raw('hours * rate AS total'),
                    	'invoice_resources.type',
                    	'invoice_resources.project_role_id',
                    	'invoice_resources.seniority_id',
                    	'invoice_resources.workplace',
                    	'invoice_resources.comments',
                    	'invoices.emited',
                    	'currencies.name AS currency_name',
                    	'project_roles.title AS project_role_title',
                    	'seniorities.title AS seniority_title',
                    	'users.name AS user_name'
                    )
                    ->leftJoin('users', 'users.id', '=', 'invoice_resources.user_id')
                    ->leftJoin('project_roles', 'project_roles.id', '=', 'invoice_resources.project_role_id')
                    ->leftJoin('seniorities', 'seniorities.id', '=', 'invoice_resources.seniority_id')
                    ->leftJoin('invoices', 'invoices.id', '=', 'invoice_resources.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_resources.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_resources.invoice_id', $request->invoice_id);
  		}

		$invoiceResources = $query->get();

  		return Datatables::of($invoiceResources)->make(true);
  	}

}

?>