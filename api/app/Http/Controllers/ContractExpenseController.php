<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\Contract;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ContractExpense;
use Transformers\ContractExpenseTransformer;

/**
 * Modulo de ContractExpense
 *
 * @Resource("Group ContractExpense")
 */
class ContractExpenseController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("contract_expenses{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();

        $query = DB::table('contract_expenses')
            ->select(
                'contract_expenses.id',
                'contract_expenses.detail',
                'contract_expenses.cost',
                'contract_expenses.amount',
                'contract_expenses.frequency',
                'contract_expenses.currency_id',
                'contract_expenses.contract_id',
                'contract_expenses.expense_id',
                'contract_expenses.reimbursable',
                'exchange_rates.value as exhange_value',
                DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),

                'currencies.name AS currency_name')
            ->join('currencies', 'currencies.id', '=', 'contract_expenses.currency_id')
            ->join('contracts', 'contracts.id', '=', 'contract_expenses.contract_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('contract_id'))
        {
            $query->where('contract_expenses.contract_id', $request->contract_id);
        }

        $contractExpenses = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($contractExpenses as $contractResource) {
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

        return response()->json(array('data'=>$contractResourcesResult));

  	}

  	/**
	 * Crear
	 *
	 * @Post("contract_expenses")
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('contract_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $contractExpense = ContractExpense::create($data);

        if ($contractExpense)
        {
        	return $this->response->item($contractExpense, new ContractExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("contract_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$contractExpense = ContractExpense::findOrFail($id);

  		return $this->response->item($contractExpense, new ContractExpenseTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("contract_expenses/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"cost": "float",
     *  		"currency_id": "int",
     *  		"contract_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$contractExpense = ContractExpense::find($id);

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
        	return $this->response->item($contractExpense, new ContractExpenseTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("contract_expenses/{id}")
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
  		$contractExpense = ContractExpense::find($id);

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
	 * @Get("contract_expenses/datatables")
	 */
  	public function datatables(Request $request)
  	{

        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();

  		$query = DB::table('contract_expenses')
                    ->select(
                    	'contract_expenses.id',
                    	'contract_expenses.detail',
                    	'contract_expenses.cost',
                    	'contract_expenses.amount',
                    	'contract_expenses.frequency',
                    	'contract_expenses.currency_id',
                    	'contract_expenses.contract_id',
                    	'contract_expenses.expense_id',
                    	'contract_expenses.reimbursable',
                        'exchange_rates.value as exhange_value',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),

                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'contract_expenses.currency_id')
                    ->join('contracts', 'contracts.id', '=', 'contract_expenses.contract_id')
        ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('contract_id'))
  		{
  			$query->where('contract_expenses.contract_id', $request->contract_id);
  		}

		$contractExpenses = $query->get();

        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($contractExpenses as $contractResource) {
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