<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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



        return view('quotation/index', [
			'currencies' => $currencies,
			'company'    => $company,
			'contacts'   => $contacts,
			'project'    => $project
        ]);
    }

    /**
     * Muestra listado de rows
     */
    public function rows($quotation_id)
    {
    	$data['quotation_id'] = $quotation_id;
    	$data['currencies'] = $this->getFromApi('GET', 'currencies');
        $data['quotation']   = $this->getFromApi('GET', 'quotation/'.$quotation_id);
		$data['company'] = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
		$data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
		$data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
        $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['quotation']->currency_id);
		$data['countRows'] = $this->getFromApi('GET', 'quotation/'.$quotation_id.'/count_rows');

        return view('quotation/rows', $data);
    }

    /**
     * Genera factura pdf
     */
    public function pdf($quotation_id)
    {
        $data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $data['quotation']   = $this->getFromApi('GET', 'quotation/'.$quotation_id);
        $data['project']   = $this->getFromApi('GET', 'projects/'.$data['quotation']->project_id);
        $data['contract']   = $this->getFromApi('GET', 'contracts/'.$data['project']->contract_id);
        $data['customer']   = $this->getFromApi('GET', 'customers/'.$data['project']->customer_id);
        $data['tasks']   = $this->getFromApi('GET', 'tasks/?project_id='.$data['project']->id);

        $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['quotation']->currency_id);
        $data['exchange_rates'] = $this->getFromApi('GET', 'exchange_rates/?company_id='. $data['company']->id);


        $data['quotation_resources']   = $this->getFromApi('GET', 'quotation_resources/?quotation_id='.$quotation_id);
        $data['quotation_services']   = $this->getFromApi('GET', 'quotation_services/?quotation_id='.$quotation_id.'&grouped=1');
        $data['quotation_materials']   = $this->getFromApi('GET', 'quotation_materials/?quotation_id='.$quotation_id.'&grouped=1');
        $data['quotation_expenses']   = $this->getFromApi('GET', 'quotation_expenses/?quotation_id='.$quotation_id);
        $data['quotation_taxes']   = $this->getFromApi('GET', 'quotation_taxes/?quotation_id='.$quotation_id);
        $data['quotation_discounts']   = $this->getFromApi('GET', 'quotation_discounts/?quotation_id='.$quotation_id);


        $dataupdate=array('emited'=>true);

        $this->apiCall('PATCH', 'quotation/'.$quotation_id, $dataupdate);


        $pdf = \PDF::loadView('quotation/pdf', $data);
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->download('quotation.pdf');
    }


    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$quotation = $this->getFromApi('GET', 'quotation/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');

		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
		$contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

    	return response()->json([
    		'view' => view('quotation/edit', [
				'quotation'    => $quotation,
				'currencies' => $currencies,
				'contacts'   => $contacts
    		] )->render()
    	]);
    }

    public function create(){

        $currencies = $this->getFromApi('GET', 'currencies');

        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        $project = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
        return response()->json([
            'view' => view('quotation/create', [
                'from_project_board'=>1,
                'company' => $company,
                'project' => $project,
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
    	$this->validate($request, [
			'project_id'  => 'required',
			'from'        => 'required',
			'to'          => 'required',
			'currency_id' => 'required',
			'due_date' => 'required',
			'contact_id'  => 'required'
	    ]);

    	$data = $request->all();


        $data['emited']=false;
    	$res = $this->apiCall('POST', 'quotation', $data);

    	$result = json_decode($res->getBody()->__toString(), TRUE);
    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.quotation_store')]
	    	)->validate();
    	}
    	else
    	{

    	    //echo $result['data']['id'];
    	    if($data['from_project_board']=='1'){
                 $result2= $this->apiCall('GET', 'quotation/' .$result['data']['id'].'/update_from_project_board');

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
    	$this->validate($request, [
			'from'        => 'required',
			'to'          => 'required',
			'due_date'          => 'required',
			'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'quotation/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.quotation_store')]
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
    	$res = $this->apiCall('DELETE', 'quotation/'.$id);

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

    	return redirect()->action('QuotationController@index');
    }
}
