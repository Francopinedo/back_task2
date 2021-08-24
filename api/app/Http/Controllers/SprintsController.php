<?php

namespace App\Http\Controllers;


use DB;
use Log;
use App\Models\Sprints;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Transformers\SprintsTransformer;

/**
 * Modulo de Sprints
 *
 * @Resource("Group Sprints")
 */
class SprintsController extends Controller
{

    /**
     * Obtener
     *
     * @Get("Sprints{?include}")
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
        $query = Sprints::select('sprints.*');
 	
	if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

       
        $Sprints = $query->get();


        /*$finalarray= array();
        foreach ($Sprints as $Sprints){
          $start = strtotime($Sprints->start_date);
          $end = strtotime($Sprints->due_date);

            $finalSprints = [
              'id'               => $Sprints->id,
              'project_id'       => $Sprints->project_id,
              'name'             => $Sprints->description,
              'start_date'       => $Sprints->start_date,
              'due_date'         =>$Sprints->due_date,
              'start'            => $start * 1000,
              'end'              => $end * 1000,
              'duration'         => $Sprints->duration,
              'requirement_id'   => $Sprints->requirement_id,
              'startIsMilestone' => $Sprints->start_is_milestone,
              'endIsMilestone'   => $Sprints->end_is_milestone,
              'progress'         => $Sprints->progress,
              'depends'          => $Sprints->depends,
              'priority'         => $Sprints->priority,
              'estimated_hours'  => $Sprints->estimated_hours,
              'burned_hours'     => $Sprints->burned_hours,
              'business_value'   => $Sprints->business_value,
              'phase'            => $Sprints->phase,
              'version'          => $Sprints->version,
              'release'          => $Sprints->release,
              'label'            => $Sprints->label,
              'comments'         => $Sprints->comments,
              'attachment'       => $Sprints->attachment,
              'level'            => $Sprints->level,
              'status'           => $Sprints->status,
              'index'           => $Sprints->index,
          ];
            array_push($finalarray, $finalSprints);

      }*/
        return response()->json(array('data' => $Sprints));
        //return $this->response->collection($Sprints, new SprintsTransformer);
    }

    /**
     * Crear compania
     *
     * @Post("Sprints")
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
        

        $data = $request->all();

      
        $Sprints = Sprints::create($data);

        if ($Sprints) {
            return $this->response->item($Sprints, new SprintsTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }


    public function storeAll(Request $request)
    {
        foreach ($request->Sprints as $data) {

            try {

              
                    
                    //calculo de bourned hours

                    Sprints::create($data);
                


            } catch (\Exception $exception) {

            }

        }

        return $this->response->noContent();
    }

    /**
     * Obtener compania
     *
     * @Get("sprints/{id}{?include}")
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
        $Sprints = Sprints::findOrFail($id);

        return $this->response->item($Sprints, new SprintsTransformer);
    }

    /**
     * Editar compania
     *
     * @Patch("Sprints/{id}")
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
        $Sprints = Sprints::find($id);


        if ($Sprints == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

       
        $Sprints->update($data);

        if ($Sprints) {
            return $this->response->item($Sprints, new SprintsTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    public function updateAll(Request $request)
    {
        foreach ($request->Sprints as $data) {

            $Sprints = Sprints::find($data['id']);

            if ($Sprints == NULL) {

            } else {

               
                //calculo de bourned hours

                $Sprints->update($data);

            }
        }

        return $this->response->noContent();
    }

    /**
     * Sprint
     *
     * @Get("sprints/sprint")
     * @Transaction({
     *      @Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function sprint(Request $request)
    {
        $query = Sprints::select('short_name', 'id');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $sprints = $query->get();

        return ['data' => $sprints];   
    }

    /**
     * Elimina una compania
     *
     * @Delete("Sprints/{id}")
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
        $Sprints = Sprints::find($id);

        if ($Sprints == NULL) {
            return $this->response->error('No existe', 450);
        }

        $Sprints->delete();

        return $this->response->noContent();
    }


    public function destroyAll(Request $request)
    {

        foreach ($request->Sprints as $Sprintsid) {
            try {

                $Sprints = Sprints::find($Sprintsid);
             

                if ($Sprints != NULL) {
                    $Sprints->delete();
                }


            } catch (\Exception $exception) {

            }

        }
        return $this->response->noContent();
    }


    public function datatables(Request $request)
    {
        // dd(json_encode($request->company_id));
        $query = DB::table('sprints')
                    ->select(
                        'sprints.id',
                        'sprints.customer_id',
                        'sprints.project_id',
                        'sprints.short_name',
                        'sprints.long_name',
                        'sprints.start_date',
                        'sprints.finish_date',
                        'sprints.Duration',
                        'sprints.version',
                        'sprints.release',
                        'sprints.milestone',
                        'sprints.NumberOfChangesRequired',
                        'sprints.NumberOfChangesResolved',
                        'sprints.time_status',
                        'sprints.task_status',
                        'sprints.active',
                        'customers.name AS customer_name',
                        'projects.name AS project_name'
                    );
        $query->leftJoin('projects', 'projects.id', '=', 'sprints.project_id');
	$query->leftJoin('customers', 'customers.id', '=', 'sprints.customer_id');

 	if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $Sprints = $query->get();

        return Datatables::of($Sprints)->make(true);
    }

}

?>
