<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Events\CompanyCreatedEvent;
use Dingo\Api\Routing\Helpers;

use App\Models\Company;
use App\Models\User;
use Transformers\CompanyTransformer;

/**
 * Modulo de companias
 *
 * @Resource("Group Company")
 */
class CompanyController extends Controller {

  	/**
	 * Obtener companias
	 *
	 * @Get("companies{?include}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *          "country_id": "int",
     *  		"city_id": "int",
     *  		"email": "int",
     *  		"phone": "string",
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
  		$query = Company::with('industry, city')->select('companies.*');

  		$companies = $query->get();

  		return $this->response->collection($companies, new CompanyTransformer);
  	}

  	/**
	 * Crear compania
	 *
	 * @Post("companies")
	 * @Request({
     *  		"name": "string",
     *  		"address": "string (opt)",
     *          "country_id": "int",
     *  		"city_id": "int (opt)",
     *  		"email": "int (opt)",
     *  		"phone": "string (opt)",
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
     *          "country_id": "int",
     *  		"city_id": "int",
     *  		"email": "int",
     *  		"phone": "string",
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

        $company = Company::create($data);

        if ($company)
        {
        	event(new CompanyCreatedEvent($company));

        	return $this->response->item($company, new CompanyTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener compania
	 *
	 * @Get("companies/{id}{?include}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *          "country_id": "int",
     *  		"city_id": "int",
     *  		"email": "int",
     *  		"phone": "string",
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
  		$company = Company::with('industry', 'city', 'currency')->findOrFail($id);

  		return $this->response->item($company, new CompanyTransformer);
  	}

  	public function fromUser($user_id)
  	{
  		$user = User::find($user_id);


  		// Reviso si es el usuario admin de empresa o uno creado por el admin de empresa
  		if (empty($user->user_id))
  		{

            $company = Company::with('industry', 'city', 'currency')
                ->where('user_id', '=',$user_id)->first();
  		}
  		else
  		{
  			//$company = Company::select('id')->where('user_id', $user->user_id)->first();
            $company = Company::with('industry', 'city', 'currency')->where('user_id', $user->user_id)->first();
  		}

  		//return $this->api->get('companies/'.$company->id);

     //  var_dump($company);
  		return $this->response->item($company, new CompanyTransformer);
  	}

  	/**
	 * Editar compania
	 *
	 * @Patch("companies/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"name": "string",
     *  		"address": "string" (opt),
     *          "country_id": "int",
     *  		"city_id": "int" (opt),
     *  		"email": "int" (opt),
     *  		"phone": "string" (opt),
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
     *          "country_id": "int",
     *  		"city_id": "int",
     *  		"email": "int",
     *  		"phone": "string",
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
  		$company = Company::find($id);

  		if ($company == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $company->update($data);

        if ($company)
        {
        	return $this->response->item($company, new CompanyTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una compania
     *
     * @Delete("companies/{id}")
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
        $company = Company::find($id);

        if ($company == NULL)
        {
            return $this->response->error('No existe', 450);
        }

        foreach($company->domain->mails as $mail)
        {
            $mail->delete();
        }
        $company->domain->delete();
        $company->delete();

        return $this->response->noContent();
    }

  	/**
	 * Obtener companias
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("companies/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('companies')
                    ->select(
                    	'companies.id', 'companies.name', 'companies.address', 'companies.country_id', 'companies.city_id', 'companies.email',
                    	'companies.phone', 'companies.billing_name', 'companies.billing_address', 'companies.tax_number1',
                    	'companies.bank_name', 'companies.account_number', 'companies.swiftcode', 'companies.aba',
                    	'companies.currency_id', 'companies.industry_id', 'industries.name AS industry_name', 'cities.name AS city_name', 'countries.name AS country_name');

        $query->leftJoin('industries', 'industries.id', '=', 'companies.industry_id');
        $query->leftJoin('countries', 'countries.id', '=', 'companies.country_id');
        $query->leftJoin('cities', 'cities.id', '=', 'companies.city_id');


        $companies = $query->get();

  		return Datatables::of($companies)->make(true);
  	}

}

?>