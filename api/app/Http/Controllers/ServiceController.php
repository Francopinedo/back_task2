<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Service;
use Transformers\ServiceTransformer;

/**
 * Modulo de Services
 *
 * @Resource("Group Services")
 */
class ServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("services{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Service::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}
 if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        
  		$services = $query->get();

  		return $this->response->collection($services, new ServiceTransformer);
  	}

        public function index_export(Request $request)
    {
      $query = DB::table('services')
                    ->select(
                       'services.reimbursable', 'services.detail',
                      'services.amount', 'services.cost',
                      'currencies.name AS currency_name',
                      DB::raw('"Service" as `Type`'))
                    ->join('currencies', 'currencies.id', '=', 'services.currency_id')
                    ->leftJoin('currencies as cc', 'cc.id', '=', 'services.cost_currency_id');

        if ($request->has('company_id'))
      {
        $query->where('services.company_id', $request->company_id);
      }
       if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        
        $query->groupBy('services.id');

    $services = $query->get();

    return response()->json(array('data' => $services));

    }


  	/**
	 * Crear
	 *
	 * @Post("services")
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
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

        $service = Service::create($data);

        if ($service)
        {
        	return $this->response->item($service, new ServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$service = Service::findOrFail($id);

  		return $this->response->item($service, new ServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$service = Service::find($id);

  		if ($service == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $service->update($data);

        if ($service)
        {
        	return $this->response->item($service, new ServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("services/{id}")
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
  		$service = Service::find($id);

        if ($service == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $service->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("services/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('services')
                    ->select(
                    	'services.id', 'services.reimbursable', 'services.detail',
                    	'services.amount', 'services.cost',
                    	'services.cost_currency_id', 'services.currency_id',
                    	'services.company_id',
                    	'currencies.name AS currency_name',
                    	'cc.name as cc_name')
                    ->join('currencies', 'currencies.id', '=', 'services.currency_id')
                    ->leftJoin('currencies as cc', 'cc.id', '=', 'services.cost_currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('services.company_id', $request->company_id);
  		}
        $query->groupBy('services.id');

		$services = $query->get();

  		return Datatables::of($services)->make(true);
  	}

}

?>