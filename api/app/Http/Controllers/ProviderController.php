<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Dingo\Api\Routing\Helpers;

use App\Models\Provider;
use Transformers\ProviderTransformer;

/**
 * Modulo de Provider
 *
 * @Resource("Group Provider")
 */
class ProviderController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("providers{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *      "country_id": "int",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Provider::with('industry')->select('providers.*');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$providers = $query->get();

  		return $this->response->collection($providers, new ProviderTransformer);
  	}

  	/**
	 * Crear compania
	 *
	 * @Post("providers")
	 * @Request({
     *  		"name": "string",
     *  		"address": "string (opt)",
     *      "country_id": "int (opt)",
     *  		"city_id": "int (opt)",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string (opt)",
     *  		"billing_address": "string (opt)",
     *  		"tax_number": "string (opt)",
     *  		"bank_name": "string (opt)",
     *  		"account_number": "string (opt)",
     *  		"swiftcode": "string (opt)",
     *  		"aba": "string (opt)",
     *  		"currency_id": "int (opt)",
     *  		"industry_id": "int (opt)",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *      "country_id": "int",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $provider = Provider::create($data);

        if ($provider)
        {
        	return $this->response->item($provider, new ProviderTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener compania
	 *
	 * @Get("providers/{id}{?include}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *      "country_id": "int",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$provider = Provider::with('industry', 'country', 'city', 'currency')->findOrFail($id);

  		return $this->response->item($provider, new ProviderTransformer);
  	}

  	/**
	 * Editar compania
	 *
	 * @Patch("providers/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"name": "string",
     *  		"address": "string" (opt),
     *      "country_id": "int (opt)",
     *  		"city_id": "int" (opt),
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string" (opt),
     *  		"billing_address": "string" (opt),
     *  		"tax_number": "string" (opt),
     *  		"bank_name": "string" (opt),
     *  		"account_number": "string" (opt),
     *  		"swiftcode": "string" (opt),
     *  		"aba": "string" (opt),
     *  		"currency_id": "int" (opt),
     *  		"industry_id": "int (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *      "country_id": "int",
     *  		"city_id": "int",
     *  		"email_1": "string",
     *  		"email_2": "string",
     *  		"email_3": "string",
     *  		"phone_1": "string",
     *  		"phone_2": "string",
     *  		"phone_3": "string",
     *  		"billing_name": "string",
     *  		"billing_address": "string",
     *  		"tax_number": "string",
     *  		"bank_name": "string",
     *  		"account_number": "string",
     *  		"swiftcode": "string",
     *  		"aba": "string",
     *  		"currency_id": "int",
     *  		"industry_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$provider = Provider::find($id);

  		if ($provider == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $provider->update($data);

        if ($provider)
        {
        	return $this->response->item($provider, new ProviderTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una compania
     *
     * @Delete("providers/{id}")
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
  		$provider = Provider::find($id);

        if ($provider == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $provider->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener companias
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("providers/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('providers')
                    ->select(
                    	'providers.id',
                    	'providers.name',
                    	'providers.address',
                     'providers.country_id',
                    	'providers.city_id',
                    	'providers.email_1',
                    	'providers.email_2',
                    	'providers.email_3',
                    	'providers.phone_1',
                    	'providers.phone_2',
                    	'providers.phone_3',
                    	'providers.billing_name',
                    	'providers.billing_address',
                    	'providers.tax_number',
                    	'providers.bank_name',
                    	'providers.account_number',
                    	'providers.swiftcode',
                    	'providers.aba',
                    	'providers.currency_id',
                    	'providers.industry_id',
                    	'providers.company_id',
                    	'industries.name AS industry_name',
                    	'currencies.name AS currency_name',
                     'countries.name AS country_name',
                    	'cities.name AS city_name',
                     'providers.logo_path AS logo_path'
                    );

        $query->leftJoin('industries', 'industries.id', '=', 'providers.industry_id');
        $query->leftJoin('currencies', 'currencies.id', '=', 'providers.currency_id');
        $query->leftJoin('countries', 'countries.id', '=', 'providers.country_id');
        $query->leftJoin('cities', 'cities.id', '=', 'providers.city_id');

        if ($request->has('company_id'))
  		{
  			$query->where('providers.company_id', $request->company_id);
  		}

        $providers = $query->get();

  		return Datatables::of($providers)->make(true);
  	}

}

?>
