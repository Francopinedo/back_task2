<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Rate;
use Transformers\RateTransformer;

/**
 * Modulo de rates
 *
 * @Resource("Group Rates")
 */
class RateController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("rates{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Rate::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		if ($request->has('project_role_id'))
  		{
  			$query->where('project_role_id', $request->project_role_id);
  		}

  		if ($request->has('seniority_id'))
  		{
  			$query->where('seniority_id', $request->seniority_id);
  		}

  		if ($request->has('currency_id'))
  		{
  			$query->where('currency_id', $request->currency_id);
  		}

  		if ($request->has('workplace'))
  		{
  			$query->where('workplace', $request->workplace);
  		}

  		if ($request->has('country_id'))
  		{
  			$query->where('country_id', $request->country_id);
  		}

  		if ($request->has('office_id'))
  		{
  			$query->where('office_id', $request->office_id);
  		}

  		$rates = $query->get();

  		return $this->response->collection($rates, new RateTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("rates")
	 * @Request({
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('country_id') || !$request->has('project_role_id') || !$request->has('seniority_id') || !$request->has('title') || !$request->has('value') || !$request->has('currency_id') || !$request->has('workplace'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $rate = Rate::create($data);

        if ($rate)
        {
        	return $this->response->item($rate, new RateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("rates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$rate = Rate::findOrFail($id);

  		return $this->response->item($rate, new RateTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("rates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"project_role_id": "int",
     *  		"seniority_id": "int",
     *  		"title": "string",
     *  		"value": "float",
     *  		"currency_id": "int",
     *  		"workplace": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$rate = Rate::find($id);

  		if ($rate == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $rate->update($data);

        if ($rate)
        {
        	return $this->response->item($rate, new RateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("rates/{id}")
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
  		$rate = Rate::find($id);

        if ($rate == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $rate->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("rates/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('rates')
                    ->select(
                    	'rates.id', 'rates.title', 'rates.country_id',
                    	'rates.city_id', 'rates.project_role_id',
                    	'rates.seniority_id',
                    	'rates.value', 'rates.workplace',
                    	'countries.name AS country_name',
                    	'cities.name AS city_name',
                    	'project_roles.title AS project_role_title',
                    	'seniorities.title AS seniority_title',
                    	'offices.title AS office_name',
                    	'seniorities.title AS seniority_title',
                    	'currencies.name AS currency_name')
                    ->join('countries', 'countries.id', '=', 'rates.country_id')
                    ->join('cities', 'cities.id', '=', 'rates.city_id')
                    ->join('project_roles', 'project_roles.id', '=', 'rates.project_role_id')
                    ->join('seniorities', 'seniorities.id', '=', 'rates.seniority_id')
                    ->join('offices', 'offices.id', '=', 'rates.office_id')
                    ->join('currencies', 'currencies.id', '=', 'rates.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('rates.company_id', $request->company_id);
  		}

		$rates = $query->get();

  		return Datatables::of($rates)->make(true);
  	}

}

?>