<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Cost;
use Transformers\CostTransformer;

/**
 * Modulo de Costs
 *
 * @Resource("Group Cost")
 */
class CostController extends Controller {

  	/**
	 * Obtener costs
	 *
	 * @Get("costs{?include, company_id}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 *      @Parameter("company_id", description="ID de la compañia padre", default=null),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Cost::with('company', 'country', 'city', 'seniority', 'project_role', 'currency');
  		$query->where('company_id', $request->company_id);

  		$costs = $query->get();

  		return $this->response->collection($costs, new CostTransformer);
  	}

  	/**
	 * Crear Cost
	 *
	 * @Post("costs")
	 * @Request({
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('value') || !$request->has('company_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $cost = Cost::create($data);

        if ($cost)
        {
        	return $this->response->item($cost, new CostTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener cost
	 *
	 * @Get("costs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$cost = Cost::findOrFail($id);

  		return $this->response->item($cost, new CostTransformer);
  	}

  	/**
	 * Editar cost
	 *
	 * @Patch("costs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *    		"id": "int",
	 *   		"company_id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"seniority_id": "int",
     *  		"project_role_id": "int",
     *  		"workplace": "string",
     *  		"detail": "string",
     *  		"value": "float",
     *  		"currency_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$cost = Cost::find($id);

  		if ($cost == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $cost->update($data);

        if ($cost)
        {
        	return $this->response->item($cost, new CostTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una cost
     *
     * @Delete("costs/{id}")
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
  		$cost = Cost::find($id);

        if ($cost == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $cost->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener costs
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("costs/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$companyId = ($request->has('company_id')) ? $request->company_id : null;

  		$query = DB::table('costs')
                    ->select(
                    	'costs.id', 'costs.company_id', 'costs.country_id', 'costs.city_id',
                    	'costs.seniority_id', 'costs.project_role_id', 'costs.workplace',
                    	'costs.detail', 'costs.value', 'costs.currency_id',
                    	'countries.name AS country_name',
                    	'cities.name AS city_name',
                    	'seniorities.title AS seniority_title',
                    	'project_roles.title AS project_role_title',
                    	'currencies.name AS currency_name');

        if (!empty($companyId))
        {
        	$query->where('costs.company_id', $companyId);
        }

        $query->join('countries', 'countries.id', '=', 'costs.country_id');
    	$query->join('cities', 'cities.id', '=', 'costs.city_id');
    	$query->join('seniorities', 'seniorities.id', '=', 'costs.seniority_id');
    	$query->join('project_roles', 'project_roles.id', '=', 'costs.project_role_id');
    	$query->join('currencies', 'currencies.id', '=', 'costs.currency_id');

        $costs = $query->get();

  		return Datatables::of($costs)->make(true);
  	}

}

?>