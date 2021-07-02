<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Contact;
use Transformers\ContactTransformer;

/**
 * Modulo de Contact
 *
 * @Resource("Group Contact")
 */
class ContactController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("contacts{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Contact::with('project');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);

  		}

      if ($request->has('user_id'))
  		{
  			$query->where('contacts.user_id', $request->user_id);
  		}

      if ($request->has('company_id'))
      {
         $query->where('contacts.company_id', $request->company_id);
      }

		
  		$contacts = $query->get();

  		return $this->response->collection($contacts, new ContactTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("contacts")
	 * @Request({
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('company') || !$request->has('department')
            || !$request->has('country_id') || !$request->has('industry_id') || !$request->has('email') || !$request->has('phone'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $contact = Contact::create($data);

        if ($contact)
        {
        	return $this->response->item($contact, new ContactTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("contacts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$contact = Contact::findOrFail($id);

  		return $this->response->item($contact, new ContactTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("contacts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"company_id": "int",
     *  		"project_id": "int",
     *  		"name": "string",
     *  		"company": "string",
     *  		"deparment": "string",
     *  		"country_id": "int",
     *  		"city_id": "int",
     *  		"industry_id": "int",
     *  		"email": "string",
     *  		"phone": "string",
     *  		"comments": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$contact = Contact::find($id);

  		if ($contact == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $contact->update($data);

        if ($contact)
        {
        	return $this->response->item($contact, new ContactTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("contacts/{id}")
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
  		$contact = Contact::find($id);

        if ($contact == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $contact->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("contacts/datatables")
	 */
  	public function datatables(Request $request)
  	{


  		$query = DB::table('contacts')
                    ->select(
                    	'contacts.id',
                    	'contacts.company_id',
                    	'contacts.project_id',
                    	'contacts.name',
                    	'contacts.company',
                    	'contacts.department',
                    	'contacts.country_id',
                    	'contacts.city_id',
                    	'contacts.industry_id',
                    	'contacts.email',
                    	'contacts.phone',
                    	'contacts.comments',
                    	'projects.name AS project_name',
                    	'countries.name AS country_name',
                    	'cities.name AS city_name',
                    	'industries.name AS industry_name',
			'contacts.user_id'
                    );
        $query->leftJoin('projects', 'projects.id', '=', 'contacts.project_id');
        $query->leftJoin('countries', 'countries.id', '=', 'contacts.country_id');
        $query->leftJoin('cities', 'cities.id', '=', 'contacts.city_id');
        $query->leftJoin('industries', 'industries.id', '=', 'contacts.industry_id');

        if ($request->has('company_id'))
  		{
  			$query->where('contacts.company_id', $request->company_id);
		if ($request->has('user_id'))
  		{
  			$query->orwhere('contacts.user_id', $request->user_id);
  		}

  		}
		
        if ($request->has('project_id') && $request->project_id!='null')
  		{

  		$query->where('contacts.project_id', $request->project_id);
		if ($request->has('user_id'))
  		{
  			$query->where('contacts.user_id', $request->user_id);
  		}
$query->orwherenull('project_id');
  		}
 		else
  		{
  		$query->wherenull('project_id');
		if ($request->has('user_id'))
  		{
  			$query->where('contacts.user_id', $request->user_id);
  		}

  		}

		


		$contacts = $query->get();

  		return Datatables::of($contacts)->make(true);
  	}

}

?>
