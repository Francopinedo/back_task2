<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\WhatIfTaskMaterial;
use Transformers\WhatIfTaskMaterialTransformer;

/**
 * Modulo de WhatIfTaskMaterial
 *
 * @Resource("Group WhatIfTaskMaterial")
 */
class WhatIfTaskMaterialController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("whatif_task_materials{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = WhatIfTaskMaterial;

  		if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_id', $request->whatif_task_id);
  		}

  		$WhatIfTaskMaterials = $query->get();

  		return $this->response->collection($WhatIfTaskMaterials, new WhatIfTaskMaterialTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("whatif_task_materials")
	 * @Request({
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('whatif_task_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $WhatIfTaskMaterial = WhatIfTaskMaterial::create($data);

        if ($WhatIfTaskMaterial)
        {
        	return $this->response->item($WhatIfTaskMaterial, new WhatIfTaskMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("whatif_task_materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$WhatIfTaskMaterial = WhatIfTaskMaterial::findOrFail($id);

  		return $this->response->item($WhatIfTaskMaterial, new WhatIfTaskMaterialTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("whatif_task_materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$WhatIfTaskMaterial = WhatIfTaskMaterial::find($id);

  		if ($WhatIfTaskMaterial == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $WhatIfTaskMaterial->update($data);

        if ($WhatIfTaskMaterial)
        {
        	return $this->response->item($WhatIfTaskMaterial, new WhatIfTaskMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("whatif_task_materials/{id}")
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
  		$WhatIfTaskMaterial = WhatIfTaskMaterial::find($id);

        if ($WhatIfTaskMaterial == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $WhatIfTaskMaterial->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("whatif_task_materials/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('whatif_task_materials')
                    ->select(
                    	'whatif_task_materials.id',
                    	'whatif_task_materials.detail',
                    	'whatif_task_materials.cost',
                    	'whatif_task_materials.amount',
                    	'whatif_task_materials.quantity',
                    	'whatif_task_materials.reimbursable',
                    	'currencies.name as currency_name',
                    	'whatif_task_materials.whatif_task_id');

        if ($request->has('whatif_task_id'))
  		{
  			$query->where('whatif_task_materials.whatif_task_id', $request->whatif_task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'whatif_task_materials.currency_id');
  		if ($request->has('project_id'))
  		{
  			$query->join('whatif_task_services', 'whatif_task_services.id', '=', 'whatif_task_materials.whatif_task_id');
  			$query->where('whatif_task_services.project_id', $request->project_id);
  		}

		$WhatIfTaskMaterials = $query->get();

  		return Datatables::of($WhatIfTaskMaterials)->make(true);
  	}

}

?>