<?php

namespace App\Http\Controllers;

use App\ExchangeRate;
use App\Models\Contract;
use App\Models\Project;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ProjectDebitCredit;
use Transformers\ProjectDebitCreditTransformer;

/**
 * Modulo de ProjectDebitCredit
 *
 * @Resource("Group ProjectDebitCredit")
 */
class ProjectDebitCreditController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("debit_credit{?company_id}")
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
  		$query = ProjectDebitCredit::with('project');
    //  $query = ProjectMaterial::with('company');

      if ($request->has('project_id'))
      {
        $query->where('project_id', $request->project_id);
      }
  	

  		$ProjectDebitCredits = $query->get();

  		return $this->response->collection($ProjectDebitCredits, new ProjectDebitCreditTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("debit_credit")
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

        $ProjectDebitCredit = ProjectDebitCredit::create($data);

        if ($ProjectDebitCredit)
        {
        	return $this->response->item($ProjectDebitCredit, new PProjectDebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("debit_credit/{id}")
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
  		$ProjectDebitCredit = ProjectDebitCredit::findOrFail($id);

  		return $this->response->item($ProjectDebitCredit, new ProjectDebitCreditTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("debit_credit/{id}")
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
  		$ProjectDebitCredit = ProjectDebitCredit::find($id);

  		if ($ProjectDebitCredit == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $ProjectDebitCredit->update($data);

        if ($ProjectDebitCredit)
        {
        	return $this->response->item($ProjectDebitCredit, new ProjectDebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("debit_credit/{id}")
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
  		$ProjectDebitCredit = ProjectDebitCredit::find($id);

        if ($ProjectDebitCredit == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $ProjectDebitCredit->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("debit_credit/datatables")
	 */
  	public function datatables(Request $request)
  	{
       
    

        $contract = Contract::join('customers','customers.id', '=','contracts.customer_id')
            ->where('contracts.id', $request->contract_id)->get(['contracts.*','customers.company_id'])->first();

        $contract_currency = ExchangeRate::where('currency_id', $contract->currency_id)->where('company_id', $contract->company_id)->first();



        $query = DB::table('project_debit_credit')
                    ->select(
                    	'project_debit_credit.id',
                    	 'project_debit_credit.signs',
                      'project_debit_credit.detail',
                    	'project_debit_credit.cost',
                    	'project_debit_credit.amount',
                    	'project_debit_credit.currency_id',
                    	'project_debit_credit.project_id',
                    	'project_debit_credit.frequency',
                        'exchange_rates.value as exhange_value',
                        DB::raw("IFNULL(TIMESTAMPDIFF(DAY, '$contract->start_date','$contract->finish_date')+1,0) as days"),
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'project_debit_credit.currency_id')
            ->join('exchange_rates', 'exchange_rates.currency_id', '=', 'currencies.id', 'left');

        if ($request->has('project_id'))
  		{
  			$query->where('project_debit_credit.project_id', $request->project_id);
  		}
      if ($request->has('signs'))
            {
              $query->where('signs', $request->signs);
            }
		$ProjectDebitCredits = $query->get();


        $contractResourcesResult = array();
        $monthly = 'monthly';
        foreach ($ProjectDebitCredits as $contractResource) {
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
            $array->cost_exchage = $exchangeresult['cost'] *$multi;
            array_push($contractResourcesResult, $array);
        }
        //return $contractResourcesResult;
        return Datatables::of($contractResourcesResult)->make(true);
  	}

}

?>