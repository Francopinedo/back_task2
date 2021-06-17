<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectExpense;
use App\Models\ProjectMaterial;
use App\Models\ProjectResource;
use App\Models\ProjectService;
use App\Models\TeamUser;
use DB;
use Illuminate\Http\Request;
use Transformers\ProjectTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de projectos
 *
 * @Resource("Group Projects")
 */
class ProjectController extends Controller
{

    /**
     * Obtener
     *
     * @Get("projects{?customer_id,company_id,include}")
     * @Parameters({
     *      @Parameter("include", type="integer", required=true, description="Tablas relacionadas", default=null),
     *      @Parameter("customer_id", type="integer", required=true, description="ID de customer", default=null),
     *      @Parameter("company_id", type="integer", required=true, description="ID de company", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "engagement": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int",
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = Project::with('customer', 'department');

        if ($request->has('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }
if ($request->has('project_id')) {
            $query->where('id', $request->project_id);
        }

        if ($request->has('company_id')) {
            $query->whereHas('customer', function ($q1) use ($request) {
                $q1->where('company_id', $request->company_id);
            });
        }
        if ($request->has('user_id')) {
            $query->join('team_users', 'team_users.project_id', '=', 'projects.id');
            $query->where('team_users.user_id', '=', $request->user_id);
        }

        $projects = $query->get(['projects.*']);

        return $this->response->collection($projects, new ProjectTransformer);
    }

    /**
     * Crear
     *
     * @Post("projects")
     * @Request({
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "engagement": "string",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "engagement": "string",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int"
     *    })
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('name') || !$request->has('customer_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();


        $data['holy_days'] = json_encode($data['holy_days']);
 $data['name_convention'] = json_encode($data['name_convention']);
        $project = Project::create($data);

        if ($project) {
            return $this->response->item($project, new ProjectTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener
     *
     * @Get("projects/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "engagement": "string",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);

        return $this->response->item($project, new ProjectTransformer);
    }

    /**
     * Obtener
     *
     * @Get("projects/{id}/countRows")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "rows": "int"
     *    })
     * })
     */
    public function countRows($id)
    {
        $projectResources = ProjectResource::where('project_id', $id)->count();
        $projectServices = ProjectService::where('project_id', $id)->count();
        $projectMaterials = ProjectMaterial::where('project_id', $id)->count();
        $projectExpenses = ProjectExpense::where('project_id', $id)->count();

        $count = $projectResources + $projectServices + $projectMaterials + $projectExpenses;

        return ['data' => ['rows' => $count]];
    }

    /**
     * Editar
     *
     * @Patch("projects/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "engagement": "string",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *        "sow_number": "string",
     *        "identificator": "string",
     *        "start": "date",
     *        "finish": "date",
     *        "engagement": "string",
     *        "estimated_revenue": "float",
     *        "estimated_cost": "float",
     *        "estimated_margin": "float",
     *        "target_margin": "float",
     *        "customer_id": "int",
     *        "status": "string",
     *        "financial_deviation_threshold": "int",
     *        "time_deviation_threshold": "int",
     *        "department_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $project = Project::find($id);

        if ($project == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();
        $data['holy_days'] = json_encode($data['holy_days']);
        $data['name_convention'] = json_encode($data['name_convention']);
        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $project->update($data);

        if ($project) {

            DB::table('working_hours')->where('project_id', $id)->delete();



            $teamusers = TeamUser::where('project_id', '=', $id)->get();



            foreach ($teamusers as $teamuser) {

                $dateto = new \DateTime($teamuser->date_to);

                $period = new \DatePeriod(
                    new \DateTime($teamuser->date_from),
                    new \DateInterval('P1D'),
                    $dateto->add(new \DateInterval('P1D'))
                );

                foreach ($period as $key => $value) {
                    $dow = $value->format('w');
                    if (!in_array($dow, json_decode($project->holy_days))) {
                        $workinghour = array('project_id' => $id,
                            'user_id' => $teamuser->user_id, 'date' => $value->format('Y-m-d'), 'hours' => $teamuser->hours);
                        $request = new \Illuminate\Http\Request($workinghour);
                        app('App\Http\Controllers\WorkingHourController')->store($request);
                    }
                }
            }


            return $this->response->item($project, new ProjectTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("projects/{id}")
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
        $project = Project::find($id);

        if ($project == NULL) {
            return $this->response->error('No existe', 450);
        }

        $project->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("projects/datatables{?customer_id,company_id}")
     * @Parameters({
     *      @Parameter("customer_id", type="integer", required=true, description="ID de customer", default=null),
     *      @Parameter("company_id", type="integer", required=true, description="ID de company", default=null),
     * })
     */
    public function datatables(Request $request)
    {
        $query = DB::table('projects')
            ->select(
                'projects.id', 'projects.name', 'projects.sow_number', 'projects.identificator', 'projects.start', 'projects.finish',
                'projects.engagement',
                'projects.estimated_revenue', 'projects.estimated_cost', 'projects.estimated_margin', 'projects.target_margin',
                'projects.customer_id', 'projects.status', 'projects.financial_deviation_threshold', 'projects.time_deviation_threshold',
                'projects.department_id', 'customers.name AS customer_name', 'departments.title AS department_title')
            ->join('customers', 'customers.id', '=', 'projects.customer_id')
            ->leftJoin('departments', 'departments.id', '=', 'projects.department_id');

        if ($request->has('customer_id')) {
            $query->where('projects.customer_id', $request->customer_id);
        }
        if ($request->has('company_id')) {
            $query->where('customers.company_id', $request->company_id);
        }

        $projects = $query->get();

        return Datatables::of($projects)->make(true);
    }

}

?>
