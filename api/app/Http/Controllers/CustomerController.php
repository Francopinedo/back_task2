<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Customer;
use Transformers\CustomerTransformer;

/**
 * Modulo de customers
 *
 * @Resource("Group Customer")
 */
class CustomerController extends Controller {

  	/**
	 * Obtener customers
	 *
	 * @Get("customers{?include, company_id}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 *      @Parameter("company_id", description="ID de la compañia padre", default=null),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"name": "string",
     *  		"address": "string",
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
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Customer::with('industry', 'currency', 'city');

  		if ($request->has('company_id'))
  		{
	  		$query->where('company_id', $request->company_id);
  		}

if ($request->has('customer_id'))
  		{
	  		$query->where('id', $request->customer_id);
  		}

  		$customers = $query->get();

  		return $this->response->collection($customers, new CustomerTransformer);
  	}

  	/**
	 * Crear Customers
	 *
	 * @Post("customers")
	 * @Request({
	 * 			"comany_id": "string",
     *  		"name": "string",
     *  		"address": "string (opt)",
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
	 *   		"company_id": "int",
     *  		"name": "string",
     *  		"address": "string",
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
  		if (!$request->has('name') || !$request->has('company_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $customer = Customer::create($data);

        if ($customer)
        {
        	return $this->response->item($customer, new CustomerTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener customer
	 *
	 * @Get("customers/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$customer = Customer::findOrFail($id);

  		return $this->response->item($customer, new CustomerTransformer);
  	}

  	/**
	 * Editar customer
	 *
	 * @Patch("customers/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"company_id": "int",
     *  		"name": "string",
     *  		"address": "string (opt)",
     *  		"city_id": "int (opt)",
     *  		"industry_id": "int (opt)",
     *  		"email": "string (opt)",
     *  		"phone": "string (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"name": "string",
     *  		"address": "string",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$customer = Customer::find($id);

  		if ($customer == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $customer->update($data);

        if ($customer)
        {
        	return $this->response->item($customer, new CustomerTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una customer
     *
     * @Delete("customers/{id}")
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
  		$customer = Customer::find($id);

        if ($customer == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $customer->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener customers
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("customers/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$userId = ($request->has('user_id')) ? $request->user_id : null;

  		$query = DB::table('customers')
                    ->select(
                    	'customers.id', 'customers.company_id', 'customers.name', 'customers.address', 'customers.city_id',
                    	'customers.industry_id', 'customers.email', 'customers.phone');

        if (!empty($userId))
        {
        	$query->where('user_companies.user_id', $userId);
        	$query->join('user_companies', 'user_companies.company_id', '=', 'customers.company_id');
        }

        $customers = $query->get();

  		return Datatables::of($customers)->make(true);
  	}

}

?>
