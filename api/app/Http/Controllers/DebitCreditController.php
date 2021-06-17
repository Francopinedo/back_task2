<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\DebitCredit;
use Transformers\DebitCreditTransformer;

/**
 * Modulo de DebitCredits
 *
 * @Resource("Group DebitCredits")
 */
class DebitCreditController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("DebitCredits{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = DebitCredit::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}

  		$DebitCredits = $query->get();

  		return $this->response->collection($DebitCredits, new DebitCreditTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("DebitCredits")
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('detail') || !$request->has('amount'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $DebitCredit = DebitCredit::create($data);

        if ($DebitCredit)
        {
        	return $this->response->item($DebitCredit, new DebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("DebitCredits/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$DebitCredit = DebitCredit::findOrFail($id);

  		return $this->response->item($DebitCredit, new DebitCreditTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("DebitCredits/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$DebitCredit = DebitCredit::find($id);

  		if ($DebitCredit == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $DebitCredit->update($data);

        if ($DebitCredit)
        {
        	return $this->response->item($DebitCredit, new DebitCreditTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("DebitCredits/{id}")
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
  		$DebitCredit = DebitCredit::find($id);

        if ($DebitCredit == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $DebitCredit->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("DebitCredits/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('debit_credit')
                    ->select(
                    	'debit_credit.id', 'debit_credit.signs', 'debit_credit.detail',
                    	'debit_credit.amount', 'debit_credit.cost',
                    	'debit_credit.cost_currency_id', 'debit_credit.currency_id',
                    	'debit_credit.company_id',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'debit_credit.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('debit_credit.company_id', $request->company_id);
  		}

		$DebitCredits = $query->get();

  		return Datatables::of($DebitCredits)->make(true);
  	}

}

?>