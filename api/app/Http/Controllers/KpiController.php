<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Models\Contract;
use App\Models\Kpi;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamUser;
use App\Models\Ticket;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\KpiTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Kpis
 *
 * @Resource("Group Kpi")
 */
class KpiController extends Controller
{

    /**
     * Obtener kpis
     *
     * @Get("kpis{?include, company_id}")
     * @Parameters({
     *      @Parameter("include", description="Tablas relacionadas", default=1),
     *      @Parameter("company_id", description="ID de la compañia padre", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     * })
     */
    public function index(Request $request)
    {
        $query = Kpi::query();


        $query->where('company_id', $request->company_id);

        if($request->has('category'))
                    $query->where('category', $request->category);

        if($request->has('showdashboard'))
            $query->where('showdashboard', $request->showdashboard);


        $kpis = $query->get();

        return $this->response->collection($kpis, new KpiTransformer);
    }

    public function indicadores(Request $request)
    {


        $project = Project::find($request->project_id);

        $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.project_id', '=', $project->id)->get(['contracts.*', 'customers.company_id'])->first();

        $tasks = Task::where('project_id', '=', $request->project_id)->orderBy('index', 'asc')->get();
        $task = $tasks[0];
        $start = explode('-', $task->start_date);
        $diff = Carbon::create($start[0], $start[1], $start[2])->diffInDays();
        $result = (($diff * 8) / $task->estimated_hours) * 100;
        if ($result > 100) {
            $result = 100;
        } else if ($result < 0) {
            $result = 0;
        }
        if ($result < $task->progress or ($result == 100 and $task->progress == 100)) {
            $task->color = 'green';
        } else if ($result > $task->progress) {
            $task->color = 'red';
        } else {
            $task->color = 'yellow';
        }
        $task->estimated_progress = $result;


        $currency = Currency::find($contract->currency_id);

        $actual_percent_completed = $task->estimated_progress;
        $project_budget = $project->estimated_cost;

        return response()->json(array('data' => array(
            'currency' => $currency,
            'PCW' => $actual_percent_completed,
            'PB' => $project_budget,
            'AV' => 100,
            'PF' => 1000
        )));
    }

    /**
     * Crear Cost
     *
     * @Post("kpis")
     * @Request({
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public
    function store(Request $request)
    {
        if (!$request->has('category') || !$request->has('company_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();
        if (!isset($data['showkpi'])) {
            $data['showkpi'] = 0;
        } else {
            $data['showkpi'] = 1;
        }
        $kpi = Kpi::create($data);

        if ($kpi) {
            return $this->response->item($kpi, new KpiTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener cost
     *
     * @Get("kpis/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     *    })
     * })
     */
    public
    function show($id)
    {
        $kpi = Kpi::findOrFail($id);

        return $this->response->item($kpi, new KpiTransformer);
    }

    /**
     * Editar cost
     *
     * @Patch("kpis/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "company_id": "int",
     *        "category": "varchar",
     *        "description": "varchar",
     *        "query": "varchar"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public
    function update(Request $request, $id)
    {
        $kpi = Kpi::find($id);

        if ($kpi == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();


        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        if (!isset($data['showkpi'])) {
            $data['showkpi'] = 0;
        } else {
            $data['showkpi'] = 1;
        }
        $kpi->update($data);

        if ($kpi) {
            return $this->response->item($kpi, new KpiTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina una cost
     *
     * @Delete("kpis/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
    public
    function destroy($id)
    {
        $kpi = Kpi::find($id);

        if ($kpi == NULL) {
            return $this->response->error('No existe', 450);
        }

        $kpi->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener kpis
     *
     * Con formato listo para datatables con ajax
     * @Get("kpis/datatables")
     */
    public
    function datatables(Request $request)
    {
        $companyId = ($request->has('company_id')) ? $request->company_id : null;

        $query = DB::table('kpis')
            ->select(
                'kpis.id',
                'kpis.company_id',
                'kpis.category',
                'kpis.graphic_type',
                'kpis_category.name as category_name',
                'kpis.nombre',
                'kpis.kpi',
                'kpis.showkpi',
                'kpis.type_of_result',
                'kpis.description',
                'kpis.query');

        if (!empty($companyId)) {
            $query->where('kpis.company_id', $companyId);
        }

        $kpis = $query->join('kpis_category', 'kpis_category.id', '=', 'kpis.category');
        $kpis = $query->get();

        return Datatables::of($kpis)->make(true);
    }


    public function chartEv(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
                ->where('contracts.project_id', '=', $project->id)->get(['contracts.*', 'customers.company_id'])->first();
            $currency = Currency::find($contract->currency_id);

            $tasks = Task::where('project_id', '=', $request->project_id)->orderBy('index', 'asc')->get();
            $task = $tasks[0];

            $start = explode('-', $task->start_date);
            $diff = Carbon::create($start[0], $start[1], $start[2])->diffInDays();
            $result = (($diff * 8) / $task->estimated_hours) * 100;
            if ($result > 100) {
                $result = 100;
            } else if ($result < 0) {
                $result = 0;
            }

            $task->estimated_progress = $result;
            $actual_percent_completed = $task->estimated_progress;

            /**profit and loss**/
            $team = $this->profit_and_loss_team($dt, $contract, $project, $currency);

            $services = $this->profit_and_loss_services($dt, $contract, $project, $currency);
            $expenses = $this->profit_and_loss_expenses($dt, $contract, $project, $currency);
            $materials = $this->profit_and_loss_materials($dt, $contract, $project, $currency);
            $pv = $team->planned_revenue_nf + $services->planned_revenue_nf + $expenses->planned_revenue_nf + $materials->planned_revenue_nf;
            $ac = $team->real_cost_nf + $services->real_cost_nf + $expenses->real_cost_nf + $materials->real_cost_nf;
            $ev = $team->real_profit_nf + $services->real_profit_nf + $expenses->real_profit_nf + $materials->real_profit_nf;
            /******************/

            ///   $ev= $actual_percent_completed*$pv;


            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        array_push($data, $earned_value);
        //array_push($data, $actual_cost);
        //array_push($data, $planned_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartAc(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();

        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];


            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        //  array_push($data, $earned_value);
        array_push($data, $actual_cost);
        //array_push($data, $planned_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartPv(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];
            /******************/

            ///   $ev= $actual_percent_completed*$pv;


            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        array_push($data, $planned_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    public function chartCpi(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Cost Perfomance Index');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $cpi_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];
            /******************/

            ///   $ev= $actual_percent_completed*$pv;


            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $cpi_data[] = $ac != 0 ? $ev / $ac : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $cpi_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartSpi(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Schedule Perfomance Index');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $cpi_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $cpi_data[] = $pv != 0 ? $ev / $pv : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $cpi_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartEac1(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Estimate at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $eac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $cpi = $pv != 0 ? $ev / $pv : 0;
            $eac_data[] = $cpi != 0 ? $pv / $cpi : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $eac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartEac2(Request $request)
    {


        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Estimate at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $eac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $eac_data[] = $ac + ($pv - $ev);

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $eac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartEac3(Request $request)
    {


        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Estimate at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $eac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $cpi = $ac != 0 ? $ev / $ac : 0;
            $spi = $pv != 0 ? $ev / $pv : 0;
            $multi = $cpi * $spi;


            $eac_data[] = $multi != 0 ? ($ac + ($pv - $ev)) / $multi : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $eac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartEac4(Request $request)
    {


        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cpi_value = array('name' => 'Estimate at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $eac_data = array();
        $Bottom_up_Estimate_to_Complete = 0;
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $eac_data[] = $ac + $Bottom_up_Estimate_to_Complete;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cpi_value['data'] = $eac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cpi_value);

        return response()->json(array('months' => $months, 'data' => $data));
    }


    public function chartVac1(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $vac_value = array('name' => 'Variance at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $vac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $cpi = $pv != 0 ? $ev / $pv : 0;
            $eac = $cpi != 0 ? $pv / $cpi : 0;
            $vac_data = $pv - $eac;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $vac_value['data'] = $vac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $vac_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    public function chartVac2(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $vac_value = array('name' => 'Variance at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $vac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $eac = $ac + ($pv - $ev);
            $vac_data = $pv - $eac;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $vac_value['data'] = $vac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $vac_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    public function chartVac3(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $vac_value = array('name' => 'Variance at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $vac_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $cpi = $ac != 0 ? $ev / $ac : 0;
            $spi = $pv != 0 ? $ev / $pv : 0;
            $multi = $cpi * $spi;


            $eac = $multi != 0 ? ($ac + ($pv - $ev)) / $multi : 0;
            $vac_data = $pv - $eac;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $vac_value['data'] = $vac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $vac_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    public function chartVac4(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $vac_value = array('name' => 'Variance at Completion');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $vac_data = array();
        $Bottom_up_Estimate_to_Complete = 0;
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;


            $eac = $ac + $Bottom_up_Estimate_to_Complete;
            $vac_data = $pv - $eac;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $vac_value['data'] = $vac_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $vac_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    public function chartSv(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $sv_value = array('name' => 'Schedule Variance');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $sv_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $sv_data[] = $ev - $pv;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $sv_value['data'] = $sv_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $sv_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartCv(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $cv_value = array('name' => 'Cost Variance');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $cv_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;
            $cv_data[] = $ev - $ac;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $cv_value['data'] = $cv_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $cv_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartMfn(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $mfn_value = array('name' => 'Minimum Funds Needed');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $mfn_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $cpi = $ac != 0 ? $ev / $ac : 0;
            $mfn_data[] = $cpi != 0 ? $pv / $cpi : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $mfn_value['data'] = $mfn_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $mfn_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartFnsl(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $fnsl_value = array('name' => 'Funds Need with the same level of slippage');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $fnsl_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $cpi = $ac != 0 ? $ev / $ac : 0;
            $spi = $pv != 0 ? $ev / $pv : 0;
            $multi = $cpi * $spi;
            $fnsl_data[] = $multi != 0 ? $pv / $multi : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $fnsl_value['data'] = $fnsl_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $fnsl_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartRoi(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Cost');
        $roi_value = array('name' => 'Return Of Investment ');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $roi_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $roi_data[] = number_format($ac != 0 ? ($ev - $ac) / $ac : 0, 2);

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $roi_value['data'] = $roi_data;
        array_push($data, $earned_value);
        array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $roi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartRrr(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $roi_value = array('name' => 'Return Of Investment ');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $roi_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');


            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);

            $ev = $indicators['ev'];
            $ac = $indicators['ac'];
            $pv = $indicators['pv'];
            $actual_percent_completed = $indicators['actual_percent_completed'];

            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;

            $planed_value_data[] = $pv;

            $roi_data[] = $ac != 0 ? ($ev - $ac) / $ac : 0;

        }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $roi_value['data'] = $roi_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $roi_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    function chartActivities(Request $request)
    {

    }

    function chartReviews(Request $request)
    {

    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

function chartcountBugs(Request $request)
    {


             $where="";
         if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id;
        }

         if ($request->has('begin_date') && $request->has('end_date') ) {
            if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id." AND (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }else{
                $where=" WHERE (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }
            
        }

       

        $query = "SELECT count(tickets.type) AS tickets_numbers,tickets.type

            FROM tickets
                     INNER JOIN  users ON users.id=tickets.owner_id

         INNER JOIN   tasks ON tasks.id=tickets.task_id
          INNER JOIN   projects ON tasks.project_id=projects.id
          INNER JOIN   customers ON projects.customer_id=customers.id
           ".$where." group by tickets.type" ;
            $querytasks = DB::select($query);
        //    return $querytasks;
$type=array();
$data=array();
foreach ($querytasks as $k=>$query) {

       array_push($data, $query->tickets_numbers);
              array_push($type, $query->type);
}

            return response()->json(array('type' => $type,'data' => $data));
 
    }


     function chartCapacity(Request $request)
    {
        $where="";
      if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id;
        }

         if ($request->has('begin_date') && $request->has('end_date') ) {
            if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id." AND (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }else{
                $where=" WHERE (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }
            
        }

        $query = "SELECT count(users.name) AS tickets_numbers, users.name AS owner_name
            FROM tickets
                     INNER JOIN  users ON users.id=tickets.owner_id

         INNER JOIN   tasks ON tasks.id=tickets.task_id
          INNER JOIN   projects ON tasks.project_id=projects.id
          INNER JOIN   customers ON projects.customer_id=customers.id
           ".$where." group by users.id" ;
            $querytasks = DB::select($query);

$type=array();
$data=array();
foreach ($querytasks as $k=>$query) {

       array_push($data, $query->tickets_numbers);
              array_push($type, $query->owner_name);
}

            return response()->json(array('type' => $type,'data' => $data));
           
    
    }

    public function percentPlannedvsRealMilestone(Request $request)
    {
        $where="";
         if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id;
        }

         if ($request->has('begin_date') && $request->has('end_date') ) {
            if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id." AND (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }else{
                $where=" WHERE (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }
            
        }


        $query = "SELECT AVG(if(DATEDIFF(tickets.due_date,tickets.approval_date)>0,0,1)) as diff_date, tasks.phase
            FROM tickets
            
         INNER JOIN   tasks ON tasks.id=tickets.task_id
          INNER JOIN   projects ON tasks.project_id=projects.id
          INNER JOIN   customers ON projects.customer_id=customers.id
        LEFT JOIN  ticket_histories  ON tickets.id=ticket_histories.ticket_id
         LEFT JOIN  users ON users.id=tickets.owner_id
         LEFT JOIN  workgroups ON  workgroups.id=users.workgroup_id
         ".$where."  GROUP By tasks.phase
                  ORDER BY tasks.phase" ;
            $querytasks = DB::select($query);

$type=array();
$data=array();
foreach ($querytasks as $k=>$query) {

       array_push($data, $query->diff_date);
              array_push($type, $query->phase);
}

            return response()->json(array('type' => $type,'data' => $data));

           
    }

     public function percentMissingMilestone(Request $request)
    {
        $where="";
         if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id;
        }

         if ($request->has('begin_date') && $request->has('end_date') ) {
            if ($request->has('project_id') ) {
            $where=" WHERE projects.id =".  $request->project_id." AND (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }else{
                $where=" WHERE (tickets.due_date >".  $request->begin_date ." AND tickets.due_date <=".$request->end_date ;
            }
            
        }


        $query = "SELECT AVG(if(DATEDIFF(tickets.due_date,date)>0,0,1)) as diff_date, tasks.phase

            FROM tickets
            
         INNER JOIN   tasks ON tasks.id=tickets.task_id
          INNER JOIN   projects ON tasks.project_id=projects.id
          INNER JOIN   customers ON projects.customer_id=customers.id
        LEFT JOIN  ticket_histories  ON tickets.id=ticket_histories.ticket_id
         LEFT JOIN  users ON users.id=tickets.owner_id
         LEFT JOIN  workgroups ON  workgroups.id=users.workgroup_id
         ".$where."  GROUP By tasks.phase
                  ORDER BY tasks.phase" ;
            $querytasks = DB::select($query);

 $type=array();
$data=array();
foreach ($querytasks as $k=>$query) {

       array_push($data, $query->diff_date);
              array_push($type, $query->phase);
}

            return response()->json(array('type' => $type,'data' => $data));

 
           
    }

     public function chartDelivernotTime(Request $request)
    {

            

        if ($request->has('project_id') ) {
            $project = Project::find($request->project_id);

            $tasks=Task::where('project_id',$request->project_id)->where('progress',100)->get();

        }else{
             $tasks=Task::where('progress',100)->get();
        }
        $sumtaskDelivernotTime = 0;
//return $tasks;

                foreach ($tasks as $task) {
       
         $tickets=Ticket::where('task_id',$task->id)->where('approval_date','!=','0000-00-00')->get();
            foreach ($tickets as $ticket) {
               // return $ticket;
                if($ticket->approval_date>$ticket->due_date)
                {
                    $sumtaskDelivernotTime++;
                }
            }


        }
        return response()->json(array('data' => $sumtaskDelivernotTime));
 

    }

    public function chartMilestones(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();

        $due_value = array('name' => 'Due milestones');
        $started_value = array('name' => 'Started milestones');

        $due_data = array();
        $started_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            $fecha = $dt->format("Y-m-d");
            $tasks = Task::where('project_id', '=', $request->project_id)->
            orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$fecha' AS DATE) AND CAST('$fecha' AS DATE)")
                ->get();

            $countdues = 0;

            foreach ($tasks as $task) {
                $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));
                $today = new DateTime($dt->modify('last day of this month')->format('Y-m-d'));

                if ($duedate < $today && $task->progress != 100) {
                    $countdues++;
                }
            }

            $due_data[] = $countdues;
            $started_data[] = count($tasks);

        }

        $due_value['data'] = $due_data;
        $started_value['data'] = $started_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $due_value);
        array_push($data, $started_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartOverdueTasks(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();

        $due_value = array('name' => 'Due milestones');
        $started_value = array('name' => 'Started milestones');

        $due_data = array();
        $started_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            $fecha = $dt->format("Y-m-d");
            $tasks = Task::where('project_id', '=', $request->project_id)->
            orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$fecha' AS DATE) AND CAST('$fecha' AS DATE)")
                ->get();

            $countdues = 0;

            foreach ($tasks as $task) {
                $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));
                $today = new DateTime($dt->modify('last day of this month')->format('Y-m-d'));

                if ($duedate < $today && $task->progress != 100) {
                    $countdues++;
                }
            }

            $due_data[] = $countdues;
            $started_data[] = count($tasks);

        }

        $due_value['data'] = $due_data;
        $started_value['data'] = $started_data;
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $due_value);
        array_push($data, $started_value);

        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartTaskCompleted(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();

        $completed_value = array('name' => 'Task Completed');
        $started_value = array('name' => 'Started milestones');


        $completed_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            $fecha = $dt->format("Y-m-d");
            $tasks = Task::where('project_id', '=', $request->project_id)->
            orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$fecha' AS DATE) AND CAST('$fecha' AS DATE)")
                ->where("progress", '=', '100')
                ->get();


            $completed_data[] = count($tasks);

        }

        $completed_value['data'] = $completed_data;

        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $completed_value);


        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartPlannedHours(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();

        $planned_value = array('name' => 'Planned Hours');
        $real_value = array('name' => 'Real Hours');


        $planned_data = array();
        $real_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);
            $planned_data[] = $indicators['total_planned_hours'];
            $real_data[] = $indicators['total_real_hours'];

        }

        $planned_value['data'] = $planned_data;
        $real_value['data'] = $real_data;

        array_push($data, $planned_value);
        array_push($data, $real_value);


        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartCompletedProjects(Request $request)
    {

        $data = array();

        $projects = Project::where('status', '=', 'completed')->get();

        $completed_value['data'] = count($projects);

        array_push($data, $completed_value);


        return response()->json(array('data' => $data));

    }

    public function chartCancelledProjects(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();

        $planned_value = array('name' => 'Planned Hours');
        $real_value = array('name' => 'Real Hours');


        $planned_data = array();
        $real_data = array();
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            $indicators = $this->calculateBasicsIndicators($project, $request, $dt);
            $planned_data[] = $indicators['total_planned_hours'];
            $real_data[] = $indicators['total_real_hours'];

        }

        $planned_value['data'] = $planned_data;
        $real_value['data'] = $real_data;

        array_push($data, $planned_value);
        array_push($data, $real_value);


        return response()->json(array('months' => $months, 'data' => $data));

    }

    public function chartResponseTimes(Request $request)
    {

        $project = Project::find($request->project_id);
        $data = array();
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $planned_data = array();
        $real_data = array();

        $teams = TeamUser::where('project_id', '=', $project->id);
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

            /******************/

            foreach ($teams as $team){
                $value = array('name' => $team->nombre);

                $value['data'] = 12;
                $data[] =$value;
            }

             
           


        }
        array_push($data, $data);

        return response()->json(array('months' => $months, 'data' => $data));

    }


    private function calculateBasicsIndicators($project, $request, $dt)
    {


        $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.project_id', '=', $project->id)->get(['contracts.*', 'customers.company_id'])->first();
        $currency = Currency::find($contract->currency_id);

        $tasks = Task::where('project_id', '=', $request->project_id)->orderBy('index', 'asc')->get();
        $task = $tasks[0]; //TODO: esto en teria esta mal, deberia haber una forma en la tabla project de saber su porcentage de progreso


        $start = explode('-', $task->start_date);
        $diff = Carbon::create($start[0], $start[1], $start[2])->diffInDays();
        $result = (($diff * 8) / $task->estimated_hours) * 100;
        if ($result > 100) {
            $result = 100;
        } else if ($result < 0) {
            $result = 0;
        }

        $task->estimated_progress = $result;
        $actual_percent_completed = $task->estimated_progress;

        /**profit and loss**/
        $team = $this->profit_and_loss_team($dt, $contract, $project, $currency);

        $services = $this->profit_and_loss_services($dt, $contract, $project, $currency);
        $expenses = $this->profit_and_loss_expenses($dt, $contract, $project, $currency);
        $materials = $this->profit_and_loss_materials($dt, $contract, $project, $currency);
        $pv = $team->planned_revenue_nf + $services->planned_revenue_nf + $expenses->planned_revenue_nf + $materials->planned_revenue_nf;
        $ac = $team->real_cost_nf + $services->real_cost_nf + $expenses->real_cost_nf + $materials->real_cost_nf;
        $ev = $team->real_profit_nf + $services->real_profit_nf + $expenses->real_profit_nf + $materials->real_profit_nf;

        return array(
            'pv' => $pv,
            'ac' => $ac,
            'ev' => $ev,
            'actual_percent_completed' => $actual_percent_completed,
            'tasks' => $tasks,
            'total_planned_hours' => $team->total_planned_hours,
            'total_real_hours' => $team->total_real_hours);

    }

    private function profit_and_loss_team($dt, $contract, $project, $currency)
    {


        $requestSend = array('period_from' => $dt->modify('first day of this month')->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt->modify('last day of this month')->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->team($requestSend);
        $team = $team->getData();
        $team = $team->data;

        return $team;
    }

    private function profit_and_loss_services($dt, $contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->modify('first day of this month')->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt->modify('last day of this month')->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->services($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }

    private function profit_and_loss_expenses($dt, $contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->modify('first day of this month')->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt->modify('last day of this month')->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->expenses($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }

    private function profit_and_loss_materials($dt, $contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->modify('first day of this month')->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt->modify('last day of this month')->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->materials($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }



    // Dashboard

     public function chartUserStats(Request $request)
    {
         if ($request->has('project_id') ) {
               // $project = Project::find($request->project_id);
                 $Tasks = Task::where('project_id',$request->project_id)->pluck('id');
                $tickets = Ticket::whereIn('task_id',$Tasks);
                $taskquery=Task::where('project_id',$request->project_id)->whereIn('tasks.id',$Tasks);
                }else{
                     $Tasks = Task::all()->pluck('id');
                    $tickets = Ticket::whereIn('task_id',$Tasks);
            $taskquery=Task::whereIn('tasks.id',$Tasks);

                }

$userTickets =$tickets->distinct()->pluck('assignee_id');
        $data = array();

if ($request->has('option') ) {

$data=array();
$name=array();
$type=array();
    if($request->option==1) 
    {
$userTicketsType =$tickets->select('users.name AS user_name','type',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->groupBy('type')->get();
      
 


foreach ($userTicketsType as $k=>$query) {
 array_push($name, $query->user_name);
 array_push($data, $query->count);
 array_push($type, $query->type);

}
       

    }

    if($request->option==2 ) 
    {

$userTicketsStatus =$tickets->select('users.name AS user_name','status',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->groupBy('status')->get();

$data=array();
foreach ($userTicketsStatus as $k=>$query) {
 array_push($name, $query->user_name);
 array_push($data, $query->count);
 array_push($type, $query->status);
}

    }
    if($request->option==3 ) 
    {
$userTicketsPriority =$tickets->select('users.name AS user_name','priority',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->groupBy('priority')->get();

$data=array();
foreach ($userTicketsPriority as $k=>$query) {
 array_push($name, $query->user_name);
 array_push($data, $query->count);
 array_push($type, $query->priority);

}

     }
    }
        
        return response()->json(array('name' => $name,'data' => $data,'type' => $type));

    }

    /// Lista de opciones
    //// 1 completed
    //// 2 overdue
    //// 3 en progreso

       public function listTasks(Request $request)
    {
         if ($request->has('project_id') ) {
               
                 $Tasks = Task::where('project_id',$request->project_id);
                          if ($request->has('option') ) {
                            switch ($request->option) {
                                case '1':
                                    $Tasks->where('progress',100);
                                    break;
                                    case '2':
                                     $Tasks->where('due_date','<',Carbon::now())->where('progress','!=',100);
                                    break;
                                    case '3':
                                     $Tasks->where('tasks.due_date','<',Carbon::now())->where('progress','!=',100)
                                     ->Join('tickets', 'tickets.task_id', '=', 'tasks.id');

                                    break;
                                
                                default:
                                    # code...
                                    break;
                            }
                            }

                 }else{


                       if ($request->has('option') ) {
                            switch ($request->option) {
                                case '1':
                                 $Tasks =   Task::where('progress',100);
                                    break;
                                    case '2':
                                 $Tasks =    Task::where('due_date','<',Carbon::now())->where('progress','!=',100);
                                    break;
                                    case '3':
                                $Tasks =     Task::where('tasks.due_date','<',Carbon::now())->where('progress','!=',100)
                                     ->Join('tickets', 'tickets.task_id', '=', 'tasks.id');                                     
                                    break;
                                
                                default:
                                  $Tasks = Tasks::all();
                                    break;
                            }
                            }
     
                }


    
//$tasksPriority =$taskquery->select(\DB::raw('count(tasks.priority) as count'),'tickets.assignee_id','tasks.priority')
//->Join('tickets', 'tickets.task_id', '=', 'tasks.id')
//->groupBy('tasks.priority')->get();


/*        $data = array();
        array_push($data, $planned_value);
        array_push($data, $real_value);*/


        return response()->json(array('data' => $Tasks->get()));

    }

    function array_group(array $data, $by_column)
{
    $result = [];
    foreach ($data as $item) {
        $column = $item[$by_column];
        unset($item[$by_column]);
        $result[$column][] = $item;
    }
    return $result;
}
}

?>
