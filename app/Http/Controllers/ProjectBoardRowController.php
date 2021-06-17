<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectBoardRowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
		$data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());


        $data['currencies'] = $this->getFromApi('GET', 'currencies');
        $data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
    


		if (!empty(session('project_id')))
		{

            $data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
            $data['contracts'] = $this->getFromApi('GET', 'contracts?project_id='.session('project_id').'');
			
            $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['contracts'][0]->currency_id);
			$data['countRows'] = $this->getFromApi('GET', 'projects/'.session('project_id').'/count_rows');
		}

        return view('project_board_row/index', $data);
    }
	
	   public function pdf()
    {
		   

		      
		if (!empty(session('project_id')))
		{
		$data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

            $data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
            $data['contracts'] = $this->getFromApi('GET', 'contracts?project_id='.session('project_id').'');
            $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['contracts'][0]->currency_id);
			$data['countRows'] = $this->getFromApi('GET', 'projects/'.session('project_id').'/count_rows');
	        $data['customer']   = $this->getFromApi('GET', 'customers/'.$data['project']->customer_id);
       $data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
       
	   $data['tasks']   = $this->getFromApi('GET', 'tasks?project_id='.$data['project']->id);


        $data['exchange_rates'] = $this->getFromApi('GET', 'exchange_rates?company_id='. $data['company']->id);




        $data['project_board_resources']   = $this->getFromApi('GET', 'project_resources?project_id='.session('project_id'));

        $data['project_board_services']   = $this->getFromApi('GET', 'project_services?project_id='.session('project_id').'&grouped=1');

        $data['project_board_materials']   = $this->getFromApi('GET', 'project_materials?project_id='.session('project_id').'&grouped=1');

        $data['project_board_expenses']   = $this->getFromApi('GET', 'project_expenses?project_id='.session('project_id'));

        $data['project_board_taxes']   = $this->getFromApi('GET', 'project_taxes?project_id='.session('project_id'));

        $data['project_board_discounts']   = $this->getFromApi('GET', 'project_discounts?project_id='.session('project_id'));

          $data['project_board_debit']   = $this->getFromApi('GET', 'debit_credit?project_id='.session('project_id').'&signs=+');
            $data['project_board_credit']   = $this->getFromApi('GET', 'debit_credit?project_id='.session('project_id').'&signs=-');
//	var_dump($data['project_board_resources'] );
//			die;
				$data['resources_select']=empty($data['project_board_resources'])?0:1;
				$data['expenses_select']=empty($data['project_board_expenses'])?0:1;//$expenses_select;
				$data['services_select']=empty($data['project_board_services'])?0:1;//$services_select;
				$data['materials_select']=empty($data['project_board_materials'])?0:1;//$materials_select;
                $data['debit']=empty($data['project_board_debit'])?0:1;//$materials_select;
                $data['credit']=empty($data['project_board_credit'])?0:1;//$materials_select;


 return view('project_board_row/pdf', $data);
				//$pdf = \PDF::loadView('project_board_row/pdf', $data);
					//$pdf->setPaper('A4', 'landscape');
				//	return $pdf->download('project_board_row.pdf');


			
		}
	   
	    }

}
