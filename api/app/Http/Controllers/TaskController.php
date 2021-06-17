<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskMaterial;
use App\Models\TaskResource;
use App\Models\TaskService;
use DB;
use Illuminate\Http\Request;
use Log;
use Transformers\TaskTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Task
 *
 * @Resource("Group Task")
 */
class TaskController extends Controller
{

    /**
     * Obtener
     *
     * @Get("tasks{?include}")
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
        $query = Task::select('tasks.*')->orderBY('index');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

         if ($request->has('index')) {
            $query->where('index', $request->index);
        }
          if ($request->has('description')) {
            $query->whereRaw('lower(`description`) LIKE ?', $request->description);
        }
         if ($request->has('level')) {
            $query->where('level', $request->level);
        }

        $tasks = $query->get();


        /*$finalarray= array();
        foreach ($tasks as $task){
          $start = strtotime($task->start_date);
          $end = strtotime($task->due_date);

            $finaltask = [
              'id'               => $task->id,
              'project_id'       => $task->project_id,
              'name'             => $task->description,
              'start_date'       => $task->start_date,
              'due_date'         =>$task->due_date,
              'start'            => $start * 1000,
              'end'              => $end * 1000,
              'duration'         => $task->duration,
              'requirement_id'   => $task->requirement_id,
              'startIsMilestone' => $task->start_is_milestone,
              'endIsMilestone'   => $task->end_is_milestone,
              'progress'         => $task->progress,
              'depends'          => $task->depends,
              'priority'         => $task->priority,
              'estimated_hours'  => $task->estimated_hours,
              'burned_hours'     => $task->burned_hours,
              'business_value'   => $task->business_value,
              'phase'            => $task->phase,
              'version'          => $task->version,
              'release'          => $task->release,
              'label'            => $task->label,
              'comments'         => $task->comments,
              'attachment'       => $task->attachment,
              'level'            => $task->level,
              'status'           => $task->status,
              'index'           => $task->index,
          ];
            array_push($finalarray, $finaltask);

      }*/
        return response()->json(array('data' => $tasks));
        //return $this->response->collection($tasks, new TaskTransformer);
    }


        public function index_export(Request $request)
    {
        $query = DB::table('tasks')
                    ->select(
                        'tasks.index',
                        'tasks.description',
                        'tasks.level',
                        'tasks.start_date as start_date',
                        'tasks.due_date as due_date',
                        'tasks.start_is_milestone as start_is_milestone',
                        'tasks.end_is_milestone as end_is_milestone',
                        'tasks.progress',
                        'tasks.depends',
                        'tasks.priority',
                        'tasks.estimated_hours as estimated_hours',
                        'tasks.burned_hours as burned_hours',
                        'tasks.business_value as business_value',
                        'tasks.phase',
                        'tasks.version',
                        'tasks.release',
                        'tasks.label',
                        'tasks.comments',
                        'tasks.duration',
                        'tasks.status',
                        'projects.name AS project_name'
                    )->orderBY('tasks.index');
        $query->leftJoin('projects', 'projects.id', '=', 'tasks.project_id');


        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $tasks = $query->get();


            return response()->json(array('data' => $tasks));
        //return $this->response->collection($tasks, new TaskTransformer);
    }


    /**
     * Crear compania
     *
     * @Post("tasks")
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

        if (!$request->has('requirement_id')) {
        $data['requirement_id'] = NULL;
       
            }
        if (empty($request->phase)) {
            $data['phase'] = 'default';
        }

        $task = Task::create($data);

        if ($task) {
            return $this->response->item($task, new TaskTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }


    public function storeAll(Request $request)
    {
            try {
			  foreach ($request->tasks as $data) {
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
							Task::create($data);
						  }else{
                        
                              Task::where('id',$data['id'])->update($data);                   
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
     * @Get("tasks/{id}{?include}")
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
        $task = Task::findOrFail($id);

        return $this->response->item($task, new TaskTransformer);
    }

    /**
     * Editar compania
     *
     * @Patch("tasks/{id}")
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
        $task = Task::find($id);
		

        if ($task == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();
        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }
 if (!$request->has('requirement_id')) {
        $data['requirement_id'] = NULL;
       
    }

        $task->update($data);

        if ($task) {
            return $this->response->item($task, new TaskTransformer);
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
//			return $request->tasks;
        foreach ($request->tasks as $data) {

            $task = Task::find($data['id']);

            if ($task == NULL) {

            } else {

                if (empty($data['requirement_id'])) {
                    $data['requirement_id'] = NULL;
                }
                //calculo de bourned hours
				unset($data['_token']);
                $task->update($data);

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
     * @Delete("tasks/{id}")
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
        $task = Task::find($id);

        if ($task == NULL) {
            return $this->response->error('No existe', 450);
        }

        $task->delete();

        return $this->response->noContent();
    }


    public function destroyAll(Request $request)
    {

        foreach ($request->tasks as $taskid) {
            try {

                $task = Task::find($taskid);
                TaskResource::where('task_id', '=', $taskid)->delete();
                TaskService::where('task_id', '=', $taskid)->delete();
                TaskMaterial::where('task_id', '=', $taskid)->delete();

                if ($task != NULL) {
                    $task->delete();
                }


            } catch (\Exception $exception) {

            }

        }
        return $this->response->noContent();
    }


    /**
     * Phases
     *
     * @Get("tasks/phases")
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function phases(Request $request)
    {
        $query = Task::select('phase')->distinct();

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $phases = $query->get();

        return ['data' => $phases];
    }

    public function datatables(Request $request)
    {
        // dd(json_encode($request->company_id));
        $query = DB::table('tasks')
                    ->select(
                        'tasks.id',
                        'tasks.project_id',
                        'tasks.requirement_id',
                        'tasks.description',
                        'tasks.start_date',
                        'tasks.due_date',
                        'tasks.start_is_milestone',
                        'tasks.end_is_milestone',
                        'tasks.progress',
                        'tasks.depends',
                        'tasks.priority',
                        'tasks.estimated_hours',
                        'tasks.burned_hours',
                        'tasks.business_value',
                        'tasks.phase',
                        'tasks.version',
                        'tasks.release',
                        'tasks.label',
                        'tasks.comments',
                        'tasks.attachment',
                        'tasks.level',
                        'tasks.duration',
                        'tasks.index',
                        'tasks.status',
                        'projects.name AS project_name'
                    );
        $query->leftJoin('projects', 'projects.id', '=', 'tasks.project_id');

        $tasks = $query->get();

        return Datatables::of($tasks)->make(true);
    }

}

?>
