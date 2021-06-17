<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\TaskService;
use Transformers\TaskServiceTransformer;

/**
 * Modulo de TaskService
 *
 * @Resource("Group TaskService")
 */
class TaskServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("task_services{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = TaskService::with('task');

  		if ($request->has('task_id'))
  		{
  			$query->where('task_id', $request->task_id);
  		}

  		$taskServices = $query->get();

  		return $this->response->collection($taskServices, new TaskServiceTransformer);
  	}

    public function index_export(Request $request)
    {
      $query = DB::table('task_services')
                    ->select(
                     $request->has('project_id')? 'tasks.index' :
                      'task_services.detail',
                      'task_services.detail',
                        'task_services.cost',
                        'task_services.amount',
                        'task_services.quantity',
                        'task_services.reimbursable',
                        'currencies.name as currency_name',
                     DB::raw('"Service" as `Type`')
                      );


        if ($request->has('task_id'))
      {
        $query->where('task_services.task_id', $request->task_id);
      }
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_services.currency_id');

      if ($request->has('project_id'))
      {
        $query->join('tasks', 'tasks.id', '=', 'task_services.task_id');
        $query->where('tasks.project_id', $request->project_id);
      }

    $taskServices = $query->get();
    return response()->json(array('data' => $taskServices));

    }

  	/**
	 * Crear
	 *
	 * @Post("task_services")
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
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

        $taskService = TaskService::create($data);

        if ($taskService)
        {
        	return $this->response->item($taskService, new TaskServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("task_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$taskService = TaskService::findOrFail($id);

  		return $this->response->item($taskService, new TaskServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("task_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$taskService = TaskService::find($id);

  		if ($taskService == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $taskService->update($data);

        if ($taskService)
        {
        	return $this->response->item($taskService, new TaskServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("task_services/{id}")
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
  		$taskService = TaskService::find($id);

        if ($taskService == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $taskService->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("task_services/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('task_services')
                    ->select(
                    	'task_services.id',
                    	'task_services.task_id',
                        'task_services.cost',
                        'task_services.amount',
                        'task_services.quantity',
                        'task_services.reimbursable',
                        'currencies.name as currency_name',
                    	'task_services.detail');

        if ($request->has('task_id'))
  		{
  			$query->where('task_services.task_id', $request->task_id);
  		}
        $query->leftJoin('currencies', 'currencies.id', '=', 'task_services.currency_id');

  		if ($request->has('project_id'))
  		{
  			$query->join('tasks', 'tasks.id', '=', 'task_services.task_id');
  			$query->where('tasks.project_id', $request->project_id);
  		}

		$taskServices = $query->get();

  		return Datatables::of($taskServices)->make(true);
  	}

}

?>