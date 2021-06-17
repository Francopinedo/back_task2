<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\TeamUser;
use DB;
use Illuminate\Http\Request;
use Transformers\TeamUserTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de TeamUser
 *
 * @Resource("Group TeamUser")
 */
class TeamUserController extends Controller
{

    /**
     * Obtener
     *
     * @Get("team_users{?project_id}")
     * @Parameters({
     *      @Parameter("project_id", description="ID del proyecto", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = TeamUser::with('user');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $teamUsers = $query->get();

        return $this->response->collection($teamUsers, new TeamUserTransformer);
    }


      public function index_export(Request $request)
    {
        $query = DB::table('team_users')
            ->select(
                'team_users.hours',
                'team_users.load',
                'team_users.date_from',
                'team_users.date_to',
                'users.workplace',
                'projects.name AS project_name',
                'cities.name AS city_name',
                'company_roles.title AS company_role',
                'project_roles.title AS project_role',
                'seniorities.title AS seniority',
                'countries.name AS country_name',
                 'team_users.load',
                DB::raw('ifnull((select value from rates where rates.project_role_id=team_users.project_role_id and rates.seniority_id=team_users.seniority_id AND rates.office_id=team_users.office_id and team_users.workplace=rates.workplace),0) as rate'),
                'users.name AS user_name')
            ->join('projects', 'projects.id', '=', 'team_users.project_id')
            ->join('users', 'users.id', '=', 'team_users.user_id')
            ->join('seniorities', 'seniorities.id', '=', 'team_users.seniority_id')
            ->join('company_roles', 'company_roles.id', '=', 'users.company_role_id')
            ->join('project_roles', 'project_roles.id', '=', 'team_users.project_role_id')
            ->join('cities', 'cities.id', '=', 'team_users.city_id')
            ->join('countries', 'countries.id', '=', 'team_users.country_id');

        $query->whereNotNull('users.office_id');

        if ($request->has('project_id')) {
            $query->where('team_users.project_id', $request->project_id);
        }

        if ($request->has('company_id')) {
            $query->join('customers', 'customers.id', '=', 'projects.customer_id');
            $query->where('customers.company_id', $request->company_id);
        }

        $teamUsers = $query->get();

       return response()->json(array('data' => $teamUsers));
    }

  public function get_rate($user_id)
    {
        //$query = DB::table('team_users')->where('user_id',$user_id)->sum('load');
    $query = \DB::select(\DB::raw('select ifnull(sum(value),0)  as rate from `rates`,`team_users`
    where `rates`.`project_role_id`=`team_users`.`project_role_id` 
    and `rates`.`seniority_id`=`team_users`.`seniority_id` 
    AND `rates`.`office_id`=`team_users`.`office_id` 
    and `team_users`.`workplace`=`rates`.`workplace` AND `team_users`.user_id='.$user_id.''));


        return $query[0]->rate;
    }

    public function get_load($user_id,$project_id,$office_id)
    {


        //$project_id = TeamUser::where('user_id',$user_id)->first()->project_id;
  
$query = \DB::select(\DB::raw('select IFNULL((SELECT `hours_by_day` FROM `projects` WHERE `projects`.`id`='.$project_id.')/(select `offices`.`hours_by_day` from `offices` 
WHERE  offices.id='.$office_id.')*100,0) AS "load"' ));

        return $query[0]->load;
    }

    /**
     * Crear
     *
     * @Post("team_users")
     * @Request({
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {

        $data = $request->all();


       $current = TeamUser::where('project_id', $data['project_id'])
            ->where('user_id', $data['user_id'])->get();
     
//return $current;
        if (count($current)>0) {
            return $this->response->error(current, 500);
        }


        if (!$request->has('project_id') || !$request->has('user_id') || !$request->has('date_to') || !$request->has('date_from')) {
            return $this->response->error('Faltan datos', 450);
        }
        $project = Project::find($data['project_id']);


        $teamUser = TeamUser::create($data);
        $dateto = new \DateTime($data['date_to']);
        if ($teamUser) {
            $period = new \DatePeriod(
                new \DateTime($data['date_from']),
                new \DateInterval('P1D'),
                $dateto->add(new \DateInterval('P1D'))
            );

            foreach ($period as $key => $value) {
                $dow = $value->format('w');
//                if(is_array($project->holy_days)){
                if (!in_array($dow, (array)($project->holy_days))) {
                    $workinghour = array('project_id' => $data['project_id'],
                        'user_id' => $data['user_id'], 'date' => $value->format('Y-m-d'), 'hours' => $data['hours']);

                    $request = new \Illuminate\Http\Request($workinghour);

                    app('App\Http\Controllers\WorkingHourController')->store($request);
                }

  //          }
        }


            return $this->response->item($teamUser, new TeamUserTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("team_users/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $teamUser = TeamUser::findOrFail($id);

        return $this->response->item($teamUser, new TeamUserTransformer);
    }

    public function show_user($user_id)
    {
        $user_members = TeamUser::where('user_id','=',$user_id)->get();

        return $this->response->collection($user_members, new TeamUserTransformer);

    }

    /**
     * Editar
     *
     * @Patch("team_users/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_type_id": "int",
     *        "project_id": "int",
     *        "comment": "string",
     *        "from": "date",
     *        "to": "date",
     *        "user_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $teamUser = TeamUser::find($id);


        if ($teamUser == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        $project = Project::find($data['project_id']);

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }


        if (!$request->has('project_id') || !$request->has('user_id') || !$request->has('date_to') || !$request->has('date_from')) {
            return $this->response->error('Faltan datos', 450);
        }


        $teamUser->update($data);

        if ($teamUser) {


            DB::table('working_hours')->where('project_id', $data['project_id'])
                ->where('user_id', $data['user_id'])->delete();

            $dateto = new \DateTime($data['date_to']);
            $period = new \DatePeriod(
                new \DateTime($data['date_from']),
                new \DateInterval('P1D'),
                $dateto->add(new \DateInterval('P1D'))
            );

            foreach ($period as $key => $value) {

                $dow = $value->format('w');

                if (!in_array($dow, (array)($project->holy_days))) {
                    $workinghour = array('project_id' => $data['project_id'],
                        'user_id' => $data['user_id'], 'date' => $value->format('Y-m-d'), 'hours' => $data['hours']);

                    $request = new \Illuminate\Http\Request($workinghour);

                    app('App\Http\Controllers\WorkingHourController')->store($request);
                }

            }


            return $this->response->item($teamUser, new TeamUserTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("team_users/{id}")
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
        $teamUser = TeamUser::find($id);

        if ($teamUser == NULL) {
            return $this->response->error('No existe', 450);
        }

        $teamUser->delete();

        DB::table('working_hours')->where('project_id', $teamUser->project_id)
            ->where('user_id', $teamUser->user_id)->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("team_users/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('team_users')
            ->select(
                'team_users.id',
                'team_users.hours',
                'team_users.load',
                'team_users.date_from',
                'team_users.date_to',
                'users.workplace',
                'projects.name AS project_name',
                'cities.name AS city_name',
                'company_roles.title AS company_role',
                'project_roles.title AS project_role',
                'seniorities.title AS seniority',
                'countries.name AS country_name',
                 'team_users.load',
                DB::raw('ifnull((select value from rates where rates.project_role_id=team_users.project_role_id and rates.seniority_id=team_users.seniority_id AND rates.office_id=team_users.office_id and team_users.workplace=rates.workplace),0) as rate'),
                'users.name AS user_name')
            ->join('projects', 'projects.id', '=', 'team_users.project_id')
            ->join('users', 'users.id', '=', 'team_users.user_id')
            ->join('seniorities', 'seniorities.id', '=', 'team_users.seniority_id')
            ->join('company_roles', 'company_roles.id', '=', 'users.company_role_id')
            ->join('project_roles', 'project_roles.id', '=', 'team_users.project_role_id')
            ->join('cities', 'cities.id', '=', 'team_users.city_id')
            ->join('countries', 'countries.id', '=', 'team_users.country_id');

        $query->whereNotNull('users.office_id');

        if ($request->has('project_id')) {
            $query->where('team_users.project_id', $request->project_id);
        }

        if ($request->has('company_id')) {
            $query->join('customers', 'customers.id', '=', 'projects.customer_id');
            $query->where('customers.company_id', $request->company_id);
        }

        $teamUsers = $query->get();

        return Datatables::of($teamUsers)->make(true);
    }

}

?>
