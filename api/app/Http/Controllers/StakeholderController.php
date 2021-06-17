<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Stakeholder;
use Transformers\StakeholderTransformer;

/**
 * Modulo de Stakeholder
 *
 * @Resource("Group Stakeholder")
 */
class StakeholderController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("stakeholders{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Stakeholder::with('user');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$stakeholders = $query->get();

  		return $this->response->collection($stakeholders, new StakeholderTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("stakeholders")
	 * @Request({
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('contact_id') || !$request->has('influence') ||
  			!$request->has('impacted') || !$request->has('impact') || !$request->has('expectations'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $stakeholder = Stakeholder::create($data);

        if ($stakeholder)
        {
        	return $this->response->item($stakeholder, new StakeholderTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("stakeholders/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$stakeholder = Stakeholder::findOrFail($id);

  		return $this->response->item($stakeholder, new StakeholderTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("stakeholders/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"influence": "string",
     *  		"impacted": "string",
     *  		"impact": "string",
     *  		"expectations": "string",
     *  		"contact_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$stakeholder = Stakeholder::find($id);

  		if ($stakeholder == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $stakeholder->update($data);

        if ($stakeholder)
        {
        	return $this->response->item($stakeholder, new StakeholderTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("stakeholders/{id}")
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
  		$stakeholder = Stakeholder::find($id);

        if ($stakeholder == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $stakeholder->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("stakeholders/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('stakeholders')
                    ->select(
                    	'stakeholders.id',
                    	'stakeholders.influence',
                    	'stakeholders.impacted',
                    	'stakeholders.impact',
                    	'stakeholders.expectations',
                    	'contacts.name AS contact_name'
                    );
        $query->leftJoin('contacts', 'contacts.id', '=', 'stakeholders.contact_id');

        if ($request->has('project_id'))
  		{
  			$query->where('contacts.project_id', $request->project_id);
  		}

        if ($request->has('company_id'))
  		{
  			$query->where('contacts.company_id', $request->company_id);
  		}



		$stakeholders = $query->get();

  		return Datatables::of($stakeholders)->make(true);
  	}

}

?>