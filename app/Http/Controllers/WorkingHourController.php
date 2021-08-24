<?php

namespace App\Http\Controllers;


use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class WorkingHourController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index(Request $request)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&with_office=1&project_id=' . session('project_id'));
        $project = $this->getFromApi('GET', 'projects/' . session('project_id'));

        $userlist = array();

        $dates = [];
        if (session()->has('project_id')) {
            $data['project'] = $this->getFromApi('GET', 'projects/' . session('project_id'));


            foreach ($users as $user) {

                $totaluser = 0;
                $totaluserAddti = 0;
                $newusr = $user;
                if (isset($request->start)) {
                    $begin = new DateTime($request->start);
                } else {
                    $begin = new DateTime($data['project']->start);
                }

                if (isset($request->finish)) {
                    $end = new DateTime($request->finish);
                } else {
                    $end = new DateTime($data['project']->start);
                }


                // $end->add(new DateInterval('P1D'));

                $end->setTime(0, 0, 1);
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);

                $workingHours = [];
                $additionalHours = [];

                foreach ($period as $dt) {

                    $workingHoursFromApi = $this->getFromApi('GET', 'working_hours/calculated?user_id=' . $user->id . '&company='
                        . $company->id . '&period_from=' . $dt->format("Y-m-d") .
                        '&period_to=' . $dt->format("Y-m-d") . '&customer=' . $data['project']->customer_id . '&project=' . $data['project']->id);

                    if (!in_array($dt->format("Y-m-d"), $dates)) {
                        
                        array_push($dates, $dt->format("Y-m-d"));
                    }
        if (!empty($workingHoursFromApi)) {
            
                    //var_dump($workingHoursFromApi);
            
                    $wh = [];
                    $wh['date'] = $dt->format("Y-m-d");
                    $wh['hours'] = $workingHoursFromApi->hours;
                   
                    if ($workingHoursFromApi->hours >= 0) {
                        $totaluser = $totaluser + $workingHoursFromApi->hours;
                    }
        }else{
            $wh = [];
                    $wh['date'] = $dt->format("Y-m-d");
                    $wh['hours'] = 0;
            $totaluser =0;

            }

                    $workingHours[$dt->format("Y-m-d")] = (object)$wh;
                    //$workingHours[$dt->format("Y-m-d")]  = $wh;
                    $hoursADitionsls = $this->getFromApi('GET', 'additional_hours?project_id=' . $data['project']->id . '&date=' . $dt->format("Y-m-d").
                '&user_id='.$user->id);
                    $whAddi = [];
                    $whAddi['date'] = $dt->format("Y-m-d");

                    $hoursad=0;
                    foreach ($hoursADitionsls as $additionalHour) {
                        $hoursad = $additionalHour->hours;
                        $totaluserAddti = $totaluserAddti + $hoursad;
                    }
                    $whAddi['hours'] = $hoursad;
                    $additionalHours[$dt->format("Y-m-d")] = (object)$whAddi;

                }

                $newusr->totaluser = $totaluser;
                $newusr->totaluserAddti = $totaluserAddti;
                $newusr->workingHours = $workingHours;
                $newusr->aditionalHours = $additionalHours;


                array_push($userlist, $newusr);
            }


        }
        if (isset($end)) {
            $data['begin'] = $begin->format("Y-m-d");
            $data['end'] = $end->format("Y-m-d");
        }
        $data['users'] = $userlist;
        $data['dates'] = $dates;
        $data['project'] = $project;


        return view('working_hour/index', $data);
    }

    /**
     * Muestra las working hours para un miembro del team
     */
    public
    function show($team_user_id)
    {
        
        $teamUser = $this->getFromApi('GET', 'team_users/' . $team_user_id);
        $team = $this->getFromApi('GET', 'teams/' . $teamUser->team_id);
        $project = $this->getFromApi('GET', 'projects/' . $team->project_id);
        $customer = $this->getFromApi('GET', 'customers/' . $project->customer_id);

        return view('working_hour/show', [
            'teamUser' => $teamUser,
            'customer' => $customer
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public
    function edit($id)
    {
        $workingHour = $this->getFromApi('GET', 'working_hours/' . $id);


        return response()->json([
            'view' => view('working_hour/edit', [
                'workingHour' => $workingHour
            ])->render()
        ]);
    }

    /**
     * Crear nuevo
     */
    public
    function store(Request $request)
    {
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'project_id' => 'required',
            'user_id' => 'required',
            'date' => 'required',
            'hours' => 'numeric|required',
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'working_hours', $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.working_hour_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Actualizo
     */
    public
    function update(Request $request)
    {
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'user_id' => 'required',
            'date' => 'required',
            'hours' => 'numeric|required',
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'working_hours/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.working_hour_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public
    function delete($id)
    {
        $res = $this->apiCall('DELETE', 'working_hours/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');

            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('WorkingHourController@index');
    }
}
