<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Holiday;
use App\Models\Contract;
use App\Models\Project;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;

/**
 * Modulo de projectos
 *
 * @Resource("Group Projects")
 */
class ForecastController extends Controller
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

    public function index()
    {

    }

    public function team(Request $request)
    {


        $request = (object)$request->all();

        $contract = Contract::find($request->contract_id);
        $result = array();

        $contracts = '';
        $i = 0;
        $contractsarr = explode(',', $request->contract_id);
        foreach ($contractsarr as $cont) {
            if ($i == 0) {
                $contracts .= $cont;
            } else {
                $contracts .= ',' . $cont;
            }

            $i++;
        }


        DB::enableQueryLog();
        $query_params = [];

        $query = "
         SELECT       
          u.id as user_id,cr.currency_id,
            cr.rate as amount,   
                           
           IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
           and exchange_rates.currency_id=cr.currency_id limit 1),NULL) as exhange_value, 
                     
           IFNULL((select value from costs where costs.company_id= $request->company_id  and costs.country_id = cr.country_id 
            and costs.city_id = cr.city_id and costs.seniority_id = cr.seniority_id and costs.project_role_id =cr.project_role_id
              and costs.workplace = cr.workplace and costs.currency_id = cr.currency_id LIMIT 1 ),0) AS cost,   
                      
                      
           IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
           and exchange_rates.currency_id=cr.currency_id limit 1),NULL) as exhange_value_cost                             
                     
           FROM project_resources cr
            JOIN users as u ON cr.user_id =u.id 
           LEFT  JOIN rates as rt ON rt.id =cr.rate_id
            JOIN team_users ON team_users.user_id =u.id 
            JOIN projects ON team_users.project_id =projects.id 
            JOIN cities ON cr.city_id =cities.id 
            JOIN countries as ctry ON cr.country_id =ctry.id 
             JOIN contracts ON contracts.project_id =projects.id 
            WHERE
            contracts.customer_id = $request->customer_id
            AND team_users.project_id = $request->project_id
            AND cr.project_id = $request->project_id
           
            and contracts.id IN ($contracts)
                 group by cr.id  
        
      ";

        $data = DB::select($query, $query_params);


        $company = $request->company_id;
        $customer_id = $request->customer_id;
        $project = $request->project_id;
        $contractResourcesResult = array();
        $begin = new DateTime($request->period_from);
        $end = new DateTime($request->period_to);
        $end->setTime(0, 0, 1);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($data as $contractResource) {
            $totaluser = 0;
            $absents_hours = 0;
            $hours_available = 0;
            $holidays_hours = 0;
            $hours_asigned = 0;
            $replacements_hours = 0;
            $efective_capacity = 0;
            $array = $contractResource;




           // foreach ($period as $dt) {
                $requestSend = array('project' => $project, 'customer' => $customer_id, 'period_to' => $request->period_to, 'period_from' =>
                    $request->period_from, 'user_id' => $contractResource->user_id, 'company' => $company);
                $requestSend = new \Illuminate\Http\Request($requestSend);
                $workingHoursFromApi = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

                $workingHoursFromApi = $workingHoursFromApi->getData();
                $workingHoursFromApi = $workingHoursFromApi->data;
                if(!empty($workingHoursFromApi))
                {   
                if (is_numeric($workingHoursFromApi->working_hours) && $workingHoursFromApi->working_hours >= 0) {
                    $totaluser = $totaluser + $workingHoursFromApi->working_hours;
                }
                if ($workingHoursFromApi->hours_available >= 0) {
                    $hours_available = $hours_available + $workingHoursFromApi->hours_available;

                }

                if ($workingHoursFromApi->efective_capacity >= 0) {
                    $efective_capacity = $efective_capacity + $workingHoursFromApi->efective_capacity;

                }

                if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                    $holidays_hours = $holidays_hours + $workingHoursFromApi->working_hours;
                } else {
                    $holidays_hours = $holidays_hours + $workingHoursFromApi->holidays_hours;
                }

                $absents_hours = $absents_hours + $workingHoursFromApi->absents_hours;

                $hours_asigned = $hours_asigned + $workingHoursFromApi->hours_asigned;
                $replacements_hours = $replacements_hours + $workingHoursFromApi->replacements_hours;

                }

            $array->working_hours = $totaluser;
            $array->absents_hours = $absents_hours;
            $array->replacements_hours = $replacements_hours;
            $array->holidays_hours = $holidays_hours;
            $array->hours_available = $hours_available;
            $array->hours_asigned = $hours_asigned;
            $array->efective_capacity = $efective_capacity;

            array_push($contractResourcesResult, $array);
        }


        //var_dump($data);
        $total = 0;
        $total_cost = 0;
        $total_real_hours = 0;
        $invoice_currency_exchange = ExchangeRate::where('currency_id', $request->currency_id)->
        where('company_id', $request->company_id)->first();

        foreach ($contractResourcesResult as $datum) {

            $sum = isset($datum->hours_available) ? $datum->hours_available : 0;
            $total_real_hours = $total_real_hours+ $sum;
            $exchangeresult = exchange($datum, $invoice_currency_exchange);

            $rate = $exchangeresult['rate'];
            $cost = $exchangeresult['cost'];

            $total = $total + ($sum * $rate);
            $total_cost = $total_cost + ($sum * $cost);
        }

        $real_revenue = $total;
        $result['total_real_hours'] = $total_real_hours;
        $result['real_revenue_nf'] = $real_revenue;
        $result['real_revenue'] = number_format($total, 2, ',', '.');
        $real_cost = $total_cost;
        $result['real_cost_nf'] = $real_cost;
        $result['real_cost'] = number_format($total_cost, 2, ',', '.');

        $query = "
         SELECT       
         u.currency_id,   u.country_id, 
        offices.hours_by_day,         
         u.qty,          
          u.rate,                     
            
          IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
          and exchange_rates.currency_id=u.currency_id limit 1),NULL) as exhange_value,          
          IFNULL((select value from costs where costs.company_id= $request->company_id  and costs.country_id = u.country_id 
          and costs.city_id = u.city_id and costs.seniority_id = u.seniority_id and costs.project_role_id =u.project_role_id
          and costs.workplace = u.workplace and costs.currency_id = u.currency_id LIMIT 1 ),0) AS cost,             
                        
                 IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
           and exchange_rates.currency_id=u.currency_id limit 1),NULL) as exhange_value_cost
          
                           
            FROM contract_resources u
            JOIN contracts ctr ON ctr.id = u.contract_id
            JOIN offices ON offices.id = u.office_id
            LEFT JOIN rates as rat ON rat.id = u.rate_id
            JOIN projects ON ctr.project_id = projects.id 
            WHERE  projects.customer_id = $request->customer_id
            AND projects.id = $request->project_id
            and ctr.id IN ($contracts)
           group by u.id
           
      ";

        $data = DB::select($query, $query_params);

        $total = 0;


        $total_planned_hours =0;
        $project = Project::find($request->project_id);
        foreach ($data as $datum) {
            $totaluser=0;
            // $begin = new DateTime($request->period_from);
            // $end = new DateTime($request->period_to);
            // $end->setTime(0, 0, 1);
            // $interval = DateInterval::createFromDateString('1 day');
            // $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $dow = $dt->format('w');
                if (!in_array($dow, json_decode($project->holy_days)) && !Holiday::where('country_id', $datum->country_id)
                        ->where('date', $dt->format('Y-m-d'))->exists()
                ) {
                    $totaluser = $totaluser + $datum->hours_by_day;
                    $total_planned_hours = $total_planned_hours+$totaluser;
                }
            }

            $qty = isset($datum->qty) ? $datum->qty : 0;
            // echo $sum;
            // $invoice_currency_exchange = ExchangeRate::where('currency_id', $request->currency_id)->
            // where('company_id', $request->company_id)->first();
            // echo $invoice_currency_exchange;
            $datum->amount = $qty * ($totaluser * $datum->rate);
            $datum->cost = $qty * ($totaluser * $datum->cost);

            $exchangeresult = exchange($datum, $invoice_currency_exchange);

            $rate = $exchangeresult['rate'];
            $cost = $exchangeresult['cost'];

            $total = $total + $rate;
            $total_cost = $total_cost + $cost;
        }


        $planned_revenue = $total;
        $result['total_planned_hours'] = $total_planned_hours;
        $result['planned_revenue'] = number_format($total, 2, ',', '.');
        $result['planned_revenue_nf'] = $planned_revenue;
        $planned_cost = $total_cost;
        $result['planned_cost'] = number_format($total_cost, 2, ',', '.');
        $result['planned_cost_nf'] = $planned_cost;

        $result['diference_revenue'] = number_format(($planned_revenue - $real_revenue), 2, ',', '.');
        $diference_cost = $planned_cost - $real_cost;
        $result['diference_cost'] = number_format($diference_cost, 2, ',', '.');


        $planed_profit = $planned_revenue - $planned_cost;
        $result['planed_profit'] = number_format($planed_profit, 2, ',', '.');
        $real_profit = $real_revenue - $real_cost;
        $result['real_profit_nf'] =$real_profit;
        $result['real_profit'] = number_format($real_profit, 2, ',', '.');

        $diference_profit = abs($planed_profit) - $real_profit;
        $result['diference_profit'] = number_format($diference_profit, 2, ',', '.');

        $result['planed_profit_class'] = $planed_profit < 0 ? 'red' : 'green';
        $result['real_profit_class'] = $real_profit < 0 ? 'red' : 'green';
        $result['diference_profit_class'] = $diference_profit < 0 ? 'red' : 'green';


        $result['planed_profit_percent'] = number_format($planned_cost <= 0 ? 100 : ($planed_profit / $planned_cost) * 100, 1, ',', '.');
        $result['real_profit_percent'] = number_format($real_cost <= 0 ? 100 : ($real_profit / $real_cost) * 100, 1, ',', '.');
        $result['diference_profit_percent'] = number_format($real_profit <= 0 ? 100 : ($diference_profit / $real_profit) * 100, 1, ',', '.');


        //dd(DB::getQueryLog());

        return response()->json(array('data' => $result), 200);
    }


    public function services(Request $request)
    {


        $result = array();
        $request = (object)$request->all();

        $table = 'project_services';
        $dataReal = $this->realQuery($table, $request);
        $table = 'contract_services';
        $dataPlanned = $this->plannedQuery($table, $request);


        //  var_dump($dataPlanned);

        $result = $this->processData($dataPlanned, $dataReal, $request);


        //dd(DB::getQueryLog());

        return response()->json(array('data' => $result), 200);
    }


    public function materials(Request $request)
    {


        $result = array();
        $request = (object)$request->all();
        $table = 'project_materials';
        $dataReal = $this->realQuery($table, $request);
        $table = 'contract_materials';
        $dataPlanned = $this->plannedQuery($table, $request);


        $result = $this->processData($dataPlanned, $dataReal, $request);


        //dd(DB::getQueryLog());

        return response()->json(array('data' => $result), 200);
    }


    public function expenses(Request $request)
    {


        $result = array();
        $request = (object)$request->all();

        $table = 'project_expenses';
        $dataReal = $this->realQuery($table, $request);
        $table = 'contract_expenses';
        $dataPlanned = $this->plannedQuery($table, $request);


        $result = $this->processData($dataPlanned, $dataReal, $request);


        return response()->json(array('data' => $result), 200);
    }


    private function realQuery($table, $request)
    {

        $contracts = '';
        $i = 0;
        $contractsarr = explode(',', $request->contract_id);
        foreach ($contractsarr as $cont) {
            if ($i == 0) {
                $contracts .= $cont;
            } else {
                $contracts .= ',' . $cont;
            }

            $i++;
        }


        DB::enableQueryLog();
        $query_params = [];
        //IFNULL(( select SUM(workinghours_to-workinghours_from) from contracts where project_id=6),0) AS workinghours_contract,

        $query = "
         SELECT       
          cr.amount, cr.cost,   cr.frequency,  cr.currency_id,   
             IFNULL(TIMESTAMPDIFF(DAY, '$request->period_from','$request->period_to')+1,0) as days,
          IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
          and exchange_rates.currency_id=cr.currency_id limit 1),NULL) as exhange_value
          FROM $table cr                     
          JOIN projects ON cr.project_id =projects.id
               JOIN contracts ON contracts.project_id =projects.id 
          WHERE
          projects.customer_id = $request->customer_id      
          and contracts.id IN ($contracts)
          AND cr.project_id = $request->project_id
                             
        group by cr.id
      ";

        //dd(DB::getQueryLog());
        return DB::select($query, $query_params);
    }

    private function plannedQuery($table, $request)
    {

        $contracts = '';
        $i = 0;
        $contractsarr = explode(',', $request->contract_id);
        foreach ($contractsarr as $cont) {
            if ($i == 0) {
                $contracts .= $cont;
            } else {
                $contracts .= ',' . $cont;
            }

            $i++;
        }


        DB::enableQueryLog();
        $query_params = [];
        //IFNULL(( select SUM(workinghours_to-workinghours_from) from contracts where project_id=6),0) AS workinghours_contract,

        $query = "
         SELECT       
          cr.amount,cr.cost,  cr.frequency,    cr.currency_id, 
             IFNULL(TIMESTAMPDIFF(DAY, '$request->period_from','$request->period_to')+1,0) as days,
          IFNULL((select  value from exchange_rates where exchange_rates.company_id= $request->company_id 
          and exchange_rates.currency_id=cr.currency_id limit 1),NULL) as exhange_value
          FROM $table cr                     
          JOIN contracts ON cr.contract_id =contracts.id 
          JOIN projects ON contracts.project_id =projects.id 
          WHERE
          projects.customer_id = $request->customer_id   
              and contracts.id IN ($contracts)
          AND projects.id = $request->project_id
        
          
        group by cr.id
           
      ";

        //dd(DB::getQueryLog());

        return DB::select($query, $query_params);
    }

    private function processData($dataPlanned, $dataReal, $request)
    {


        $total = 0;
        $total_cost = 0;
        $monthly = 'monthly';


        $invoice_currency_exchange = ExchangeRate::where('currency_id', $request->currency_id)->
        where('company_id', $request->company_id)->first();

        foreach ($dataReal as $datum) {

            $exchangeresult = exchange($datum, $invoice_currency_exchange);
            $frequency = isset($datum->frequency) && $datum->frequency != null && $datum->frequency != '' ? $datum->frequency : $monthly;

            $days = $datum->days;
            switch ($frequency) {
                case 'semester':
                    $multi = intval($days / 182);
                    break;
                case 'anualy':
                    $multi = intval($days / 365);
                    break;
                case 'bimonthly':
                    $multi = intval($days / 60);
                    break;
                case 'quarterly':
                    $multi = intval($days / 90);
                    break;
                case 'monthly':
                    $multi = intval($days / 30);
                    break;
                case 'weekly':
                    $multi = intval($days / 7);
                    break;
                default:
                    $multi = intval($days / 30);


                    break;
            }
            if ($multi < 1) {
                $multi = 1;
            }

            // echo $days."  ";

            $rate = $exchangeresult['rate'] * $multi;
            $cost = $exchangeresult['cost'] * $multi;


            $total = $total + $rate;
            $total_cost = $total_cost + $cost;
        }

        $real_revenue = $total;
        $result['real_revenue'] = number_format($total, 2, ',', '.');
        $result['real_revenue_nf'] = $real_revenue;

        $real_cost = $total_cost;
        $result['real_cost'] = number_format($total_cost, 2, ',', '.');
        $result['real_cost_nf'] = $real_cost;

        $invoice_currency_exchange = ExchangeRate::where('currency_id', $request->currency_id)->
        where('company_id', $request->company_id)->first();

        $total = 0;
        $total_cost = 0;
        foreach ($dataPlanned as $datum) {


            $exchangeresult = exchange($datum, $invoice_currency_exchange);
            $frequency = isset($datum->frequency) && $datum->frequency != null && $datum->frequency != '' ? $datum->frequency : $monthly;

            $days = $datum->days;

            switch ($frequency) {
                case 'semester':
                    $multi = intval($days / 182);
                    break;
                case 'anualy':
                    $multi = intval($days / 365);
                    break;
                case 'bimonthly':
                    $multi = intval($days / 60);
                    break;
                case 'quarterly':
                    $multi = intval($days / 90);
                    break;
                case 'monthly':
                    $multi = intval($days / 30);
                    break;
                case 'weekly':
                    $multi = intval($days / 7);
                    break;
                default:
                    $multi = intval($days / 30);
            }

            if ($multi < 1) {
                $multi = 1;
            }


            $rate = $exchangeresult['rate'] * $multi;
            $cost = $exchangeresult['cost'] * $multi;


            $total = $total + $rate;
            $total_cost = $total_cost + $cost;
        }

        $planned_revenue = $total;
        $result['planned_revenue'] = number_format($total, 2, ',', '.');
        $result['planned_revenue_nf'] = $planned_revenue;
        $planned_cost = $total_cost;
        $result['planned_cost'] = number_format($total_cost, 2, ',', '.');
        $result['planned_cost_nf'] = $planned_cost;


        $result['diference_revenue'] = number_format(($planned_revenue - $real_revenue), 2, ',', '.');
        $diference_cost = $planned_cost - $real_cost;
        $result['diference_cost'] = number_format($diference_cost, 2, ',', '.');


        $planed_profit = $planned_revenue - $planned_cost;
        $result['planed_profit'] = number_format($planed_profit, 2, ',', '.');
        $real_profit = $real_revenue - $real_cost;
        $result['real_profit'] = number_format($real_profit, 2, ',', '.');
        $result['real_profit_nf'] =$real_profit;
        $diference_profit = abs($planed_profit) - $real_profit;
        $result['diference_profit'] = number_format($diference_profit, 2, ',', '.');

        $result['planed_profit_class'] = $planed_profit < 0 ? 'red' : 'green';
        $result['real_profit_class'] = $real_profit < 0 ? 'red' : 'green';
        $result['diference_profit_class'] = $diference_profit < 0 ? 'red' : 'green';


        $result['planed_profit_percent'] = number_format($planned_cost <= 0 ? 100 : ($planed_profit / $planned_cost) * 100, 1, ',', '.');
        $result['real_profit_percent'] = number_format($real_cost <= 0 ? 100 : ($real_profit / $real_cost) * 100, 1, ',', '.');
        $result['diference_profit_percent'] = number_format($real_profit <= 0 ? 100 : ($diference_profit / $real_profit) * 100, 1, ',', '.');

        return $result;
    }


}

?>