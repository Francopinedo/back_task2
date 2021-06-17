<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Seniority;
use Transformers\SeniorityTransformer;

/**
 * Modulo de Seniority
 *
 * @Resource("Group Seniority")
 */
class SeniorityController extends Controller {

  	/**
	 * Obtener seniorities
	 *
	 * @Get("seniorities{?company_id}")
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
  		$query = Seniority::select('seniorities.id', 'seniorities.title', 'seniorities.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('seniorities.company_id', $request->company_id);
  		}

        if ($request->has('title'))
        {
            $query->where('seniorities.title', $request->title);
        }

  		$seniorities = $query->get();

  		return $this->response->collection($seniorities, new SeniorityTransformer);
  	}

  	/**
	 * Crear template de industria
	 *
	 * @Post("seniorities")
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

        $seniority = Seniority::create($data);

        if ($seniority)
        {
        	return $this->response->item($seniority, new SeniorityTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener una seniority
	 *
	 * @Get("seniorities/{id}")
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
  		$seniority = Seniority::findOrFail($id);

  		return $this->response->item($seniority, new SeniorityTransformer);
  	}

  	/**
	 * Editar una seniority
	 *
	 * @Patch("seniorities/{id}")
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
  		$seniority = Seniority::find($id);

  		if ($seniority == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $seniority->update($data);

        if ($seniority)
        {
        	return $this->response->item($seniority, new SeniorityTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una seniority
     *
     * @Delete("seniorities/{id}")
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
  		$seniority = Seniority::find($id);

        if ($seniority == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $seniority->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener seniorities
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("seniorities/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = Seniority::select('seniorities.id', 'seniorities.title', 'seniorities.company_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('seniorities.company_id', $request->company_id);
  		}

  		$seniorities = $query->get();

  		return Datatables::of($seniorities)->make(true);
  	}

}

?>