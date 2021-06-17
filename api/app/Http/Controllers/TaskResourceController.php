<?php

namespace App\Http\Controllers;

use App\Models\TaskResource;
use DB;
use Illuminate\Http\Request;
use Transformers\TaskResourceTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de TaskResource
 *
 * @Resource("Group TaskResource")
 */
class TaskResourceController extends Controller
{

    /**
     * Obtener
     *
     * @Get("task_resources{?company_id}")
     * @Parameters({
     *      @Parameter("company_id", description="ID de la compañia", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = TaskResource::join('users','users.id','=','task_resources.user_id');


        if ($request->has('task_id')) {
            $query->where('task_id', $request->task_id);
        }
         if ($request->has('user_id')) {
            $query->where('users.id', $request->user_id);
        }


        $taskResources = $query->get(['task_resources.*', 'users.id as user_id', 'users.name']);

        return $this->response->collection($taskResources, new TaskResourceTransformer);
    }

     public function index_export(Request $request)
    {
        $query = DB::table('task_resources')
            ->select(
               $request->has('project_id')? 'tasks.index' :
                'task_resources.rate',
                'task_resources.quantity',
                'currencies.name as currency_name',
                'project_roles.title as project_role_title',
                'seniorities.title as seniority_name',
                'users.name AS user_name'
            )
            ->leftJoin('users', 'users.id', '=', 'task_resources.user_id')
            ->leftJoin('project_roles', 'project_roles.id', '=', 'task_resources.project_role_id');

        if ($request->has('task_id')) {
            $query->where('task_resources.task_id', $request->task_id);
        }
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_resources.currency_id');
        $query->leftJoin('seniorities', 'seniorities.id', '=', 'task_resources.seniority_id');

        if ($request->has('project_id')) {
            $query->join('tasks', 'tasks.id', '=', 'task_resources.task_id');
            $query->where('tasks.project_id', $request->project_id);
        }

        $taskResources = $query->get();

       return response()->json(array('data' => $taskResources));
    }


    /**
     * Crear
     *
     * @Post("task_resources")
     * @Request({
     *
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
        if (!$request->has('task_id')
            || !$request->has('user_id')
        ) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $taskResource = TaskResource::create($data);

        if ($taskResource) {
            return $this->response->item($taskResource, new TaskResourceTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("task_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $taskResource = TaskResource::findOrFail($id);

        return $this->response->item($taskResource, new TaskResourceTransformer);
    }

    /**
     * Editar
     *
     * @Patch("task_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *
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
        $taskResource = TaskResource::find($id);

        if ($taskResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $taskResource->update($data);

        if ($taskResource) {
            return $this->response->item($taskResource, new TaskResourceTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("task_resources/{id}")
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
        $taskResource = TaskResource::find($id);

        if ($taskResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $taskResource->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("task_resources/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('task_resources')
            ->select(
                'task_resources.id',
                'task_resources.task_id',
                'task_resources.user_id',
                'task_resources.rate',
                'task_resources.quantity',
                'task_resources.currency_id',
                'currencies.name as currency_name',
                'project_roles.title as project_role_title',
                'seniorities.title as seniority_name',
                'users.name AS user_name'
            )
            ->leftJoin('users', 'users.id', '=', 'task_resources.user_id')
            ->leftJoin('project_roles', 'project_roles.id', '=', 'task_resources.project_role_id');

        if ($request->has('task_id')) {
            $query->where('task_resources.task_id', $request->task_id);
        }
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_resources.currency_id');
        $query->leftJoin('seniorities', 'seniorities.id', '=', 'task_resources.seniority_id');

        if ($request->has('project_id')) {
            $query->join('tasks', 'tasks.id', '=', 'task_resources.task_id');
            $query->where('tasks.project_id', $request->project_id);
        }

        $taskResources = $query->get();

        return Datatables::of($taskResources)->make(true);
    }

}

?>