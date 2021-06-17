<?php

namespace App\Http\Controllers;

use App\Models\WhatIfTask;
use App\Models\WhatIfTaskMaterial;
use App\Models\WhatIfTaskResource;
use App\Models\WhatIfTaskService;
use DB;
use Illuminate\Http\Request;
use Log;
use Transformers\WhatIfTaskTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de WhatIfTask
 *
 * @Resource("Group WhatIfTask")
 */
class WhatIfTaskController extends Controller
{

    /**
     * Obtener
     *
     * @Get("WhatIfTasks{?include}")
     * @Parameters({
     *      @Parameter("include", description="Tablas relacionadas", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = WhatIfTask::select('whatif_tasks.*')->orderBY('index');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }
         if ($request->has('whatif_id')) {
            $query->where('whatif_id', $request->whatif_id);
        }

        $WhatIfTasks = $query->get();


        /*$finalarray= array();
        foreach ($WhatIfTasks as $WhatIfTask){
          $start = strtotime($WhatIfTask->start_date);
          $end = strtotime($WhatIfTask->due_date);

            $finalWhatIfTask = [
              'id'               => $WhatIfTask->id,
              'project_id'       => $WhatIfTask->project_id,
              'name'             => $WhatIfTask->description,
              'start_date'       => $WhatIfTask->start_date,
              'due_date'         =>$WhatIfTask->due_date,
              'start'            => $start * 1000,
              'end'              => $end * 1000,
              'duration'         => $WhatIfTask->duration,
              'requirement_id'   => $WhatIfTask->requirement_id,
              'startIsMilestone' => $WhatIfTask->start_is_milestone,
              'endIsMilestone'   => $WhatIfTask->end_is_milestone,
              'progress'         => $WhatIfTask->progress,
              'depends'          => $WhatIfTask->depends,
              'priority'         => $WhatIfTask->priority,
              'estimated_hours'  => $WhatIfTask->estimated_hours,
              'burned_hours'     => $WhatIfTask->burned_hours,
              'business_value'   => $WhatIfTask->business_value,
              'phase'            => $WhatIfTask->phase,
              'version'          => $WhatIfTask->version,
              'release'          => $WhatIfTask->release,
              'label'            => $WhatIfTask->label,
              'comments'         => $WhatIfTask->comments,
              'attachment'       => $WhatIfTask->attachment,
              'level'            => $WhatIfTask->level,
              'status'           => $WhatIfTask->status,
              'index'           => $WhatIfTask->index,
          ];
            array_push($finalarray, $finalWhatIfTask);

      }*/
        return response()->json(array('data' => $WhatIfTasks));
        //return $this->response->collection($WhatIfTasks, new WhatIfTaskTransformer);
    }

    /**
     * Crear compania
     *
     * @Post("WhatIfTasks")
     * @Request({
     *        "description": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('description') || !$request->has('phase')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        if (isset($request->requirement_id) && empty($request->requirement_id)) {
            $data['requirement_id'] = NULL;
        }
        if (empty($request->phase)) {
            $data['phase'] = 'default';
        }

        $WhatIfTask = WhatIfTask::create($data);

        if ($WhatIfTask) {
            return $this->response->item($WhatIfTask, new WhatIfTaskTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }


    public function storeAll(Request $request)
    {
            try {
			  foreach ($request->WhatIfTasks as $data) {
                if (!isset($data['description']) || !isset($data['phase'])) {
				 
                } else {
                    if (isset($data['requirement_id']) && empty($dat['requirement_id'])) {
                        $data['requirement_id'] = NULL;
                    }
                    if (empty($data['phase'])) {
                        $data['phase'] = 'default';
                    }

                    //calculo de bourned hours
						if(empty($data['id']))
						  {
							WhatIfTask::create($data);
						  }else{
                        
                              WhatIfTask::where('id',$data['id'])->update($data);                   
                        }
                }
              }

            } catch (\Exception $exception) {
                return $exception;
            }

        

        return $this->response->noContent();
    }

    /**
     * Obtener compania
     *
     * @Get("WhatIfTasks/{id}{?include}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $WhatIfTask = WhatIfTask::findOrFail($id);

        return $this->response->item($WhatIfTask, new WhatIfTaskTransformer);
    }

    /**
     * Editar compania
     *
     * @Patch("WhatIfTasks/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "description": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
		try{
        $WhatIfTask = WhatIfTask::find($id);
		

        if ($WhatIfTask == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();
        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        if (empty($request->requirement_id)) {
            $data['requirement_id'] = NULL;
        }
        $WhatIfTask->update($data);

        if ($WhatIfTask) {
            return $this->response->item($WhatIfTask, new WhatIfTaskTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
			 } catch (\Exception $exception) {
                return $exception;
            }
    }

    public function updateAll(Request $request)
    {
        try{
//			return $request->WhatIfTasks;
        foreach ($request->tasks as $data) {

            $WhatIfTask = WhatIfTask::find($data['id']);

            if ($WhatIfTask == NULL) {

            } else {

                if (empty($data['requirement_id'])) {
                    $data['requirement_id'] = NULL;
                }
                //calculo de bourned hours
				unset($data['_token']);
                $WhatIfTask->update($data);

            }
        }
        } catch (\Exception $exception) {
                return $exception;
            }

        return $this->response->noContent();
    }

    /**
     * Elimina una compania
     *
     * @Delete("WhatIfTasks/{id}")
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
        $WhatIfTask = WhatIfTask::find($id);

        if ($WhatIfTask == NULL) {
            return $this->response->error('No existe', 450);
        }

        $WhatIfTask->delete();

        return $this->response->noContent();
    }


    public function destroyAll(Request $request)
    {

        foreach ($request->WhatIfTasks as $WhatIfTaskid) {
            try {

                $WhatIfTask = WhatIfTask::find($WhatIfTaskid);
                WhatIfTaskResource::where('whatif_task_id', '=', $WhatIfTaskid)->delete();
                WhatIfTaskService::where('whatif_task_id', '=', $WhatIfTaskid)->delete();
                WhatIfTaskMaterial::where('whatif_task_id', '=', $WhatIfTaskid)->delete();
                WhatIfTaskExpense::where('whatif_task_id', '=', $WhatIfTaskid)->delete();

                if ($WhatIfTask != NULL) {
                    $WhatIfTask->delete();
                }


            } catch (\Exception $exception) {

            }

        }
        return $this->response->noContent();
    }


    /**
     * Phases
     *
     * @Get("WhatIfTasks/phases")
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function phases(Request $request)
    {
        $query = WhatIfTask::select('phase')->distinct();

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $phases = $query->get();

        return ['data' => $phases];
    }

    public function datatables(Request $request)
    {
        // dd(json_encode($request->company_id));
        $query = DB::table('whatif_tasks')
                    ->select(
                        'whatif_tasks.id',
                        'whatif_tasks.project_id',
                        'whatif_tasks.requirement_id',
                        'whatif_tasks.description',
                        'whatif_tasks.start_date',
                        'whatif_tasks.due_date',
                        'whatif_tasks.start_is_milestone',
                        'whatif_tasks.end_is_milestone',
                        'whatif_tasks.progress',
                        'whatif_tasks.depends',
                        'whatif_tasks.priority',
                        'whatif_tasks.estimated_hours',
                        'whatif_tasks.burned_hours',
                        'whatif_tasks.business_value',
                        'whatif_tasks.phase',
                        'whatif_tasks.version',
                        'whatif_tasks.release',
                        'whatif_tasks.label',
                        'whatif_tasks.comments',
                        'whatif_tasks.attachment',
                        'whatif_tasks.level',
                        'whatif_tasks.duration',
                        'whatif_tasks.index',
                        'whatif_tasks.status',
                        'projects.name AS project_name'
                    );
        $query->leftJoin('projects', 'projects.id', '=', 'whatif_tasks.project_id');

        $WhatIfTasks = $query->get();

        return Datatables::of($WhatIfTasks)->make(true);
    }

}

?>
