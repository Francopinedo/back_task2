<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\TaskMaterial;
use Transformers\TaskMaterialTransformer;

/**
 * Modulo de TaskMaterial
 *
 * @Resource("Group TaskMaterial")
 */
class TaskMaterialController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("task_materials{?company_id}")
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
  		$query = TaskMaterial::with('task');

  		if ($request->has('task_id'))
  		{
  			$query->where('task_id', $request->task_id);
  		}

  		$taskMaterials = $query->get();

  		return $this->response->collection($taskMaterials, new TaskMaterialTransformer);
  	}

public function index_export(Request $request)
    {
      $query = DB::table('task_materials')
                    ->select(
                       $request->has('project_id')? 'tasks.index' :
                      'task_materials.detail',
                        'task_materials.detail',
                      'task_materials.cost',
                      'task_materials.amount',
                      'task_materials.quantity',
                      'task_materials.reimbursable',
                      'currencies.name as currency_name',
                      DB::raw('"Material" as `Type`')
                      );

        if ($request->has('task_id'))
      {
        $query->where('task_materials.task_id', $request->task_id);
      }
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_materials.currency_id');
      if ($request->has('project_id'))
      {
        $query->join('tasks', 'tasks.id', '=', 'task_materials.task_id');
        $query->where('tasks.project_id', $request->project_id);
      }

    $taskMaterials = $query->get();

          return response()->json(array('data' => $taskMaterials));

    }
  	/**
	 * Crear
	 *
	 * @Post("task_materials")
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
  		if (!$request->has('task_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $taskMaterial = TaskMaterial::create($data);

        if ($taskMaterial)
        {
        	return $this->response->item($taskMaterial, new TaskMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("task_materials/{id}")
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
  		$taskMaterial = TaskMaterial::findOrFail($id);

  		return $this->response->item($taskMaterial, new TaskMaterialTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("task_materials/{id}")
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
  		$taskMaterial = TaskMaterial::find($id);

  		if ($taskMaterial == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $taskMaterial->update($data);

        if ($taskMaterial)
        {
        	return $this->response->item($taskMaterial, new TaskMaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("task_materials/{id}")
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
  		$taskMaterial = TaskMaterial::find($id);

        if ($taskMaterial == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $taskMaterial->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("task_materials/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('task_materials')
                    ->select(
                    	'task_materials.id',
                    	'task_materials.detail',
                    	'task_materials.cost',
                    	'task_materials.amount',
                    	'task_materials.quantity',
                    	'task_materials.reimbursable',
                    	'currencies.name as currency_name',
                    	'task_materials.task_id');

        if ($request->has('task_id'))
  		{
  			$query->where('task_materials.task_id', $request->task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_materials.currency_id');
  		if ($request->has('project_id'))
  		{
  			$query->join('tasks', 'tasks.id', '=', 'task_materials.task_id');
  			$query->where('tasks.project_id', $request->project_id);
  		}

		$taskMaterials = $query->get();

  		return Datatables::of($taskMaterials)->make(true);
  	}

}

?>