<?php

namespace App\Http\Controllers;

use App\Currency;
use App\Models\Contract;
use App\Models\Dashboard;
use App\Models\Project;
use App\Models\Task;
use App\Models\TeamUser;
use App\Models\Ticket;
use App\Models\Requirement;
use App\Models\User;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\DashboardTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Dashboards
 *
 * @Resource("Group Dashboard")
 */
class DashboardController extends Controller
{

    /**
     * Obtener Dashboards
     *
     * @Get("Dashboards{?include, company_id}")
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
        $query = Dashboard::query();


        $query->where('company_id', $request->company_id);

        if($request->has('category'))
                    $query->where('category', $request->category);

 if($request->has('showdashboard'))
                    $query->where('showdashboard', $request->showdashboard);


        $Dashboards = $query->get();

        return $this->response->collection($Dashboards, new DashboardTransformer);
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
     * @Post("Dashboards")
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
        if (!isset($data['showDashboard'])) {
            $data['showDashboard'] = 0;
        } else {
            $data['showDashboard'] = 1;
        }
        $Dashboard = Dashboard::create($data);

        if ($Dashboard) {
            return $this->response->item($Dashboard, new DashboardTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener cost
     *
     * @Get("Dashboards/{id}")
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
        $Dashboard = Dashboard::findOrFail($id);

        return $this->response->item($Dashboard, new DashboardTransformer);
    }

    /**
     * Editar cost
     *
     * @Patch("Dashboards/{id}")
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
        $Dashboard = Dashboard::find($id);

        if ($Dashboard == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();


        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        if (!isset($data['showDashboard'])) {
            $data['showDashboard'] = 0;
        } else {
            $data['showDashboard'] = 1;
        }
        $Dashboard->update($data);

        if ($Dashboard) {
            return $this->response->item($Dashboard, new DashboardTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina una cost
     *
     * @Delete("Dashboards/{id}")
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
        $Dashboard = Dashboard::find($id);

        if ($Dashboard == NULL) {
            return $this->response->error('No existe', 450);
        }

        $Dashboard->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener Dashboards
     *
     * Con formato listo para datatables con ajax
     * @Get("Dashboards/datatables")
     */
    public
    function datatables(Request $request)
    {
        $companyId = ($request->has('company_id')) ? $request->company_id : null;

        $query = DB::table('Dashboards')
            ->select(
                'Dashboards.id',
                'Dashboards.company_id',
                'Dashboards.category',
                'Dashboards.graphic_type',
                'Dashboards_category.name as category_name',
                'Dashboards.nombre',
                'Dashboards.Dashboard',
                'Dashboards.showDashboard',
                'Dashboards.type_of_result',
                'Dashboards.description',
                'Dashboards.query');

        if (!empty($companyId)) {
            $query->where('Dashboards.company_id', $companyId);
        }

        $Dashboards = $query->join('Dashboards_category', 'Dashboards_category.id', '=', 'Dashboards.category');
        $Dashboards = $query->get();

        return Datatables::of($Dashboards)->make(true);
    }

    public function chartEvTotal(Request $request)
    {
        $type=array();
        $data = array();
        if($request->has('project_id')){
            
        
        $project = Project::find($request->project_id);
        
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        }else{
            $firstdate =Project::select('start')->min('start');
            $lastdate =Project::select('finish')->max('finish');
            $begin = new DateTime($firstdate);
            $end = new DateTime($lastdate);
        }
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
       
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $actual_percent_data= array();
            if(!$request->has('project_id')){
                $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
                ->get(['contracts.*', 'customers.company_id']);
                $pv=0;
                $ac=0;
                $ev=0;
                $actual_percent_completed =0;
                foreach ($contract as $contrac) {
                        $projet=Project::find($contrac->project_id);
                        $curren = Currency::find($contrac->currency_id);
                        $tasks = Task::where('project_id', '=', $contrac->project_id)->orderBy('index', 'asc')->get();
                        foreach($tasks as $task){
                        if(isset($task->start_date)){
                        $diff = Carbon::parse($task->start_date);
                        $diff= $diff->diffInDays();
                        $result = (($diff * 8) / $task->estimated_hours) * 100;
                        if ($result > 100) {
                            $result = 100;
                        } else if ($result < 0) {
                            $result = 0;
                        }
                        $task->estimated_progress =$task->estimated_progress + $result/count($tasks);
                        $actual_percent_completed = $task->estimated_progress+ $actual_percent_completed/count($tasks);
            
                    }else{
                           // $task->estimated_progress = 0;
                            $actual_percent_completed = 0;
                        }
                        
                      
                    }
            
                $team = $this->profit_and_loss_team_total($begin,$end, $contrac, $projet, $curren);
           $services = $this->profit_and_loss_services_total($begin,$end, $contrac, $projet, $curren);
                $expenses = $this->profit_and_loss_expenses_total($begin,$end, $contrac, $projet, $curren);
                $materials = $this->profit_and_loss_materials_total($begin,$end, $contrac, $projet, $curren);
                $pv =$pv+ $team->planned_revenue_nf + $services->planned_revenue_nf + $expenses->planned_revenue_nf + $materials->planned_revenue_nf;
                $ac =$ac+ $team->real_cost_nf + $services->real_cost_nf + $expenses->real_cost_nf + $materials->real_cost_nf;
                $ev =$ev+ $team->real_profit_nf + $services->real_profit_nf + $expenses->real_profit_nf + $materials->real_profit_nf;
              
                     
            }
            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;
        
            $planed_value_data[] = $pv;

            $actual_percent_data[] = $actual_percent_completed;


          //  return $actual_percent_completed;
        }else{
            if($request->has('project_id')){
                $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')->where('contracts.project_id', '=', $project->id)->get(['contracts.*', 'customers.company_id'])->first();
                $currency = Currency::find($contract->currency_id);
            }
            
            
            if($request->has('project_id')){
            $tasks = Task::where('project_id', '=', $request->project_id)->orderBy('index', 'asc')->get();
            }

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
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

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
            
            $actual_percent_data[] = $actual_percent_completed;

        }
    }
    array_push($type, 'Planned value');
    array_push($type, 'Earned value');
   
    array_push($type,'Actual Cost');
    //array_push($type,'Completation Project(s) Percent');
    array_push($data, array('name' => 'Planned value', 'data' =>$actual_cost_data));
        array_push($data, array('name' => 'Earned value', 'data' =>$earned_value_data));
        array_push($data,array('name' => 'Actual Cost', 'data' => $planed_value_data));
        //array_push($data,array('type' => 'Completation Project(s) Percent', 'data' => $actual_percent_data));

        return response()->json(array('type' => $type, 'data' => $data));

    }

    public function chartEv(Request $request)
    {
        $data = array();
        if($request->has('project_id')){
            
        
        $project = Project::find($request->project_id);
        
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);
        }else{
            $firstdate =Project::select('start')->min('start');
            $lastdate =Project::select('finish')->max('finish');
            $begin = new DateTime($firstdate);
            $end = new DateTime($lastdate);
        }
        $interval = DateInterval::createFromDateString('1 month');
        $end->setTime(0, 0, 1);
        $period = new DatePeriod($begin, $interval, $end);

        $months = array();
        $earned_value = array('name' => 'Earned value');
        $planned_value = array('name' => 'Planned value');
        $actual_cost = array('name' => 'Actual Cost');
        $actual_percent = array('name' => 'Completation Project(s) Percent');
        $earned_value_data = array();
        $actual_cost_data = array();
        $planed_value_data = array();
        $actual_percent_data= array();
            if(!$request->has('project_id')){
                $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
                ->get(['contracts.*', 'customers.company_id']);
                $pv=0;
                $ac=0;
                $ev=0;
                $actual_percent_completed =0;
                foreach ($contract as $contrac) {
                        $projet=Project::find($contrac->project_id);
                        $curren = Currency::find($contrac->currency_id);
                        $tasks = Task::where('project_id', '=', $contrac->project_id)->orderBy('index', 'asc')->get();
                        foreach($tasks as $task){
                        if(isset($task->start_date)){
                        $diff = Carbon::parse($task->start_date);
                        $diff= $diff->diffInDays();
                        $result = (($diff * 8) / $task->estimated_hours) * 100;
                        if ($result > 100) {
                            $result = 100;
                        } else if ($result < 0) {
                            $result = 0;
                        }
                        $task->estimated_progress =$task->estimated_progress + $result/count($tasks);
                        $actual_percent_completed = $task->estimated_progress+ $actual_percent_completed/count($tasks);
            
                    }else{
                           // $task->estimated_progress = 0;
                            $actual_percent_completed = 0;
                        }
                        
                      
                    }
            
                $team = $this->profit_and_loss_team_total($begin,$end, $contrac, $projet, $curren);
           $services = $this->profit_and_loss_services_total($begin,$end, $contrac, $projet, $curren);
                $expenses = $this->profit_and_loss_expenses_total($begin,$end, $contrac, $projet, $curren);
                $materials = $this->profit_and_loss_materials_total($begin,$end, $contrac, $projet, $curren);
                $pv =$pv+ $team->planned_revenue_nf + $services->planned_revenue_nf + $expenses->planned_revenue_nf + $materials->planned_revenue_nf;
                $ac =$ac+ $team->real_cost_nf + $services->real_cost_nf + $expenses->real_cost_nf + $materials->real_cost_nf;
                $ev =$ev+ $team->real_profit_nf + $services->real_profit_nf + $expenses->real_profit_nf + $materials->real_profit_nf;
              
                     
            }
            $earned_value_data[] = $ev * $actual_percent_completed;

            $actual_cost_data[] = $ac;
        
            $planed_value_data[] = $pv;

            $actual_percent_data[] = $actual_percent_completed;


          //  return $actual_percent_completed;
        }else{
            if($request->has('project_id')){
               
            $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.project_id', '=', $project->id)->get(['contracts.*', 'customers.company_id'])->first();
        $currency = Currency::find($contract->currency_id);
            }
            
            
            if($request->has('project_id')){
            $tasks = Task::where('project_id', '=', $request->project_id)->orderBy('index', 'asc')->get();
            }

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
        foreach ($period as $dt) {
            $months[] = $dt->format('M');

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
            
            $actual_percent_data[] = $actual_percent_completed;

        }
    }
        $earned_value['data'] = $earned_value_data;
        $actual_cost['data'] = $actual_cost_data;
        $planned_value['data'] = $planed_value_data;
        $actual_percent['data']= $actual_percent_data;
        array_push($data, $earned_value);
        array_push($data, $actual_cost);
        array_push($data, $planned_value);
        array_push($data, $actual_percent);

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

            $queryT = "SELECT count(users.name) AS tickets_numbers FROM tickets
                     INNER JOIN  users ON users.id=tickets.owner_id

         INNER JOIN   tasks ON tasks.id=tickets.task_id
          INNER JOIN   projects ON tasks.project_id=projects.id
          INNER JOIN   customers ON projects.customer_id=customers.id
           ".$where."" ;
            $querytasksT = DB::select($queryT);

$type=array();
$data=array();
$i=1;
//return $querytasksT;
 
$keyMax= array_search(max($querytasks), $querytasks);
$maxR= $querytasks[$keyMax]->tickets_numbers;
$keyMax= array_search(max($querytasksT), $querytasksT);
$totalR= $querytasksT[$keyMax]->tickets_numbers;
foreach ($querytasks as $k=>$query) {

    if($query->tickets_numbers==$maxR) {$class='graphic_alert_green';}

                    if($query->tickets_numbers<$maxR ){$class='graphic_alert_'.intval($i);}

             array_push($data, array('value'=>$query->tickets_numbers,'className'=>$class) );
              array_push($type, $query->owner_name);
              $i++;
}

            return response()->json(array('type' => $type,'data' => $data,'total'=>$totalR));
           
    
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

       array_push($data, round(floatval($query->diff_date*100),4));
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


    public function chartRequirements(Request $request)
    {

            

        if ($request->has('project_id') ) {
            $Requirement = Requirement::
            select('type','type',\DB::raw('count(id) as count'))
            ->where('project_id',$request->project_id)
            ->groupBy('type')->orderBy(\DB::raw('count(id)'),'DESC')->get();
            $TotalRequirement = Requirement::where('project_id',$request->project_id)->get();
        }else{
            $Requirement = Requirement::select('type','type',\DB::raw('count(id) as count'))
            ->groupBy('type')->orderBy(\DB::raw('count(id)'),'DESC')->get();
            $TotalRequirement = Requirement::all();

        }
       
            $data=array();
            $type=array();
           
     
          
            $i=4;
            foreach($Requirement as $r)
            {
                $maxR= max($Requirement->pluck('count')->toArray());
                if($r->count==$maxR) {$class='graphic_alert_green';}
                if($r->count<$maxR ){$class='graphic_alert_'.intval($i);}
            
                //if($r->count==$TotalRequirement->count()-1){$class='graphic_alert_green';}

                array_push($type,$r->type);
                array_push($data,($r->count));//,'className'=>$class));

            }
        return response()->json(array('type' => $type,'data' => $data));
 

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

    public function chartTasks(Request $request)
    {

        if($request->has('project_id')){
            
        
            $project = Project::find($request->project_id);
            
            $begin = ($project->start);
            $end = ($project->finish);
            $tasks = Task::where('project_id', '=', $request->project_id)->
            orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$begin' AS DATE) AND CAST('$end' AS DATE)")
                ->get();
                $tasktotal=Task::where('project_id', '=', $request->project_id)->count();
            }else{
                $firstdate =Project::select('start')->min('start');
                $lastdate =Project::select('finish')->max('finish');
                $begin = ($firstdate);
                $end = ($lastdate);

                $tasks = Task::orderBy('index', 'asc')
                    ->whereRaw("start_date BETWEEN CAST('$begin' AS DATE) AND CAST('$end' AS DATE)")
                    ->get();
                    $tasktotal=Task::all()->count();

            }

               


            $countoverdues = 0;
            $countonpprogress=0;
            $countcompleted=0;
            $countcompletedbefore=0;
            $type=array();
            $data=array();
            $today = new DateTime(Carbon::now()->format('Y-m-d'));
            foreach ($tasks as $task) {
             
                $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));

                if ($duedate < $today && $task->progress != 100) {
                    $countoverdues++;
                }
                if ($duedate < $today && $task->progress == 100) {
                    $countcompleted++;
                }
                if ($duedate > $today && $task->progress == 100) {
                    $countcompletedbefore++;
                }
                if ($duedate > $today && $task->progress != 100) {
                    $countonpprogress++;
                }
            }
            if($countoverdues>0){
            array_push($type, 'OverDue');
            array_push($data, array('value'=>$countoverdues));
            }
            if($countcompleted>0){
            array_push($type, 'Completed');
            array_push($data,  array('value'=>$countcompleted));
            }
            if($countonpprogress>0){
            array_push($type, 'On Progress');
            array_push($data, array('value'=>$countonpprogress));
            }
            if($countcompletedbefore>0){
            array_push($type, 'Completed Before Date');    
            array_push($data, array('value'=>$countcompletedbefore));
            }  
        
        return response()->json(array('type' =>  $type,'data' =>  $data,'total' =>  $tasktotal));

    }


    public function chartMilestonesTasks(Request $request)
    {

        if ($request->has('project_id') ) {
            $firstdate =Project::select('start')->where('id',$request->project_id)->min('start');
        $lastdate =Project::select('finish')->where('id',$request->project_id)->max('finish');   
        }else{
            $firstdate =Project::select('start')->min('start');
            $lastdate =Project::select('finish')->max('finish');   
        }
        //$project = Project::find($request->project_id);
        $data = array();
        $type = array();
   

        $due_value = array('name' => 'Due milestones');
        $started_value = array('name' => 'Started milestones');

        $due_data = array();
        $started_data = array();
        //foreach ($period as $dt) {
            //$months[] = $dt->format('M');

            /******************/
            $totaltask=0;

            if ($request->has('project_id') ) {
            $tasks = Task::where('project_id', '=', $request->project_id)->
            where('end_is_milestone',0)
            ->orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$firstdate' AS DATE) AND CAST('$lastdate' AS DATE)")
                ->get();
                $totaltask=Task::where('project_id', '=', $request->project_id)->where('end_is_milestone',0)->count();
            }else{
                $tasks = Task::whereRaw("start_date BETWEEN CAST('$firstdate' AS DATE) AND CAST('$lastdate' AS DATE)")
                ->where('end_is_milestone',0)
                    ->orderBy('index', 'asc')
                    ->get();  
                    $totaltask=Task::where('end_is_milestone',0)->count();
            }
            $countdues = 0;

            $today = new DateTime(\Carbon\Carbon::today()->modify('last day of this month')->format('Y-m-d'));
            foreach ($tasks as $task) {
                $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));

                if ($duedate < $today && $task->progress != 100) {
                    $countdues++;
                }
            }
            $started_data[] = count($tasks);
            $due_data[] = $countdues;
        
        ///}

        $due_value['data'] = $due_data;
        $started_value['data'] = $started_data;
        // $started_value['className']= 'graphic_alert_green';
        // $due_value['className'] ='graphic_alert_red';
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $started_value);
        array_push($data, $due_value);
        
        array_push($type, 'Started milestones');

        array_push($type, 'Due milestones');
        return response()->json(array('type' => $type,'data' => $data));

    }


    public function chartMissingMilestonesTasks(Request $request)
    {
        if ($request->has('project_id') ) {
            $firstdate =Project::select('start')->where('id',$request->project_id)->min('start');
        $lastdate =Project::select('finish')->where('id',$request->project_id)->max('finish');   
        }else{
            $firstdate =Project::select('start')->min('start');
            $lastdate =Project::select('finish')->max('finish');   
        }
        //$project = Project::find($request->project_id);
        $data = array();
       
   

        $due_value = array('name' => 'Due milestones');
       // $started_value = array('name' => 'Started milestones');

        $due_data = array();
        $started_data = array();
        //foreach ($period as $dt) {
            //$months[] = $dt->format('M');

            /******************/
            $totaltask=0;

            if ($request->has('project_id') ) {
            $tasks = Task::where('project_id', '=', $request->project_id)->
            where('end_is_milestone',1)
            ->orderBy('index', 'asc')
                ->whereRaw("start_date BETWEEN CAST('$firstdate' AS DATE) AND CAST('$lastdate' AS DATE)")
                ->get();
                $totaltask=Task::where('project_id', '=', $request->project_id)->where('end_is_milestone',1)->count();
            }else{
                $tasks = Task::whereRaw("start_date BETWEEN CAST('$firstdate' AS DATE) AND CAST('$lastdate' AS DATE)")
                ->where('end_is_milestone',1)
                    ->orderBy('index', 'asc')
                    ->get();  
                    $totaltask=Task::where('end_is_milestone',1)->count();
            }
            $countdues = 0;

            $today = new DateTime(\Carbon\Carbon::today()->modify('last day of this month')->format('Y-m-d'));
            foreach ($tasks as $task) {
                $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));

                if ($duedate < $today && $task->progress != 100) {
                    $countdues++;
                }
            }

            $due_data[] = $countdues;
        
        ///}

        $due_value['data'] = $due_data;
        
        //  array_push($data, $earned_value);
        // array_push($data, $actual_cost);
        //array_push($data, $planned_value);
        array_push($data, $due_value);
       // array_push($data, $started_value);

        return response()->json(array('total' => $totaltask, 'data' => $data));

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


    public function calculateBasicsIndicators_total()
    {
        $firstdate =Project::select('start')->min('start');
        $lastdate =Project::select('finish')->max('finish');
        $begin = new DateTime($firstdate);
        $end = new DateTime($lastdate);

            $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->get(['contracts.*', 'customers.company_id']);
            $pv=0;
            $ac=0;
            $ev=0;
            $actual_percent_completed =0;
            $total_real_hours=0;
            foreach ($contract as $contrac) {
                    $projet=Project::find($contrac->project_id);
                    $curren = Currency::find($contrac->currency_id);
                    $tasks = Task::where('project_id', '=', $contrac->project_id)->orderBy('index', 'asc')->get();
                    foreach($tasks as $task){
                    if(isset($task->start_date)){
                    $diff = Carbon::parse($task->start_date);
                    $diff= $diff->diffInDays();
                    $result = (($diff * 8) / $task->estimated_hours) * 100;
                    if ($result > 100) {
                        $result = 100;
                    } else if ($result < 0) {
                        $result = 0;
                    }
                    $estimated_progress =$task->estimated_progress + $result/count($tasks);
                    $actual_percent_completed = $task->estimated_progress+ $actual_percent_completed/count($tasks);
                    
                }else{
                       // $task->estimated_progress = 0;
                        $actual_percent_completed = 0;
                    }
                    
                  
                }
        
            $team = $this->profit_and_loss_team_total($begin,$end, $contrac, $projet, $curren);
      
       $services = $this->profit_and_loss_services_total($begin,$end, $contrac, $projet, $curren);
            $expenses = $this->profit_and_loss_expenses_total($begin,$end, $contrac, $projet, $curren);
            $materials = $this->profit_and_loss_materials_total($begin,$end, $contrac, $projet, $curren);
            $pv =$pv+ $team->planned_revenue_nf + $services->planned_revenue_nf + $expenses->planned_revenue_nf + $materials->planned_revenue_nf;
            $ac =$ac+ $team->real_cost_nf + $services->real_cost_nf + $expenses->real_cost_nf + $materials->real_cost_nf;
            $ev =$ev+ $team->real_profit_nf + $services->real_profit_nf + $expenses->real_profit_nf + $materials->real_profit_nf;
            $total_real_hours= intval($team->real_cost)+$total_real_hours;
                 
        }

        return array(
            'pv' => $pv,
            'ac' => $ac,
            'ev' => $ev,
            'actual_percent_completed' => $actual_percent_completed,
            'tasks' =>Task::all(),
            'total_planned_hours' => $estimated_progress,
            'total_real_hours' => $total_real_hours );

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


    private function profit_and_loss_team_total($dt,$dt2, $contract, $project, $currency)
    {


        $requestSend = array('period_from' => $dt->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->team($requestSend);
        $team = $team->getData();
        $team = $team->data;

        return $team;
    }

    private function profit_and_loss_services_total($dt, $dt2,$contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt2->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->services($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }

    private function profit_and_loss_expenses_total($dt,$dt2, $contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt2->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->expenses($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }

    private function profit_and_loss_materials_total($dt, $dt2,$contract, $project, $currency)
    {
        $requestSend = array('period_from' => $dt->format("Y-m-d"), 'project_id' => $project->id,
            'period_to' => $dt2->format("Y-m-d"),
            'company_id' => $contract->company_id, 'customer_id' => $contract->customer_id, 'currency_id' => $currency->id,
            'contract_id' => $contract->id);
        $requestSend = new \Illuminate\Http\Request($requestSend);
        $team = app('App\Http\Controllers\ProfitAndLossController')->materials($requestSend);
        $team = $team->getData();
        $team = $team->data;
        return $team;
    }


    // Dashboard

     public function chartTicketsStats(Request $request)
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
                $tasktotal=$tickets->count();
$userTickets =$tickets->distinct()->pluck('assignee_id');
        $data = array();

if ($request->has('option') ) {

$data=array();
$name=array();
$type=array();


    if($request->option==1) 
    {
        if (!$request->has('project_id') ) {
$userTicketsType =$tickets->select('users.name AS user_name','type',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
      
        }else{
            $userTicketsType =$tickets->select('users.name AS user_name','type',\DB::raw('count(tickets.id) as count'))
            ->join('users', 'users.id', '=', 'tickets.assignee_id')
            ->WhereIn('tickets.assignee_id',$userTickets)
            ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        }
$i=1;
foreach ($userTicketsType as $k=>$query) {
    if($k==0) {$class='graphic_alert_red';}
    if($k>0 && $k<count($userTicketsType)-1){$class='graphic_alert_'.intval($i);}
    $i++;

    if($k==count($userTicketsType)-1){$class='graphic_alert_green';}
    array_push($data, array('value'=> $query->count,'className'=> $class));
 //array_push($data, $query->count);
 $class='';
 switch($query->type)
 {
    case 1 :
    array_push($type, 'User Story');
    break;
    case 2 :
        array_push($type, 'Bug');
    break;
    case 3 :
    array_push($type, 'Risk');
    break ;
    case 4 :
    array_push($type, 'Epic');
    break ;
     case 5 :
     array_push($type, 'Scope Changes');
    break;
    

 }
}
       

    }

    if($request->option==2 ) 
    {
        if (!$request->has('project_id') ) {

$userTicketsStatus =$tickets->select('users.name AS user_name','status',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    
                    ->groupBy('status')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
        }else{
            $userTicketsStatus =$tickets->select('users.name AS user_name','status',\DB::raw('count(tickets.id) as count'))
            ->join('users', 'users.id', '=', 'tickets.assignee_id')
            ->WhereIn('tickets.assignee_id',$userTickets)

            ->groupBy('status')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        }

$data=array();
foreach ($userTicketsStatus as $k=>$query) {
    if($k==0) {$class='graphic_alert_red';}
    if($k>0 && $k<count($userTicketsStatus)-1){$class='graphic_alert_green';}
    
    if($k==count($userTicketsStatus)-1){$class='graphic_alert_yellow';}
    array_push($data, array('value'=> $query->count,'className'=> $class));
    $class='';
    //array_push($data, $query->count);
 switch($query->status)
 {
    case 1 :
    array_push($type, 'To do');
    break;
    case 2 :
        array_push($type, 'Waiting');
    break;
    case 3 :
    array_push($type, 'In Progress');
    break ;
    case 4 :
    array_push($type, 'Canceled');
    break ;
     case 5 :
     array_push($type, 'Rescheduled');
    break;
    case 6 :
    array_push($type, 'Resolved');
    break;

 }
}

    }
    if($request->option==3 ) 
    {
        if (!$request->has('project_id') ) {

$userTicketsPriority =$tickets->select('users.name AS user_name','priority',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->groupBy('priority')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
        }else{
            $userTicketsPriority =$tickets->select('users.name AS user_name','priority',\DB::raw('count(tickets.id) as count'))
                    ->join('users', 'users.id', '=', 'tickets.assignee_id')
                    ->WhereIn('tickets.assignee_id',$userTickets)

                    ->groupBy('priority')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        }
$data=array();
foreach ($userTicketsPriority as $k=>$query) {
    if($k==0) {$class='graphic_alert_red';}
    if($k>0 && $k<count($userTicketsPriority)-1){$class='graphic_alert_yellow';}

    if($k==count($userTicketsPriority)-1){$class='graphic_alert_green';}
    array_push($data, array('value'=> $query->count,'className'=> $class));
    $class='';
 switch($query->priority)
 {
    case 1 :
    array_push($type, 'Low');
    break;
    case 2 :
        array_push($type, 'Medium');
    break;
    case 3 :
    array_push($type, 'High');
    break ;
   
    

 }
}

     }
    }
        
        return response()->json(array('data' => $data,'type' => $type,'total' => $tasktotal));

    }

    /// Lista de opciones
    //// 1 completed
    //// 2 overdue
    //// 3 en progreso

       public function listTasks(Request $request)
    {
        $data=array();
        $name=array();
        $label="";
         if ($request->has('project_id') ) {
               
                 $Tasks = Task::where('project_id',$request->project_id);
                          if ($request->has('option') ) {
                            switch ($request->option) {
                                case '1':
                                    $Tasks->where('progress',100);
                                    $label='Completed';
                                    break;
                                    case '2':
                                     $Tasks->where('due_date','<',Carbon::now())->where('progress','!=',100);
                                     $label='Overdue';
                                    break;
                                    case '3':
                                     $Tasks->where('tasks.due_date','>=',Carbon::now())->where('progress','!=',100)
                                     ->Join('tickets', 'tickets.task_id', '=', 'tasks.id');
                                     $label='In Progress';
                                    break;
                                
                            
                            }
                            }
                            $tasktotal=Task::where('project_id',$request->project_id)->get();
                 }else{


                       if ($request->has('option') ) {
                            switch ($request->option) {
                                case '1':
                                 $Tasks =   Task::where('progress',100);
                                 $label='Completed';
                                    break;
                                    case '2':
                                 $Tasks =    Task::where('due_date','<',Carbon::now())->where('progress','!=',100);
                                 $label='Overdue';
                                    break;
                                    case '3':
                                $Tasks =     Task::where('tasks.due_date','>=',Carbon::now())->where('progress','!=',100)
                                     ->Join('tickets', 'tickets.task_id', '=', 'tasks.id');  
                                     $label='In Progress';                                   
                                    break;
                                
                               }
                            }else{
                                $Tasks = Task::all();
                            }
                            $tasktotal=Task::all();

                }
                $k=$Tasks->count();

                if($k==0) {$class='graphic_alert_red';}
                if($k>0 && $k<count($tasktotal)-1){$class='graphic_alert_red';}
            
                if($k==count($tasktotal)-1){$class='graphic_alert_green';}
                array_push($data, array('value'=> $k,'className'=> $class));
                array_push($name, $label);
                array_push($data, array('value'=> count($tasktotal)-$k,'className'=> 'graphic_alert_green'));
                array_push($name, 'Others Tickets');

        return response()->json(array('type' =>$name ,'data' =>$data ,'total'=> count($tasktotal)));

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


public function chartTicketsStatsType(Request $request)
{
     if ($request->has('project_id') ) {
           // $project = Project::find($request->project_id);
             $Tasks = Task::where('project_id',$request->project_id)->pluck('id');
            $tickets = Ticket::whereIn('task_id',$Tasks);
            $taskquery=Task::where('project_id',$request->project_id)->whereIn('tasks.id',$Tasks)->count();
            }else{
                 $Tasks = Task::all()->pluck('id');
                $tickets = Ticket::whereIn('task_id',$Tasks);
        $taskquery=Task::whereIn('tasks.id',$Tasks)->count();

            }
$ticketT=$tickets->count();
$userTickets =$tickets->distinct()->pluck('assignee_id');
    $data = array();

if ($request->has('type') ) {

$data=array();
$name=array();
$type=array();



    if (!$request->has('project_id') ) {
    $userTicketsType =$tickets->select('users.name AS user_name','type','status','priority',\DB::raw('count(tickets.id) as count'))
                ->join('users', 'users.id', '=', 'tickets.assignee_id')
                ->Where('tickets.type','=',$request->type);
            //    ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
  

                
    }else{
        $userTicketsType =$tickets->select('users.name AS user_name','type','status','priority',\DB::raw('count(tickets.id) as count'))
        ->join('users', 'users.id', '=', 'tickets.assignee_id')
        ->Where('tickets.type','=',$request->type)
        ->WhereIn('tickets.assignee_id',$userTickets);
       // ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

    }

    if ($request->has('option') ) {
        if($request->option=='2'){
            $userTicketsType = $userTicketsType->groupBy('status')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        }
        if($request->option=='3'){
            $userTicketsType = $userTicketsType->groupBy('priority')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        }
    }else{
        $userTicketsType = $userTicketsType->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
    }
// var_dump($userTicketsType);
// die;
$i=1;
foreach ($userTicketsType as $k=>$query) {
if($k==0) {$class='graphic_alert_red';}
if($k>0 && $k<count($userTicketsType)-1){$class='graphic_alert_'.intval($i);}
$i++;
//if($k==count($userTicketsType)-1){$class='graphic_alert_red';}
array_push($data, array('value'=> $query->count,'className'=> $class));
$class='';
if ($request->has('option') ) {
    if($request->option==2){

    switch($query->status)
    {
    case 1 :
    array_push($type, 'To do');
    break;
    case 2 :
        array_push($type, 'Waiting');
    break;
    case 3 :
    array_push($type, 'In Progress');
    break ;
    case 4 :
    array_push($type, 'Canceled');
    break ;
     case 5 :
     array_push($type, 'Rescheduled');
    break;
    case 6 :
    array_push($type, 'Resolved');
    break;
    
    }
    }
if($request->option==3){

switch($query->priority)
{
    case 1 :
        array_push($type, 'Low');
        break;
        case 2 :
            array_push($type, 'Medium');
        break;
        case 3 :
        array_push($type, 'High');
        break ;

}
}
}

}
   
}
if ($request->has('total') ) {
    if($request->total==1){
       
        if ($request->has('project_id') ) {
            // $project = Project::find($request->project_id);
              $Tasks = Task::where('project_id',$request->project_id)->pluck('id');
             $tickets = Ticket::whereIn('task_id',$Tasks);
             $taskquery=Task::where('project_id',$request->project_id)->whereIn('tasks.id',$Tasks)->count();
             }else{
                  $Tasks = Task::all()->pluck('id');
                 $tickets = Ticket::whereIn('task_id',$Tasks);
         $taskquery=Task::whereIn('tasks.id',$Tasks)->count();
 
             }


// $data[0]['value']=array($data[0]['value'],);
// $data[0]['className']=array($data[0]['className'],'graphic_alert_green');
array_push($data,array('value'=>$taskquery-intval($data[0]['value']),'className'=>'graphic_alert_green'));
if ($request->has('type') ) {

    switch($query->type)
     {
        case 1 :
        array_push($type, 'User Story');
        break;
        case 2 :
            array_push($type, 'Bug');
        break;
        case 3 :
        array_push($type, 'Risk');
        break ;
        case 4 :
        array_push($type, 'Epic');
        break ;
         case 5 :
         array_push($type, 'Scope Changes');
        break;
        
    
     }
     array_push($type, 'Others Tickets');
    }     
}
}


    // $t =$taskquery-intval($data[0]['value']);
    // return $t;
    return response()->json(array('type' => $type,'data' => $data,'total' =>$taskquery-intval($data[0]['value']) ));

}


////////////////////////Resources

public function chartResourceUtilization(Request $request)
{
    $data=array();
    $name=array();
    $label="";
    $tasktotal=0;
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
$tasktotal=$taskquery->count();
         $userTickets =$tickets->distinct()->pluck('assignee_id');

         $today = new DateTime(Carbon::now()->format('Y-m-d'));

     if ($request->has('project_id') ) {
           
        $userTickets =$tickets->select('users.name AS user_name',\DB::raw('count(tickets.id) as count'))
        ->join('users', 'users.id', '=', 'tickets.assignee_id')
        ->join('tasks', 'tickets.task_id', '=', 'tasks.id')

        ->WhereIn('tickets.assignee_id',$userTickets)
        
        ->Where('tasks.project_id',$request->project_id)
        ->Where('tickets.due_date','<',$today)
        ->Where('tickets.status','<>',6)
        ->groupBy('users.name')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();

        $Tasks = Task::where('project_id',$request->project_id)->pluck('id');
        $tickets = Ticket::whereIn('task_id',$Tasks);

        //$tasktotal=$tickets->count();
             }else{
           
            $userTickets =$tickets->select('users.name AS user_name',\DB::raw('count(tickets.id) as count'))
            ->join('users', 'users.id', '=', 'tickets.assignee_id')
            ->WhereIn('tickets.assignee_id',$userTickets)
            ->Where('tickets.due_date','<',$today)
            ->Where('tickets.status','<>',6)
            ->groupBy('users.name')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();    
        }
            
            $k=$Tasks->count();

            $i=1;
            $maxR= max($userTickets->pluck('count')->toArray());
            $minR= min($userTickets->pluck('count')->toArray());
            foreach ($userTickets as $ut) {
                $k=$ut->count;

                // if($ut->count==$maxR) {$class='graphic_alert_green';}
                // //if($ut->count==$minR) {$class='graphic_alert_red';}
                // if($ut->count<$maxR ){$class='graphic_alert_'.intval($i);}

            // if($k==($tasktotal)-1){$class='graphic_alert_green';}
            array_push($data, array('value'=> $k)); //'className'=> $class
            array_push($name, $ut->user_name);
            $i++;
            }

            
            // array_push($data, array('value'=> count($tasktotal),'className'=> 'graphic_alert_green'));
            // array_push($name, 'Total');

    return response()->json(array('type' =>$name ,'data' =>$data,'total' =>($tasktotal)));

}


//////////////////////////////////////



public function chartIssues(Request $request)
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
            $ticketT= $tickets->count();


$userTickets =$tickets->distinct()->pluck('assignee_id');
    $data = array();


$data=array();
$name=array();
$type=array();



    if (!$request->has('project_id') ) {
    $userTicketsType =$tickets->select('users.name AS user_name','type','status','priority',\DB::raw('count(tickets.id) as count'))
                ->join('users', 'users.id', '=', 'tickets.assignee_id')
                ->Where('tickets.type','=',2)->orWhere('tickets.type','=',5)->get();
                //    ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
             //   $ticketT= $tickets->count();


                
    }else{
        $userTicketsType =$tickets->select('users.name AS user_name','type','status','priority',\DB::raw('count(tickets.id) as count'))
        ->join('users', 'users.id', '=', 'tickets.assignee_id')
        ->Where('tickets.type','=',2)->orWhere('tickets.type','=',5)
        ->WhereIn('tickets.assignee_id',$userTickets)->get();
       // ->groupBy('type')->orderBy(\DB::raw('count(tickets.id)'),'DESC')->get();
    }
    foreach ($userTicketsType as $k=>$query) {
   
     
        array_push($data, array('value'=> $query->count,'className'=> 'graphic_alert_red'));
     array_push($name, 'Issues');
     array_push($data, array('value'=> $ticketT-$query->count,'className'=> 'graphic_alert_green'));
     array_push($name, 'Others Tickets');

    }
    
    return response()->json(array('type' =>$name ,'data' =>$data ,'total' =>$ticketT));

}


////////// Response Times

public function chartResponseTimes(Request $request)
{
    $data=array();
    $name=array();
    $label="";
    $tasktotal=0;
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
        $tasktotal=$taskquery->count();
         $userTickets =$tickets->distinct()->pluck('assignee_id');

         $today = new DateTime(Carbon::now()->format('Y-m-d'));
         $userResponsetime=array();
        foreach($userTickets as $user)
        {
            
                if($request->has('project_id')){
                    
            
                    $project = Project::find($request->project_id);
                    
                    $begin = ($project->start);
                    $end = ($project->finish);
                    $tasks = Task::where('project_id', '=', $request->project_id)
                    ->join('tickets', 'tickets.task_id', '=', 'tasks.id')
                    ->where('tickets.assignee_id',$user)
                    ->orderBy('index', 'asc')

                        ->whereRaw("start_date BETWEEN CAST('$begin' AS DATE) AND CAST('$end' AS DATE)")

                        ->get();
                        $tasktotal=Task::where('project_id', '=', $request->project_id)->count();
                
                        
            
                    }else{
                    $firstdate =Project::select('start')->min('start');
                    $lastdate =Project::select('finish')->max('finish');
                    $begin = ($firstdate);
                    $end = ($lastdate);

                    $tasks = Task::join('tickets', 'tickets.task_id', '=', 'tasks.id')
                    ->where('tickets.assignee_id',$user)->orderBy('index', 'asc')
                        ->whereRaw("start_date BETWEEN CAST('$begin' AS DATE) AND CAST('$end' AS DATE)")
                        ->get();
                        $tasktotal=Task::all()->count();

                    }
            
            
                    $countoverdues = 0;
                    $countonpprogress=0;
                    $countcompleted=0;
                    $countcompletedbefore=0;
                    $type=array();
                    $data=array();
                    foreach ($tasks as $task) {
                     
        
                        $duedate = new DateTime(date('Y-m-d', strtotime($task->due_date)));
                        $today = new DateTime(Carbon::now()->format('Y-m-d'));
        
                        if ($duedate < $today && $task->progress != 100) {
                            $countoverdues++;
                        }
                        if ($duedate < $today && $task->progress == 100) {
                            $countcompleted++;
                        }
                        if ($duedate > $today && $task->progress == 100) {
                            $countcompletedbefore++;
                        }
                        if ($duedate > $today && $task->progress != 100) {
                            $countonpprogress++;
                        }
                     
                    }
                     
                    // if($countoverdues>0){
                    //     array_push($type, 'OverDue');
                    //     array_push($data, array('value'=>$countoverdues));
                    //     }
                    //     if($countcompleted>0){
                    //     array_push($type, 'Completed');
                    //     array_push($data,  array('value'=>$countcompleted));
                    //     }
                    //     if($countonpprogress>0){
                    //     array_push($type, 'On Progress');
                    //     array_push($data, array('value'=>$countonpprogress));
                    //     }
                    //     if($countcompletedbefore>0){
                    //     array_push($type, 'Completed Before Date');    
                    //     array_push($data, array('value'=>$countcompletedbefore));
                    //     }   
                    $totalperusercompleted=$countonpprogress+$countcompletedbefore;
                    $userName=User::find($user);
                        array_push($type, 'Completed');
                        array_push($data,  array('value'=>$totalperusercompleted));
                        array_push($type, 'OverDue');
                        array_push($data, array('value'=>$countoverdues));
                        array_push($userResponsetime,array('user'=>$userName->name,'type' =>$type ,'data' =>$data));
                        $countoverdues = 0;
                        $countonpprogress=0;
                        $countcompleted=0;
                        $countcompletedbefore=0;
                        $type=array();
                        $data=array();
                  

                }
               

    return response()->json($userResponsetime);

}


/////////

}

?>
