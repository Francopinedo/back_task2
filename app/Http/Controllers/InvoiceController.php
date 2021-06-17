<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$currencies = $this->getFromApi('GET', 'currencies');

		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

		$contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
		$project = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');



        return view('invoice/index', [
			'currencies' => $currencies,
			'company'    => $company,
			'contacts'   => $contacts,
			'project'    => $project
        ]);
    }

    /**
     * Muestra listado de rows
     */
    public function rows($invoice_id)
    {
    	$data['invoice_id'] = $invoice_id;
    	$data['currencies'] = $this->getFromApi('GET', 'currencies');
        $data['invoice']   = $this->getFromApi('GET', 'invoices/'.$invoice_id);
		$data['company'] = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
		$data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
		$data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
        $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['invoice']->currency_id);
		$data['countRows'] = $this->getFromApi('GET', 'invoices/'.$invoice_id.'/count_rows');

        return view('invoice/rows', $data);
    }

    /**
     * Genera factura pdf
     */
    public function pdf($invoice_id)
    {
        $data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $data['invoice']   = $this->getFromApi('GET', 'invoices/'.$invoice_id);
        $data['project']   = $this->getFromApi('GET', 'projects/'.$data['invoice']->project_id);
        $contratos   = $this->getFromApi('GET', 'contracts?project_id='.$data['project']->id);
        $data['contract']=$contratos[0];
        $data['customer']   = $this->getFromApi('GET', 'customers/'.$data['project']->customer_id);
        $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['invoice']->currency_id);
        $data['exchange_rates'] = $this->getFromApi('GET', 'exchange_rates?company_id='. $data['company']->id);


        $data['invoice_resources']   = $this->getFromApi('GET', 'invoice_resources?invoice_id='.$invoice_id);
        $data['invoice_services']   = $this->getFromApi('GET', 'invoice_services?invoice_id='.$invoice_id);
        $data['invoice_materials']   = $this->getFromApi('GET', 'invoice_materials?invoice_id='.$invoice_id);
        $data['invoice_expenses']   = $this->getFromApi('GET', 'invoice_expenses?invoice_id='.$invoice_id);
        $data['invoice_taxes']   = $this->getFromApi('GET', 'invoice_taxes?invoice_id='.$invoice_id);
        $data['invoice_discounts']   = $this->getFromApi('GET', 'invoice_discounts?invoice_id='.$invoice_id);
  $data['invoice_debit']   = $this->getFromApi('GET', 'invoice_debit_credit?invoice_id='.$invoice_id.'&signs=+');
        $data['invoice_credit']   = $this->getFromApi('GET', 'invoice_debit_credit?invoice_id='.$invoice_id.'&signs=-');


        $dataupdate=array('emited'=>true);

        $this->apiCall('PATCH', 'invoices/'.$invoice_id, $dataupdate);


        $pdf = \PDF::loadView('invoice/pdf', $data);
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->download('invoice.pdf');
    }


    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$invoice = $this->getFromApi('GET', 'invoices/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');

		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
		$contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

    	return response()->json([
    		'view' => view('invoice/edit', [
				'invoice'    => $invoice,
				'currencies' => $currencies,
				'contacts'   => $contacts
    		] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'project_id'  => 'required',
			'from'        => 'required',
			'to'          => 'required',
			'currency_id' => 'required',
			'due_date' => 'required',
			'contact_id'  => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();


        $data['emited']=false;
    	$res = $this->apiCall('POST', 'invoices', $data);

    	$result = json_decode($res->getBody()->__toString(), TRUE);
    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	//var_dump($jsonRes);
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.invoice_store')]
	    	)->validate();
    	}
    	else
    	{

    	    //echo $result['data']['id'];
    	    if($data['from_project_board']=='1'){
                 $result2= $this->apiCall('GET', 'invoices/' .$result['data']['id'].'/update_from_project_board');

            }
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json($result['data']);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'from'        => 'required',
			'to'          => 'required',
			'due_date'          => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'invoices/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.invoice_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.updated'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
    	$res = $this->apiCall('DELETE', 'invoices/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	session()->flash('message', __('api_errors.delete'));
			session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.delete')]
	    	)->validate();

    	}
    	else
    	{
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect()->back();
    }
}
