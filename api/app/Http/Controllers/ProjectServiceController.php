<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\Contract;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ProjectService;
use Transformers\ProjectServiceTransformer;

/**
 * Modulo de ProjectService
 *
 * @Resource("Group ProjectService")
 */
class ProjectServiceController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("project_services{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = ProjectService::with('project');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$projectServices = $query->get();

  		return $this->response->collection($projectServices, new ProjectServiceTransformer);
  	}

      public function index_export(Request $request)
    {
        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();



        $query = DB::table('project_services')
                    ->select(
                      'project_services.detail',
                      'project_services.cost',
                      'project_services.amount',
                      'project_services.frequency',
                      'project_services.reimbursable',
                        'exchange_rates.value as exhange_value',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),
                      'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'project_services.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('project_id'))
      {
        $query->where('project_services.project_id', $request->project_id);
      }

    $projectServices = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($projectServices as $contractResource) {
            $array = $contractResource;

            $frequency = isset($contractResource->frequency) && $contractResource->frequency != null
            && $contractResource->frequency != '' ? $contractResource->frequency : $monthly;

            $days = $contractResource->days;

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

            $exchangeresult = exchange($contractResource, $contract_currency);
            $array->rate_exchage = $exchangeresult['rate'] * $multi;
            $array->cost_exchage = $exchangeresult['cost'] * $multi;
            array_push($contractResourcesResult, $array);
        }


  return response()->json(array('data' => $contractResourcesResult));
    }

  	/**
	 * Crear
	 *
	 * @Post("project_services")
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('project_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $projectService = ProjectService::create($data);

        if ($projectService)
        {
        	return $this->response->item($projectService, new ProjectServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("project_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$projectService = ProjectService::findOrFail($id);

  		return $this->response->item($projectService, new ProjectServiceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("project_services/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"real_cost": "float",
     *  		"currency_id": "int",
     *  		"project_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$projectService = ProjectService::find($id);

  		if ($projectService == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $projectService->update($data);

        if ($projectService)
        {
        	return $this->response->item($projectService, new ProjectServiceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("project_services/{id}")
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
  		$projectService = ProjectService::find($id);

        if ($projectService == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $projectService->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("project_services/datatables")
	 */
  	public function datatables(Request $request)
  	{
        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();



        $query = DB::table('project_services')
                    ->select(
                    	'project_services.id',
                    	'project_services.detail',
                    	'project_services.cost',
                    	'project_services.amount',
                    	'project_services.currency_id',
                    	'project_services.project_id',
                    	'project_services.frequency',
                    	'project_services.reimbursable',
                        'exchange_rates.value as exhange_value',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'project_services.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('project_id'))
  		{
  			$query->where('project_services.project_id', $request->project_id);
  		}

		$projectServices = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($projectServices as $contractResource) {
            $array = $contractResource;

            $frequency = isset($contractResource->frequency) && $contractResource->frequency != null
            && $contractResource->frequency != '' ? $contractResource->frequency : $monthly;

            $days = $contractResource->days;

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

            $exchangeresult = exchange($contractResource, $contract_currency);
            $array->rate_exchage = $exchangeresult['rate'] * $multi;
            $array->cost_exchage = $exchangeresult['cost'] * $multi;
            array_push($contractResourcesResult, $array);
        }

        return Datatables::of($contractResourcesResult)->make(true);
  	}

}

?>