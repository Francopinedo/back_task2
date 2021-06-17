<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\WhatIf;
use App\Models\Task;
use App\Models\TaskMaterial;
use App\Models\TaskExpense;
use App\Models\TaskResource;
use App\Models\TaskService;

use App\Models\WhatIfTask;
use App\Models\WhatIfTaskMaterial;
use App\Models\WhatIfTaskExpense;
use App\Models\WhatIfTaskResource;
use App\Models\WhatIfTaskService;


use Transformers\TaskTransformer;
use Transformers\TaskExpenseTransformer;
use Transformers\TaskResourceTransformer;
use Transformers\TaskMaterialTransformer;
use Transformers\TaskServiceTransformer;

use Transformers\WhatIfTaskTransformer;
use Transformers\WhatIfTaskExpenseTransformer;
use Transformers\WhatIfResourceTransformer;
use Transformers\WhatIfMaterialTransformer;
use Transformers\WhatIfServiceTransformer;
use Transformers\WhatIfTransformer;
/**
 * Modulo de WhatIf
 *
 * @Resource("Group WhatIf")
 */
class WhatIfController extends Controller  {

  	/**
	 * Obtener
	 *
	 * @Get("WhatIfs{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = WhatIf::with('user');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$WhatIfs = $query->get();

  		return $this->response->collection($WhatIfs, new WhatIfTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("WhatIfs")
	 * @Request({
     *  		"project_id": "int",
     *  		"comment": "string",
      *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
      *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('project_id') || !$request->has('user_id') )
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();


        $WhatIf = WhatIf::create($data);


        $tasks = Task::with('TaskResource','TaskMaterial','TaskExpense','TaskService')->get();
      // $tasks =  Task::all();
          foreach ($tasks->toArray() as $task) {

              $task['whatif_id']=$WhatIf->id;
              unset($task['id']);
               unset($task['created_at']);
               unset($task['updated_at']);

         //   $task->whatif_id=$WhatIf->id;

            //var_dump($task);
            $WhatIfTasks=WhatIfTask::create($task);

           if(!empty($task['task_resource']))
            {
              foreach ($task['task_resource'] as $TaskResource) {
                $TaskResource['whatif_task_id']=$WhatIf->id;
               unset($TaskResource['id']);
               unset($TaskResource['created_at']);
               unset($TaskResource['updated_at']);

                $WhatIfTaskResource=WhatIfTaskResource::create($TaskResource); 

              }
            }

            if(!empty($task['task_material']))
            {
              foreach ($task['task_material'] as $TaskMaterial) {
                $TaskMaterial['whatif_task_id']=$WhatIf->id;
                unset($TaskMaterial['id']);
               unset($TaskMaterial['created_at']);
               unset($TaskMaterial['updated_at']);

                $WhatIfTaskMaterial=WhatIfTaskMaterial::create($TaskMaterial); 

              }
            }

             if(!empty($task['task_expense']))
            {
              foreach ($task['task_expense'] as $TaskExpense) {
                $TaskExpense['whatif_task_id']=$WhatIf->id;
                  unset($TaskExpense['id']);
               unset($TaskExpense['created_at']);
               unset($TaskExpense['updated_at']);

                $WhatIfTaskExpense=WhatIfTaskExpense::create($TaskExpense); 

              }
            }

            if(!empty($task['task_service']))
            {
              foreach ($task['task_service'] as $TaskService) {
                $TaskService['whatif_task_id']=$WhatIf->id;
                  unset($TaskService['id']);
               unset($TaskService['created_at']);
               unset($TaskService['updated_at']);

                $WhatIfTaskService=WhatIfTaskService::create( $TaskService); 

              }
            }

          }


        if ($WhatIf)
        {
        	return $this->response->item($WhatIf, new WhatIfTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("WhatIfs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"WhatIf_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$WhatIf = WhatIf::findOrFail($id);

  		return $this->response->item($WhatIf, new WhatIfTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("WhatIfs/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"WhatIf_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"WhatIf_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$WhatIf = WhatIf::find($id);

  		if ($WhatIf == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $WhatIf->update($data);

        if ($WhatIf)
        {
        	return $this->response->item($WhatIf, new WhatIfTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("WhatIfs/{id}")
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
  		$WhatIf = WhatIf::find($id);
      $WhatIfTasks = WhatIfTask::where('whatif_id',$id)->first();


        if ($WhatIf == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        WhatIfTaskExpense::where('whatif_task_id',$WhatIfTasks->id)->delete();
        WhatIfTaskService::where('whatif_task_id',$WhatIfTasks->id)->delete();
        WhatIfTaskMaterial::where('whatif_task_id',$WhatIfTasks->id)->delete();
        WhatIfTaskResource::where('whatif_task_id',$WhatIfTasks->id)->delete();
        WhatIfTask::where('whatif_id',$id)->delete();
        $WhatIf->delete();

        return $this->response->noContent();
  	}


  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("WhatIfs/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('whatif')
                    ->select(
                    	'whatif.id',
                    	'whatif.comment',
                    	'users.name AS user_name',
                      'whatif.created_at AS created_at')
                    ->join('users', 'users.id', '=', 'whatif.user_id');

        if ($request->has('project_id'))
  		{
  			$query->where('whatif.project_id', $request->project_id);
  		}

		$WhatIfs = $query->get();

  		return Datatables::of($WhatIfs)->make(true);
  	}

}

?>