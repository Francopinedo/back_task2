<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ContractRowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra listado
     */
    public function index($contract_id)
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$contract = $this->getFromApi('GET', 'contracts/'.$contract_id);
    	$currency = $this->getFromApi('GET', 'currencies/'.$contract->currency_id);

        return view('contract_row/index', [
			'company'  => $company,
			'currency'  => $currency,
			'contract'  => $contract
        ]);
    }

    public function pdf($contract_id)
    {
        $data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $data['contract']   = $this->getFromApi('GET', 'contracts/'.$contract_id);
        $data['project']   = $this->getFromApi('GET', 'projects/'.$data['contract']->project_id);

        $data['customer']   = $this->getFromApi('GET', 'customers/'.$data['project']->customer_id);
        $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['contract']->currency_id);
        $data['exchange_rates'] = $this->getFromApi('GET', 'exchange_rates/?company_id='. $data['company']->id);


        $data['invoice_resources']   = $this->getFromApi('GET', 'contract_resources/?contract_id='.$contract_id);
        $data['invoice_services']   = $this->getFromApi('GET', 'contract_services/?contract_id='.$contract_id);
        $data['invoice_materials']   = $this->getFromApi('GET', 'contract_materials/?contract_id='.$contract_id);
        $data['invoice_expenses']   = $this->getFromApi('GET', 'contract_expenses/?contract_id='.$contract_id);



        $pdf = \PDF::loadView('contract_row/pdf', $data);
        //$pdf->setPaper('A4', 'landscape');
        return $pdf->download('contract.pdf');
    }


}
