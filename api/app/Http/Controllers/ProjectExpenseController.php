<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\Contract;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ProjectExpense;
use Transformers\ProjectExpenseTransformer;

/**
 * Modulo de ProjectExpense
 *
 * @Resource("Group ProjectExpense")
 */
class ProjectExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("project_expenses{?company_id}")
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
  		$query = ProjectExpense::with('project');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$projectExpenses = $query->get();

  		return $this->response->collection($projectExpenses, new ProjectExpenseTransformer);
  	}

      public function index_export(Request $request)
    {
          $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();


         $query = DB::table('project_expenses')
                    ->select(
                      'project_expenses.detail',
                      'project_expenses.cost',
                      'project_expenses.amount',
                      'project_expenses.frequency',
                        'exchange_rates.value as exchange_value',
                      'project_expenses.reimbursable',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),
                      'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'project_expenses.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('project_id'))
      {
        $query->where('project_expenses.project_id', $request->project_id);
      }

    $projectExpenses = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($projectExpenses as $contractResource) {
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
	 * @Post("project_expenses")
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

        $contractExpense = ProjectExpense::create($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new ProjectExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("project_expenses/{id}")
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
  		$contractExpense = ProjectExpense::findOrFail($id);

  		return $this->response->item($contractExpense, new ProjectExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("project_expenses/{id}")
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
  		$contractExpense = ProjectExpense::find($id);

  		if ($contractExpense == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $contractExpense->update($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new ProjectExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("project_expenses/{id}")
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
  		$contractExpense = ProjectExpense::find($id);

        if ($contractExpense == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $contractExpense->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("project_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{

        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();



        $query = DB::table('project_expenses')
                    ->select(
                    	'project_expenses.id',
                    	'project_expenses.detail',
                    	'project_expenses.cost',
                    	'project_expenses.amount',
                    	'project_expenses.currency_id',
                    	'project_expenses.project_id',
                    	'project_expenses.frequency',
                        'exchange_rates.value as exhange_value',
                    	'project_expenses.reimbursable',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'project_expenses.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('project_id'))
  		{
  			$query->where('project_expenses.project_id', $request->project_id);
  		}

		$projectExpenses = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($projectExpenses as $contractResource) {
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