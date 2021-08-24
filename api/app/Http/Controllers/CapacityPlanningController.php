<?php

namespace App\Http\Controllers;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\CapacityPlanning;
use Transformers\CapacityPlanningTransformer;
use DB;

/**
 * Modulo de CapacityPlanning
 *
 * @Resource("Group CapacityPlanning")
 */
class CapacityPlanningController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("capacity_planning{?project_id,start_date,end_date,workgroup_id}")
	 * @Parameters({
     *      @Parameter("project_id", description="ID de proyecto", default=1),
     *      @Parameter("start_date", description="Feche de inicio del reporte", default=1),
     *      @Parameter("end_date", description="Feche de fin del reporte", default=1),
 	 *      @Parameter("workgroup_id", description="Opcional. Reporte solo para el workgroup indicado", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = CapacityPlanning::select('*');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$capacityPlanning = $query->get();
		return $this->response->collection($capacityPlanning, new CapacityPlanningTransformer);
  	}

  	/*public function datatables(Request $request)
  	{
  		$query = DB::table('project_resources')
                    ->select(
                    	'project_resources.project_id',
                    	'project_resources.user_id',
                    	'project_resources.rate_id',
                        'users.name AS resource_name',
                        'rates.value AS rate_value'
                    );


        $query->join('users', 'users.id', '=', 'project_resources.user_id');
        $query->join('rates', 'rates.id', '=', 'project_resources.rate_id');
        $query->where('project_resources.project_id', $request->project_id);
  		// $query->where('project_resources.task_id', $request->task_id);

		$capacityPlanningRows = $query->get()->toArray();

        foreach ($capacityPlanningRows as $capacityPlanningRow)
        {

        }

  		return Datatables::of($capacityPlanning)->make(true);
  	}*/


    public function datatables(Request $request)
    {

        // $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $company = $request['company'];
        $from = $request['period_from'];
        $to = $request['period_to'];
        $from_sprint = $request['sprint_from'];
        $to_sprint = $request['sprint_to'];
        $customer_id = $request['customer'];
        $project = $request['project'];
        $workgroup_id = $request['workgroup'];
        $datatbl = $request['dt'];
        $query_params = [$customer_id, $project];

        $query = "
         SELECT 
            distinct(u.id) as user_id, u.id,u.name , projects.id as project_id        
            FROM users u
            JOIN team_users ON team_users.user_id =u.id 
            JOIN projects ON team_users.project_id =projects.id 
            JOIN cities ON u.city_id =cities.id 
            JOIN countries as ctry ON cities.country_id =ctry.id 
            WHERE
            customer_id = $customer_id
            AND team_users.project_id = $project   
        ";

        if(!empty($workgroup_id)){
            $query_params[]=$workgroup_id;
            $query.='  AND u.workgroup_id = ?';
        }



        $data = DB::select($query, $query_params);

        $contractResourcesResult = array();
        $contractResourcesResult_sprint = array();
        foreach ($data as $contractResource){
            $totaluser = 0;
            $absents_hours = 0;
            $hours_available = 0;
            $holidays_hours = 0;
            $hours_asigned = 0;
            $replacements_hours = 0;
            $efective_capacity = 0;
            $array = $contractResource;

            $begin = new DateTime($from);
            $end = new DateTime($to);
            $end->setTime(0, 0, 1);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            if($from_sprint!='' && $to_sprint!='')
            {
                $begin_sprints = new DateTime($from_sprint);
                $end_sprints = new DateTime($to_sprint);
                $end_sprints->setTime(0, 0, 1);
                $interval_sprints = DateInterval::createFromDateString('1 day');
                $period_sprints = new DatePeriod($begin_sprints, $interval_sprints, $end_sprints);
            }

            if(($from_sprint!='' && $to_sprint!='') && ($from=='' && $to==''))
            {


                // foreach ($period_sprint as $dt) {
                    // $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'sprint_to' => $dt->format("Y-m-d"), 'sprint_from' => $dt->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);
                $begin_sprint = new DateTime($from_sprint);
                $end_sprint = new DateTime($to_sprint);

                $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'sprint_to' => $end_sprint->format("Y-m-d"), 'sprint_from' => $begin_sprint->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);

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
                        $hours_available= $hours_available + $workingHoursFromApi->hours_available;
                    }

                    if ($workingHoursFromApi->efective_capacity >= 0) {
                        $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;
                    }

                    if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                    }else{
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                    }

                    $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;
                    $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                    $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
                }
            // }
            }
        
            if(($from_sprint=='' && $to_sprint=='') && ($from!='' && $to!=''))
            {

                // foreach ($period as $dt) {
                $begin = new DateTime($from);
                $end = new DateTime($to);
             
                $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $end->format("Y-m-d"), 'period_from' => $begin->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);

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
                        $hours_available= $hours_available + $workingHoursFromApi->hours_available;

                    }

                    if ($workingHoursFromApi->efective_capacity >= 0) {
                        $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;

                    }

                    if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                    }else{
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                    }

                    $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;

                    $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                    $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
                }
            // }
            }

            if(($from_sprint!='' && $to_sprint!='') && ($from!='' && $to!=''))
            {
                // foreach ($period as $dt) {
                    // foreach ($period_sprint as $dt_sprint) {
                        // foreach ($period as $dt) {
                $begin = new DateTime($from);
                $end = new DateTime($to);
                $begin_sprint = new DateTime($from_sprint);
                $end_sprint = new DateTime($to_sprint);

             
               // if(in_array($begin->format("Y-m-d"), (array)$period_sprints)){
                $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $end->format("Y-m-d"), 'period_from' => $begin->format("Y-m-d"),  'sprint_to' => $end_sprint->format("Y-m-d"), 'sprint_from' => $begin_sprint->format("Y-m-d"), 'user_id' => $contractResource->user_id, 'company' => $company);
                // }else{
                //     $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $dt->format("Y-m-d"), 'period_from' =>
                //         $dt->format("Y-m-d"),  'user_id' => $contractResource->user_id, 'company' => $company);
                // }

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
                        $hours_available= $hours_available + $workingHoursFromApi->hours_available;
                    }

                    if ($workingHoursFromApi->efective_capacity >= 0) {
                        $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;
                    }

                    if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                    }else{
                        $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                    }

                    $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;
                    $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                    $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
                }
            // }
            //}
            }

            $array->working_hours= $totaluser;
            $array->absents_hours=$absents_hours;
            $array->replacements_hours= $replacements_hours;
            $array->holidays_hours= $holidays_hours;
            $array->hours_available= $hours_available;
            $array->hours_asigned= $hours_asigned;
            $array->efective_capacity= $efective_capacity;

            array_push($contractResourcesResult, $array);
        }

       
        return Datatables::of($data)->make(true);
        
    }

    public function pdf(Request $request)
    {

       // $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());


        $company = $request['company'];
        $from = $request['period_from'];
        $to = $request['period_to'];
        $from_sprint = $request['sprint_from'];
        $to_sprint = $request['sprint_to'];
        $customer_id = $request['customer'];
        $project = $request['project'];
        $workgroup_id = $request['workgroup'];
        $query_params = [$customer_id, $project];

        $query = "
         SELECT 
           distinct(u.id) as user_id, u.id,u.name , projects.id as project_id        
           FROM users u
            JOIN team_users ON team_users.user_id =u.id 
            JOIN projects ON team_users.project_id =projects.id 
            JOIN cities ON u.city_id =cities.id 
            JOIN countries as ctry ON cities.country_id =ctry.id 
            WHERE
            customer_id = ?
            AND team_users.project_id = ?
           
      ";

        if(!empty($workgroup_id)){
            $query_params[]=$workgroup_id;
            $query.='  AND u.workgroup_id = ?';
        }



        $data = DB::select($query, $query_params);

        $contractResourcesResult = array();
        $contractResourcesResult_sprint = array();
        foreach ($data as $contractResource){
            $totaluser = 0;
            $absents_hours = 0;
            $hours_available = 0;
            $holidays_hours = 0;
            $hours_asigned = 0;
            $replacements_hours = 0;
            $efective_capacity = 0;
            $array = $contractResource;

            $begin = new DateTime($from);
            $end = new DateTime($to);
            $end->setTime(0, 0, 1);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);
            
            

  
    if($from_sprint!='' && $to_sprint!='')
        {
                $begin_sprints = new DateTime($from_sprint);
                $end_sprints = new DateTime($to_sprint);
                $end_sprints->setTime(0, 0, 1);
                $interval_sprints = DateInterval::createFromDateString('1 day');
                $period_sprints = new DatePeriod($begin_sprints, $interval_sprints, $end_sprints);


        }

    


          /////////////////////////////////////////////////////////////////////7


    if(($from_sprint!='' && $to_sprint!='') && ($from=='' && $to==''))
        {


          //  foreach ($period_sprint as $dt) {
            
            
        //     $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'sprint_to' => $dt->format("Y-m-d"), 'sprint_from' =>
            //        $dt->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);
    $begin_sprint = new DateTime($from_sprint);
    $end_sprint = new DateTime($to_sprint);

     $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'sprint_to' => $end_sprint->format("Y-m-d"), 'sprint_from' =>
                    $begin_sprint->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);

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
                    $hours_available= $hours_available + $workingHoursFromApi->hours_available;

                }

                if ($workingHoursFromApi->efective_capacity >= 0) {
                    $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;

                }

                if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                }else{
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                }

                $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;

                $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
        }
          //  }
            
        }
        


    if(($from_sprint=='' && $to_sprint=='') && ($from!='' && $to!=''))
        {


            //foreach ($period as $dt) {
            $begin = new DateTime($from);
    $end = new DateTime($to);

             
                $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $end->format("Y-m-d"), 'period_from' =>
                    $begin->format("Y-m-d"),'user_id' => $contractResource->user_id, 'company' => $company);


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
                    $hours_available= $hours_available + $workingHoursFromApi->hours_available;

                }

                if ($workingHoursFromApi->efective_capacity >= 0) {
                    $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;

                }

                if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                }else{
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                }

                $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;

                $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
        }
            //}
            
        }
        
    
    
    if(($from_sprint!='' && $to_sprint!='') && ($from!='' && $to!=''))
        {


           // foreach ($period as $dt) {
            
         //   foreach ($period_sprint as $dt_sprint) {

                        //foreach ($period as $dt) {
            $begin = new DateTime($from);
    $end = new DateTime($to);
            $begin_sprint = new DateTime($from_sprint);
    $end_sprint = new DateTime($to_sprint);

             

               // if(in_array($begin->format("Y-m-d"), (array)$period_sprints)){
                $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $end->format("Y-m-d"), 'period_from' =>
                    $begin->format("Y-m-d"),  'sprint_to' => $end_sprint->format("Y-m-d"), 'sprint_from' =>
                    $begin_sprint->format("Y-m-d"), 'user_id' => $contractResource->user_id, 'company' => $company);
          /*  }else{
                  $requestSend = array('project' => $contractResource->project_id, 'customer' => $customer_id, 'period_to' => $dt->format("Y-m-d"), 'period_from' =>
                    $dt->format("Y-m-d"),  'user_id' => $contractResource->user_id, 'company' => $company);
            }*/


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
                    $hours_available= $hours_available + $workingHoursFromApi->hours_available;

                }

                if ($workingHoursFromApi->efective_capacity >= 0) {
                    $efective_capacity= $efective_capacity + $workingHoursFromApi->efective_capacity;

                }

                if ($workingHoursFromApi->holidays_hours > $workingHoursFromApi->working_hours) {
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->working_hours;
                }else{
                    $holidays_hours= $holidays_hours + $workingHoursFromApi->holidays_hours;
                }

                $absents_hours= $absents_hours + $workingHoursFromApi->absents_hours;

                $hours_asigned= $hours_asigned + $workingHoursFromApi->hours_asigned;
                $replacements_hours= $replacements_hours + $workingHoursFromApi->replacements_hours;
        }
            //}
            //}
        }

        ///////////////////////////////////////////////////////////////////////////7
       

 
            $array->working_hours= $totaluser;
            $array->absents_hours=$absents_hours;
            $array->replacements_hours= $replacements_hours;
            $array->holidays_hours= $holidays_hours;
            $array->hours_available= $hours_available;
            $array->hours_asigned= $hours_asigned;
            $array->efective_capacity= $efective_capacity;

            array_push($contractResourcesResult, $array);
        }

        
        return $data;
    }
}

?>
