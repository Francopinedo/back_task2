<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Workgroup;
use Transformers\WorkgroupTransformer;

/**
 * Modulo de Workgroup
 *
 * @Resource("Group Workgroup")
 */
class WorkgroupController extends Controller {

  	/**
	 * Obtener workgroups
	 *
	 * @Get("workgroups{?company_id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID de una compañia", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Workgroup::select('workgroups.id', 'workgroups.title', 'workgroups.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('workgroups.company_id', $request->company_id);
  		}
        if ($request->has('title'))
        {
            $query->where('workgroups.title', $request->title);
        }

  		$workgroups = $query->get();

  		return $this->response->collection($workgroups, new WorkgroupTransformer);
  	}

  	/**
	 * Crear template de industria
	 *
	 * @Post("workgroups")
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $workgroup = Workgroup::create($data);

        if ($workgroup)
        {
        	return $this->response->item($workgroup, new WorkgroupTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener template de workgroup
	 *
	 * @Get("workgroups/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$workgroup = Workgroup::findOrFail($id);

  		return $this->response->item($workgroup, new WorkgroupTransformer);
  	}

  	/**
	 * Editar template de workgroup
	 *
	 * @Patch("workgroups/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$workgroup = Workgroup::find($id);

  		if ($workgroup == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $workgroup->update($data);

        if ($workgroup)
        {
        	return $this->response->item($workgroup, new WorkgroupTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template de workgroup
     *
     * @Delete("workgroups/{id}")
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
  		$workgroup = Workgroup::find($id);

        if ($workgroup == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $workgroup->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener workgroups
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("workgroups/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = Workgroup::select('workgroups.id', 'workgroups.title', 'workgroups.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('workgroups.company_id', $request->company_id);
  		}

  		$workgroups = $query->get();

  		return Datatables::of($workgroups)->make(true);
  	}

}

?>