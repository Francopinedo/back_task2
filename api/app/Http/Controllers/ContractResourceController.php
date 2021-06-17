<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Holiday;
use App\Models\Contract;
use App\Models\ContractResource;
use App\Models\Project;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
use Illuminate\Http\Request;
use Transformers\ContractResourceTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de ContractResource
 *
 * @Resource("Group ContractResource")
 */
class ContractResourceController extends Controller
{

    /**
     * Obtener
     *
     * @Get("contract_resources{?company_id}")
     * @Parameters({
     *      @Parameter("company_id", description="ID de la compañia", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*', 'customers.company_id'])->first();
        $project = Project::find($contract->project_id);

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();


        $query = DB::table('contract_resources')
            ->select(
                'contract_resources.id',
                'contract_resources.project_role_id',
                'contract_resources.seniority_id',
                'contract_resources.qty',
                'contract_resources.rate',
                'contract_resources.currency_id',
                'contract_resources.load',
                'contract_resources.workplace',
                'contract_resources.comments',
                'contract_resources.country_id',
                'contract_resources.contract_id',
                'contract_resources.rate',
                'currencies.name AS currency_name',
                'offices.hours_by_day',
                'offices.title as office_name',
                'countries.name as country_name',
                'cities.name as city_name',
                'project_roles.title AS project_role_title',
                'seniorities.title AS seniority_title',
                'rates.title AS rate_title',
                'exchange_rates.value as exhange_value'
            )
            ->leftJoin('project_roles', 'project_roles.id', '=', 'contract_resources.project_role_id')
            ->leftJoin('seniorities', 'seniorities.id', '=', 'contract_resources.seniority_id')
            ->leftJoin('rates', 'rates.id', '=', 'contract_resources.rate_id')
            ->join('currencies', 'currencies.id', '=', 'contract_resources.currency_id')
            ->join('offices', 'offices.id', '=', 'contract_resources.office_id')
            ->join('countries', 'countries.id', '=', 'contract_resources.country_id')
            ->join('cities', 'cities.id', '=', 'contract_resources.city_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('contract_id')) {
            $query->where('contract_resources.contract_id', $request->contract_id);
        }

        $contractResources = $query->get();
        $contractResourcesResult = array();
        $begin = new DateTime($contract->start_date);
        $end = new DateTime($contract->finish_date);
        $end->setTime(0, 0, 1);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($contractResources as $contractResource) {
            $array = $contractResource;
            $totaluser = 0;

            foreach ($period as $dt) {
                $dow = $dt->format('w');
                if (!in_array($dow, json_decode($project->holy_days)) && !Holiday::where('country_id', $contractResource->country_id)
                        ->where('date', $dt->format('Y-m-d'))->exists()
                ) {
                    $totaluser = $totaluser + $contractResource->hours_by_day;
                }
            }

            $array->hours = $totaluser;
            $array->amount = $contractResource->qty * ($totaluser * $contractResource->rate);
            $exchangeresult = exchange($contractResource, $contract_currency);
            $array->rate_exchage = $exchangeresult['rate'];

            array_push($contractResourcesResult, $array);
        }

        return response()->json(array('data'=>$contractResourcesResult));
    }

    /**
     * Crear
     *
     * @Post("contract_resources")
     * @Request({
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('project_role_id')
            || !$request->has('seniority_id')
            || !$request->has('qty')
            || !$request->has('rate')
            || !$request->has('currency_id')
            || !$request->has('load')
            || !$request->has('workplace')
        ) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $contractResource = ContractResource::create($data);

        if ($contractResource) {
            return $this->response->item($contractResource, new ContractResourceTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("contract_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $contractResource = ContractResource::findOrFail($id);

        return $this->response->item($contractResource, new ContractResourceTransformer);
    }

    /**
     * Editar
     *
     * @Patch("contract_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_role_id": "int",
     *        "seniority_id": "int",
     *        "qty": "int",
     *        "rate_id": "int",
     *        "currency_id": "int",
     *        "load": "int",
     *        "workplace": "enum",
     *        "comments": "string",
     *        "contract_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $contractResource = ContractResource::find($id);

        if ($contractResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $contractResource->update($data);

        if ($contractResource) {
            return $this->response->item($contractResource, new ContractResourceTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("contract_resources/{id}")
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
        $contractResource = ContractResource::find($id);

        if ($contractResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $contractResource->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("contract_resources/datatables")
     */
    public function datatables(Request $request)
    {

        $contract = Contract::join('customers', 'customers.id', '=', 'contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*', 'customers.company_id'])->first();
        $project = Project::find($contract->project_id);

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();


        $query = DB::table('contract_resources')
            ->select(
                'contract_resources.id',
                'contract_resources.project_role_id',
                'contract_resources.seniority_id',
                'contract_resources.qty',
                'contract_resources.rate',
                'contract_resources.currency_id',
                'contract_resources.load',
                'contract_resources.workplace',
                'contract_resources.comments',
                'contract_resources.country_id',
                'contract_resources.contract_id',
                'contract_resources.rate',
                'currencies.name AS currency_name',
                'offices.hours_by_day',
                'offices.title as office_name',
                'countries.name as country_name',
                'cities.name as city_name',
                'project_roles.title AS project_role_title',
                'seniorities.title AS seniority_title',
                'rates.title AS rate_title',
                'exchange_rates.value as exhange_value'
            )
            ->leftJoin('project_roles', 'project_roles.id', '=', 'contract_resources.project_role_id')
            ->leftJoin('seniorities', 'seniorities.id', '=', 'contract_resources.seniority_id')
            ->leftJoin('rates', 'rates.id', '=', 'contract_resources.rate_id')
            ->join('currencies', 'currencies.id', '=', 'contract_resources.currency_id')
            ->join('offices', 'offices.id', '=', 'contract_resources.office_id')
            ->join('countries', 'countries.id', '=', 'contract_resources.country_id')
            ->join('cities', 'cities.id', '=', 'contract_resources.city_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('contract_id')) {
            $query->where('contract_resources.contract_id', $request->contract_id);
        }

        $contractResources = $query->get();
        $contractResourcesResult = array();
        $begin = new DateTime($contract->start_date);
        $end = new DateTime($contract->finish_date);
        $end->setTime(0, 0, 1);
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        foreach ($contractResources as $contractResource) {
            $array = $contractResource;
            $totaluser = 0;

            foreach ($period as $dt) {
                $dow = $dt->format('w');
                if (!in_array($dow, json_decode($project->holy_days)) && !Holiday::where('country_id', $contractResource->country_id)
                        ->where('date', $dt->format('Y-m-d'))->exists()
                ) {
                    $totaluser = $totaluser + $contractResource->hours_by_day;
                }
            }

            $array->hours = $totaluser;
            $array->amount = $contractResource->qty * ($totaluser * $contractResource->rate);
            $exchangeresult = exchange($contractResource, $contract_currency);
            $array->rate_exchage = $exchangeresult['rate'];

            array_push($contractResourcesResult, $array);
        }
        return Datatables::of($contractResourcesResult)->make(true);
    }

}

?>