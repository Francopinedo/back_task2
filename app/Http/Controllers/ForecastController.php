<?php

namespace App\Http\Controllers;

use App\Project;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ForecastController extends Controller
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
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $data['company'] = $company;

        $data['project'] = $this->getFromApi('GET', 'projects/' . session('project_id'));
        $data['contracts'] = $this->getFromApi('GET', 'contracts?project_id=' . session('project_id'));
        $data['departments'] = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        $data['users'] = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $data['currencies'] = $this->getFromApi('GET', 'currencies');
        return view('forecast/index', $data);
    }

    public function pdf(Request $request)
    {

        $currency_id = $request->currency_id;

        $data = array();
        $data['currency'] = $this->getFromApi('GET', 'currencies/' . $currency_id);

        $begin = $request->period_from;
        $end = $request->period_to;

        $project_id = $request->project_id;
        $company_id = $request->company_id;
        $customer_id = $request->customer_id;

        $contract_id = $request->contract_id;
        $monthsarray = array();
        $data['teams'] = array();
        $data['materials'] = array();
        $data['services'] = array();
        $data['expenses'] = array();

        $start = explode('-', $begin);
        $end2 = explode('-', $end);
        $startYear = intval($start[0]);
        $endYear = intval($end2[0]);
        $quarth = '';



        $totalprofit =0;
        $totalrevenue =0;
        $totalcost =0;
        $totalmargin =0;

        for ($i = $startYear; $i <= $endYear; $i++) {
            $endMonth = $i != $endYear ? 11 : intval($end2[1]) - 1;
            $startMon = $i === $startYear ? intval($start[1]) - 1 : 0;
            $span = 3;
            $contador = 0;
            for ($j = $startMon; $j <= $endMonth; $j = $j > 12 ? $j % 12 || 11 : $j + 1) {

                $total_revenue_month = 0;
                $total_cost_month = 0;
                $total_profit_month = 0;
                $total_margin_month = 0;

                $month = $j + 1;
                $displayMonth = $month < 10 ? '0' . $month : $month;
                $value = join('-', [$i, $displayMonth, '01']);

                $date = new DateTime($value);


                $beforequart = $quarth;
                $quarth = $date->format('M Y');
                $complete_date_end = join('-', [$i, $displayMonth, '31']);
                if ($contador == 0) {
                    $value = $begin;
                }
                if ($j == $endMonth) {
                    $complete_date_end = $end;
                }
                $contador++;
                $data['quarthers'][] = $date->format('M Y');
                $data['months'][] = $date->format('M Y');
  $urlparams ='?currency_id=' . $currency_id.'&period_from=' . $value . '&period_to=' . $complete_date_end . '&project_id=' .
$project_id . '&company_id=' . $company_id . '&customer_id=' . $customer_id . '&contract_id=' . $contract_id ;

                 // echo $urlparams;
                $item = $this->getFromApi('GET', 'forecast/team' . $urlparams);
                $data['teams'][] = $item;
                $real_revenue_nf = (isset($item->real_revenue_nf)) ? $item->real_revenue_nf : 0;
                $real_cost_nf = (isset($item->real_cost_nf)) ? $item->real_cost_nf : 0;
                $total_revenue_month = $total_revenue_month + $real_revenue_nf;
                $total_cost_month = $total_cost_month + $real_cost_nf;


                $item = $this->getFromApi('GET', 'forecast/materials' . $urlparams);
                $data['materials'][] = $item;
                $real_revenue_nf = (isset($item->real_revenue_nf)) ? $item->real_revenue_nf : 0;
                $real_cost_nf = (isset($item->real_cost_nf)) ? $item->real_cost_nf : 0;
                $total_revenue_month = $total_revenue_month + $real_revenue_nf;
                $total_cost_month = $total_cost_month + $real_cost_nf;


                $item = $this->getFromApi('GET', 'forecast/services' . $urlparams);
                $data['services'][] = $item;

                $real_revenue_nf = (isset($item->real_revenue_nf)) ? $item->real_revenue_nf : 0;
                $real_cost_nf = (isset($item->real_cost_nf)) ? $item->real_cost_nf : 0;
                $total_revenue_month = $total_revenue_month + $real_revenue_nf;
                $total_cost_month = $total_cost_month + $real_cost_nf;

                $item = $this->getFromApi('GET', 'forecast/expenses' . $urlparams);
                $data['expenses'][] = $item;

                $real_revenue_nf = (isset($item->real_revenue_nf)) ? $item->real_revenue_nf : 0;
                $real_cost_nf = (isset($item->real_cost_nf)) ? $item->real_cost_nf : 0;
                $total_revenue_month = $total_revenue_month + $real_revenue_nf;
                $total_cost_month = $total_cost_month + $real_cost_nf;


                $total_profit_month = $total_revenue_month - $total_cost_month;
                if($total_margin_month >0){
                $total_margin_month = $total_cost_month < 0 ? 0 : ($total_profit_month / $total_cost_month) * 100;
                }else{
                    $total_margin_month =0;
                }
                $totalcost=$totalcost+$total_cost_month;
                $totalrevenue=$totalrevenue+$total_revenue_month;

                $class_total_profit_month = $total_profit_month < 0 ? 'red' : 'green';
                $class_total_margin_month = $total_margin_month < 0 ? 'red' : 'green';

                $tot = array('total'=>$total_profit_month, 'class'=>$class_total_profit_month);
                $data['total_profit_month'][]= $tot;
                $tot = array('total'=>$total_margin_month, 'class'=>$class_total_margin_month);
                $data['total_margin_month'][] = $tot;

            }
        }

        $totalprofit= $totalrevenue-$totalcost;
        $totalmargin= $totalcost<=0?0:($totalprofit/$totalcost)*100;

        $data['totalprofit']=$totalprofit;
        $data['totalmargin']=$totalmargin;

        $pdf = \PDF::loadView('forecast/pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('forecast.pdf');
    }


}
