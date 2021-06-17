<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\AdditionalHour;
use App\Models\Contract;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\Rate;
use App\Models\TeamUser;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\ProjectResourceTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de ProjectResource
 *
 * @Resource("Group ProjectResource")
 */
class ProjectResourceController extends Controller
{

    /**
     * Obtener
     *
     * @Get("project_resources{?company_id}")
     * @Parameters({
     *      @Parameter("company_id", description="ID de la compañia", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
		
//		  $query = ProjectResource::with('company')->where('project_resources.project_id', $projectId)

	//	              ->join('currencies', 'currencies.id', '=', 'project_resources.currency_id')
   //         ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
   ///         ->join('tasks', 'project_resources.project_id', '=', 'tasks.project_id', 'left')
//			 ->join('task_resources', 'tasks.id', '=', 'task_resources.task_id', 'left')
	//		->join('projects', 'projects.id', '=', 'tasks.project_id', 'left')
//            ->groupBy('task_resources.id')
 //           ->whereNotNull('project_resources.user_id')->get(['tasks.project_id', 'task_resources.user_id',
  //              'task_resources.project_role_id', 'task_resources.seniority_id', 'task_resources.task_id',
   //             'task_resources.rate as amount', 'task_resources.quantity', 'task_resources.currency_id',
    //            'exchange_rates.value as exhange_value']);


		
        $query = ProjectResource::with('project');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $projectResources = $query->get();

        return $this->response->collection($projectResources, new ProjectResourceTransformer);
    }

    /**
     * Crear
     *
     * @Post("project_resources")
     * @Request({
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('project_role_id')
            || !$request->has('seniority_id')
            || !$request->has('currency_id')

            || !$request->has('load')
            || !$request->has('workplace')
            || !$request->has('rate')
        ) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();
        $data['type'] = 'ordinary';

        $projectResource = ProjectResource::create($data);

        if ($projectResource) {
            return $this->response->item($projectResource, new ProjectResourceTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("project_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $projectResource = ProjectResource::findOrFail($id);

        return $this->response->item($projectResource, new ProjectResourceTransformer);
    }

    /**
     * Editar
     *
     * @Patch("project_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "project_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $projectResource = ProjectResource::find($id);

        if ($projectResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if(!isset($data['comment'])){
            $data['comment'] = NULL;
        }
        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $projectResource->update($data);

        if ($projectResource) {
            return $this->response->item($projectResource, new ProjectResourceTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("project_resources/{id}")
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
        $projectResource = ProjectResource::find($id);

        if ($projectResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $projectResource->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("project_resources/datatables")
     */
    public function datatables(Request $request)
    {


        $project = Project::find($request->project_id);
        $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*', 'customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();


        $teams = TeamUser::where('project_id', '=', $project->id)->get();

        foreach ($teams as $team) {

            // calculo los renglones para additional Hours
            $additionalHoursTypesCount = AdditionalHour::
            join('rates', 'rates.id', '=', 'additional_hours.rate_id', 'left')
                ->where('user_id', $team->user_id)
                ->where('project_id', $team->project_id)
                ->groupBy('project_role_id','currency_id')->get(['rates.value as amount', 'additional_hours.*']);


            foreach ($additionalHoursTypesCount as $addH) {


                $additionalHours = AdditionalHour::where('user_id', $team->user_id)
                    ->where('project_id', $team->project_id)
                    ->where('project_role_id', $addH->project_role_id)
                    ->where('currency_id', $addH->currency_id)
                    ->whereBetween('date', array($project->start, $project->finish))
                    ->get();


                $totalHours = 0;
                foreach ($additionalHours as $ah) {
                    $totalHours = $totalHours + $ah->hours;
                }


                $rate = Rate::find($addH->rate_id);

                $exist = ProjectResource::where('user_id', '=', $addH->user_id)
                    ->where('project_id', '=', $project->id)->where('type', '=', 'additional')
                    ->delete();


                if ($totalHours > 0) {

                    $item = ProjectResource::create([
                        'project_id' => $project->id,
                        'project_role_id' => $rate->project_role_id,
                        'user_id' => $addH->user_id,
                        'seniority_id' => $rate->seniority_id,
                        'office_id' => $rate->office_id,
                        'country_id' => $rate->country_id,
                        'city_id' => $rate->city_id,
                        'currency_id' => $rate->currency_id,
                        'load' => '',
                        'type' => 'additional',
                        'workplace' => $rate->workplace,
                        'rate' => $rate->value,
                        'rate_id' => $rate->id,
                        'comments' => ''
                    ]);


                }


            }
        }


        $query = DB::table('project_resources')
            ->select(
                'project_resources.id',
                'project_resources.project_role_id',
                'project_resources.seniority_id',
                'project_resources.rate',
                'project_resources.user_id',
                'project_resources.currency_id',
                'project_resources.load',
                'project_resources.workplace',
                'project_resources.project_id',
                'project_resources.type',
                'project_resources.comments',
                'offices.title as office_name',
                'countries.name as country_name',
                'cities.name as city_name',
                'currencies.name AS currency_name',
                'exchange_rates.value as exhange_value',
                'project_roles.title AS project_role_title',
                'seniorities.title AS seniority_title',
                'users.name AS user_name'

            )
            ->leftJoin('project_roles', 'project_roles.id', '=', 'project_resources.project_role_id')
            ->leftJoin('seniorities', 'seniorities.id', '=', 'project_resources.seniority_id')
            ->leftJoin('users', 'users.id', '=', 'project_resources.user_id')
            ->join('projects', 'projects.id', '=', 'project_resources.project_id')
            ->join('cities', 'cities.id', '=', 'project_resources.city_id')
            ->join('countries as ctry', 'cities.country_id', '=', 'ctry.id')
            ->join('currencies', 'currencies.id', '=', 'project_resources.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left')
            ->join('countries', 'countries.id', '=', 'project_resources.country_id')
        ->join('offices', 'offices.id', '=', 'project_resources.office_id');

        if ($request->has('project_id')) {
            $query->where('project_resources.project_id', $request->project_id);
        }

        $projectResources = $query->get();


        $contractResourcesResult = array();
        foreach ($projectResources as $contractResource) {
            $totaluser = 0;
            $array = $contractResource;

            $begin = new DateTime($project->start);
            $end = new DateTime($project->finish);
            $end->setTime(0, 0, 1);
            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            foreach ($period as $dt) {
                $requestSend = array('project' => $project->id, 'customer' => $contract->customer_id, 'period_to' => $dt->format("Y-m-d"), 'period_from' =>
                    $dt->format("Y-m-d"), 'user_id' => $contractResource->user_id, 'company' => $contract->company_id);
                $requestSend = new \Illuminate\Http\Request($requestSend);
                $workingHoursFromApi = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

                $workingHoursFromApi = $workingHoursFromApi->getData();
                $workingHoursFromApi = $workingHoursFromApi->data;
try{
      if (isset($workingHoursFromApi->hours)){

                if ($workingHoursFromApi->hours >= 0) {
                    $totaluser = $totaluser + $workingHoursFromApi->hours;
                }
}
}
catch(Exception $ex)
{
$totaluser =0;
}

            }
            $array->hours=0;
            $array->amount=0;
            $array->rate_exchage=0;
            $array->cost_exchage=0;
            if ($contractResource->type != 'additional') {
                $array->hours = $totaluser;
                $array->amount = $totaluser * $contractResource->rate;
                $exchangeresult = exchange($contractResource, $contract_currency);
                $array->rate_exchage = $exchangeresult['rate'];
                $array->cost_exchage = $exchangeresult['cost'];

            } else {

                $additionalHoursTypesCount = AdditionalHour::
                join('rates', 'rates.id', '=', 'additional_hours.rate_id', 'left')
                    ->where('user_id', $contractResource->user_id)
                    ->where('project_id', $contractResource->project_id)
                    ->groupBy('project_role_id','currency_id')->get(['rates.value as amount', 'additional_hours.*']);


                foreach ($additionalHoursTypesCount as $addH) {


                    $additionalHours = AdditionalHour::where('user_id', $contractResource->user_id)
                        ->where('project_id', $contractResource->project_id)
                        ->where('project_role_id', $addH->project_role_id)
                        ->where('currency_id', $addH->currency_id)
                        ->whereBetween('date', array($project->start, $project->finish))
                        ->get();


                    $totalHours = 0;
                    foreach ($additionalHours as $ah) {
                        $totalHours = $totalHours + $ah->hours;
                    }

                    $array->hours = $totalHours;
                    $array->amount = $totalHours * $addH->amount;


                    $exchangeresult = exchange($array, $contract_currency);
                    $array->rate_exchage = $exchangeresult['rate'];
                    $array->cost_exchage = $exchangeresult['cost'];
                }


            }

            array_push($contractResourcesResult, $array);
        }

        return Datatables::of($contractResourcesResult)->make(true);
    }

}

?>
