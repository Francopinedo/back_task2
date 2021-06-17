<?php

namespace App\Http\Controllers;

use App\City;
use App\Country;
use App\Customer;
use App\Holiday;
use App\Models\Absence;
use App\Models\AdditionalHour;
use App\Models\Project;
use App\Models\User;
use App\Models\WorkingHour;
use App\Models\Sprints;

use App\Office;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\WorkingHourTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de WorkingHour
 *
 * @Resource("Group WorkingHour")
 */
class WorkingHourController extends Controller
{

    /**
     * Obtener
     *
     * @Get("working_hours{?project_id}")
     * @Parameters({
     *      @Parameter("project_id", description="ID del proyecto", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = WorkingHour::with('user');

        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $workingHours = $query->get();

        return $this->response->collection($workingHours, new WorkingHourTransformer);
    }

    /**
     * Crear
     *
     * @Post("working_hours")
     * @Request({
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('project_id') || !$request->has('user_id') || !$request->has('date') || !$request->has('hours')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $workingHour = WorkingHour::create($data);

        if ($workingHour) {
            return $this->response->item($workingHour, new WorkingHourTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("working_hours/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $workingHour = WorkingHour::findOrFail($id);

        return $this->response->item($workingHour, new WorkingHourTransformer);
    }

    /**
     * Editar
     *
     * @Patch("working_hours/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $workingHour = WorkingHour::find($id);

        if ($workingHour == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $workingHour->update($data);

        if ($workingHour) {
            return $this->response->item($workingHour, new WorkingHourTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("working_hours/{id}")
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
        $workingHour = WorkingHour::find($id);

        if ($workingHour == NULL) {
            return $this->response->error('No existe', 450);
        }

        $workingHour->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("working_hours/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('working_hours')
            ->select(
                'working_hours.id',
                'working_hours.project_id',
                'working_hours.user_id',
                'working_hours.date',
                'working_hours.hours',
                'users.name AS user_name')
            ->join('users', 'users.id', '=', 'working_hours.user_id');

        if ($request->has('user_id')) {
            $query->where('working_hours.user_id', $request->user_id);
        }

        $workingHours = $query->get();

        return Datatables::of($workingHours)->make(true);
    }

    /**
     * Genera workingHours
     *
     * @Get("working_hours/generate/{user_id}/{project_id}")
     * @Parameters({
     *      @Parameter("user_id", type="integer", required=true, description="ID de usuario", default=null),
     *      @Parameter("project_id", type="integer", required=true, description="ID de proyecto", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     * })
     */
    public function generate($projectId)
    {
        $project = Project::find($projectId);
        $customer = Customer::find($project->customer_id);

        $users = User::select('users.id')
            ->join('team_users', 'team_users.user_id', '=', 'users.id')
            ->join('teams', 'teams.id', '=', 'team_users.team_id')
            ->where('teams.project_id', $projectId)
            ->whereNotNull('users.office_id')
            ->get();
        // reviso si hay un country
        if (!empty($customer->city_id)) {
            $city = City::find($customer->city_id);
            $country = Country::find($city->country_id);
        }

        // Genero dias basicos del projecto
        $begin = new DateTime($project->start);
        $end = new DateTime($project->finish);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($users as $user) {
            $user = User::find($user->id);
            $office = Office::find($user->office_id);
            $hours_by_day = !empty($office->hours_by_day) ? $office->hours_by_day : 8;

            // /Genero dias basicos del projecto

            // reviso si tuvo una ausencias
            $absences = Absence::where('user_id', $user->id)->where('project_id', $projectId)->get();

            // creo un array de los dias de ausencia
            $absenceDays = [];
            foreach ($absences as $absence) {
                $beginAbsence = new DateTime($absence->from);
                $endAbsence = new DateTime($absence->to);

                // $intervalAbsence = DateInterval::createFromDateString('1 day');
                $periodAbsence = new DatePeriod($beginAbsence, $interval, $endAbsence);

                foreach ($periodAbsence as $dayAbsence) {
                    $absenceDays[] = $dayAbsence->format('Y-m-d');
                }
            }

            foreach ($period as $day) {
                $generate = true;
                $addHours = 0;

                // reviso que no sea feriado
                if (isset($country)) {
                    if (Holiday::where('country_id', $country->id)->where('date', $day->format('Y-m-d'))->exists()) {
                        //$generate = false;
                    }
                }

                // reviso si este dia estuvo ausente
                if (in_array($day->format('Y-m-d'), $absenceDays)) {
                    //$generate = false;
                }

                if ($additionalHour = AdditionalHour::where('user_id', $user->id)->where('project_id', $projectId)->where('date', $day->format('Y-m-d'))->first()) {
                    //$addHours = $additionalHour->hours;
                }

                $dow = $day->format('w');
                if (in_array($dow, json_decode($project->holy_days))) {
                    $generate = false;
                }
                if ($generate) {
                    $workingHour = WorkingHour::create([
                        'project_id' => $projectId,
                        'user_id' => $user->id,
                        'date' => $day->format('Y-m-d'),
                        'hours' => $hours_by_day + $addHours
                    ]);
                }
            }
        }

        return $this->response->noContent();
    }


    public function calculated(Request $request)
    {

        $company = $request['company'];
        $user_id = $request['user_id'];

        $from = $request['period_from'];
        $to = $request['period_to'];
        $sprint_from = $request['sprint_from'];
        $sprint_to = $request['sprint_to'];
        $customer_id = $request['customer'];
        $project = $request['project'];


        $query_params = [$customer_id, $project];
	$working_hours_query="";
	$where_sprints_query="";		
	if(($from!='' &&  $to!='') && ($sprint_from!='' && $sprint_to!='') )
	{
	$working_hours_query="  IFNULL((select sum(hours) from working_hours wh where wh.user_id = u.id and wh.project_id = $project and 
           wh.date BETWEEN CAST('$from' AS DATE) AND CAST('$to' AS DATE) AND 
           wh.date BETWEEN CAST('$sprint_from' AS DATE) AND CAST('$sprint_to' AS DATE)   ),0) as working_hours, ";
	$where_sprints_query=" JOIN sprints ON sprints.project_id =projects.id ";
	}
	if(($from=='' &&  $to=='') && ($sprint_from!='' && $sprint_to!='') )
	{
	$working_hours_query="  IFNULL((select sum(hours) from working_hours wh where wh.user_id = u.id and wh.project_id = $project and 
           wh.date BETWEEN CAST('$sprint_from' AS DATE) AND CAST('$sprint_to' AS DATE)   ),0) as working_hours, ";
	$where_sprints_query=" JOIN sprints ON sprints.project_id =projects.id ";
	}

	if(($from!='' &&  $to!='') && ($sprint_from=='' && $sprint_to=='') )
	{
	$working_hours_query="  IFNULL((select sum(hours) from working_hours wh where wh.user_id = u.id and wh.project_id = $project and 
           wh.date BETWEEN CAST('$from' AS DATE) AND CAST('$to' AS DATE) ),0) as working_hours, ";
	}

        $query = "
         SELECT
           distinct(u.id), u.name, 
          ".$working_hours_query." 
          IFNULL((select count(h.id) from holidays h where h.company_id = $company 
           AND h.date BETWEEN CAST('$from' AS DATE) AND CAST('$to' AS DATE) 
          and h.country_id=ctry.id ),0) as holidays, 
          IFNULL((select SUM(hours_by_day) from offices o where o.company_id = $company  and team_users.office_id = o.id ),0) as hours_by_day, 
          
          IFNULL((select holidays * hours_by_day),0) as holidays_hours, 
          
          (select count(ab.id) from absences ab where ab.user_id=u.id) as absents_number,
          
          IFNULL((SELECT SUM((SELECT TIMESTAMPDIFF(DAY ,'$from','$to')+1 FROM absences ab2 WHERE ab.id=ab2.id) )
           FROM absences ab WHERE ab.user_id=u.id and 
             '$from' BETWEEN CAST(ab.from AS DATE) 
           AND CAST(ab.to AS DATE) and '$to' BETWEEN CAST(ab.from AS DATE) AND CAST(ab.to AS DATE)
            ),0) as absents,
            
            IFNULL((select absents * hours_by_day),0) as absents_hours, 
            
            IFNULL((SELECT SUM((SELECT TIMESTAMPDIFF(DAY ,'$from','$to')+1 FROM replacements ab2 WHERE ab.id=ab2.id) )
           FROM replacements ab WHERE ab.user_id=u.id and
          '$from' BETWEEN CAST(ab.from AS DATE) 
           AND CAST(ab.to AS DATE) and '$to' BETWEEN CAST(ab.from AS DATE) AND CAST(ab.to AS DATE)
          ),0) as replacements,          
          
           (select replacements * hours_by_day) as replacements_hours, 
                          
              
            IFNULL((select  (working_hours ) - ( absents_hours + holidays_hours ) ),0) as hours, 
            IFNULL((select  (working_hours ) - ( absents_hours + holidays_hours + replacements_hours ) ),0) as hours_available, 
        
           IFNULL((select sum(t2.estimated_hours) - sum(t2.burned_hours) from tickets  t2 join tasks on tasks.id = t2.task_id
           where t2.assignee_id = u.id   and  tasks.start_date BETWEEN CAST('$from' AS DATE) 
           AND CAST('$to' AS DATE) and tasks.due_date BETWEEN CAST('$from' AS DATE) AND CAST('$to' AS DATE) ),0) as hours_asigned ,
          
           IFNULL((select hours_available - hours_asigned ),0) as efective_capacity 
        
           FROM users u
            JOIN team_users ON team_users.user_id =u.id 
            JOIN projects ON team_users.project_id =projects.id  
		".$where_sprints_query." 
            JOIN cities ON team_users.city_id =cities.id 
            JOIN countries as ctry ON team_users.country_id =ctry.id 
            WHERE
            projects.customer_id = ?
            and u.id = $user_id
        
            AND team_users.project_id = ?
           
      ";

//var_dump($query);
//var_dump($query_params);
//die;
        $data = DB::select($query, $query_params);
//var_dump($data);
//die;

        return response()->json(array('data' => isset($data[0])?$data[0]:array()));
    }


}

?>
