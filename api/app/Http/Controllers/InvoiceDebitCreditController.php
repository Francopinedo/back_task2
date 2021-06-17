<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\InvoiceDebitCredit;
use Transformers\InvoiceDebitCreditTransformer;

/**
 * Modulo de InvoiceDebitCredit
 *
 * @Resource("Group InvoiceDebitCredit")
 */
class InvoiceDebitCreditController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("invoice_debit_credit{?company_id}")
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
  		$query = InvoiceDebitCredit::join('currencies','currencies.id','=','invoice_debit_credit.currency_id')
            ->join('exchange_rates','exchange_rates.currency_id','=','currencies.id','left')
            ->groupBy('invoice_debit_credit.id');

        if ($request->has('invoice_id'))
        {
            $query->where('invoice_id', $request->invoice_id);
        }
         if ($request->has('signs'))
        {
            $query->where('signs', $request->signs);
        }
  		$InvoiceDebitCredits = $query->get(['exchange_rates.currency_id','invoice_debit_credit.*','exchange_rates.value', 'currencies.code']);

  		return $this->response->collection($InvoiceDebitCredits, new InvoiceDebitCreditTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("invoice_debit_credit")
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
     *  		"currency_id": "int",
     *  		"invoice_id": "int",
     *  		"file": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('invoice_id') || !$request->has('cost') || !$request->has('currency_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $InvoiceDebitCredit = InvoiceDebitCredit::create($data);

        if ($InvoiceDebitCredit)
        {
        	return $this->response->item($InvoiceDebitCredit, new InvoiceDebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("invoice_debit_credit/{id}")
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
  		$InvoiceDebitCredit = InvoiceDebitCredit::findOrFail($id);

  		return $this->response->item($InvoiceDebitCredit, new InvoiceDebitCreditTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("invoice_debit_credit/{id}")
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
  		$InvoiceDebitCredit = InvoiceDebitCredit::find($id);

  		if ($InvoiceDebitCredit == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $InvoiceDebitCredit->update($data);

        if ($InvoiceDebitCredit)
        {
        	return $this->response->item($InvoiceDebitCredit, new InvoiceDebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("invoice_debit_credit/{id}")
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
  		$InvoiceDebitCredit = InvoiceDebitCredit::find($id);

        if ($InvoiceDebitCredit == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $InvoiceDebitCredit->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("invoice_debit_credit/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('invoice_debit_credit')
                    ->select(
                    	'invoice_debit_credit.id',
                    	'invoice_debit_credit.detail',
                    	'invoice_debit_credit.cost',
                    	'invoice_debit_credit.amount',
                        'invoices.emited',
                    	'invoice_debit_credit.currency_id',
                    	'currencies.name AS currency_name')
            ->join('invoices', 'invoices.id', '=', 'invoice_debit_credit.invoice_id')
                    ->join('currencies', 'currencies.id', '=', 'invoice_debit_credit.currency_id');

        if ($request->has('invoice_id'))
  		{
  			$query->where('invoice_debit_credit.invoice_id', $request->invoice_id);
  		}
          if ($request->has('signs'))
      {
        $query->where('invoice_debit_credit.signs', $request->signs);
      }

		$InvoiceDebitCredits = $query->get();

  		return Datatables::of($InvoiceDebitCredits)->make(true);
  	}

}

?>