<?php

namespace App\Http\Controllers;

use App\Project;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Validator;


class RiskReportController extends Controller
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

     
        if (is_object($data['project'])) {
            $data['contracts'] = $this->getFromApi('GET', 'contracts?project_id' . $data['project']->id);
        }

        return view('risk_report/index', $data);
    }


    public function excel(Request $request)
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $from = $request->period_from;
        $to = $request->period_to;
        $sprint_from = $request->sprint_from;
        $sprint_to = $request->sprint_to;
        $customer_id = $request->customer;
        $project = $request->project;
        $workgroup_id = $request->workgroup;
        $report_label = $request->report_label;

        $data = array();
        $data['report_label'] = $report_label;
        $data['company'] = $company;
 
        $project_data = $this->getFromApi('GET', 'projects/' . $project);
        $data['customer'] = $this->getFromApi('GET', 'customers/' . $project_data->customer_id);
        $customer_id=$project_data->customer_id;

        $data['project']= $project_data;
 
        if (!empty($workgroup_id)) {
            $data['workgroup'] = $this->getFromApi('GET', 'workgroups/' . $workgroup_id);
        }

        $data['contract_working_hours'] = $this->getFromApi('GET', '/contracts?project_id=' . $project);

        if (isset($data['contract_working_hours'])) {

            $s = explode(':', $data['contract_working_hours'][0]->workinghours_from);
            $e = explode(':', $data['contract_working_hours'][0]->workinghours_to);
            $hours = $e[0] - $s[0];

            $data['hours'] = $hours;
        }

        $result = $this->getFromApi('GET', 'capacity_planning/datatables?customer=' . $customer_id . '&project='. $project . '&length=-1' . "&company=" . $company->id . '&period_from=' . $from . '&period_to=' . $to .'&sprint_from=' . $sprint_from . '&sprint_to=' . $sprint_to . '&workgroup=' . $workgroup_id .'&draw=1&start=0');

        $data['data'] = $result;
        $data['period_from'] = $from;
        $data['period_to'] = $to;

        $excel = Excel::create('New file', function ($excel) use ($data) {
            $excel->sheet('New sheet', function ($sheet) use ($data) {


                $sheet->setOrientation('landscape');

                $sheet->appendRow(array(
                    __('risk_report.customer_name'), $data['customer']->name, __('risk_report.projects'),
                    $data['project']->name, __('risk_report.workgroup'), isset($data['workgroup']) ? $data['workgroup']->title : ''
                ));


                $workinghours = $data['hours'] . " Hours ";
                $workinghours2 ='';
                if (isset($data['contract_working_hours'])) {
                    $workinghours2 =  $data['contract_working_hours'][0]->workinghours_from . " - "
                        . $data['contract_working_hours'][0]->workinghours_to;
                }

                $sheet->appendRow(array(
                    __('risk_report.period_from'), $data['period_from'], __('risk_report.period_to'),
                    $data['period_to'], __('risk_report.contract_working_hours'),
                    $workinghours.$workinghours2
                ));

                $sheet->appendRow(array(
                    ''
                ));

                $sheet->appendRow(array(
                    $data['report_label']
                ));
                $sheet->appendRow(array(
                    ''
                ));


                $sheet->appendRow(array(
                    __('users.name'), __('risk_report.working_hours'), __('risk_report.replacements_hours'),
                    __('risk_report.absents')
                , __('risk_report.holidays'), __('risk_report.hours_available'),
                    __('risk_report.hours_asigned'), __('risk_report.efective_capacity')
                ));

                $i = 7;

                $total_hours_available = 0;
                $total_hours_asigned = 0;
                $total_efective_capacity = 0;


                foreach ($data['data'] as $dato) {
                    // Append row as very last
                    $sheet->appendRow(array(
                        $dato->name, $dato->working_hours, $dato->absents_hours, $dato->replacements_hours,
                        $dato->holidays_hours, $dato->hours_available, $dato->hours_asigned, $dato->efective_capacity
                    ));

                    $total_hours_available = $total_hours_available + $dato->hours_available;
                    $total_hours_asigned = $total_hours_asigned + $dato->hours_asigned;


                    $sheet->cell('H' . $i, function ($cell) use ($dato) {

                        if ($dato->efective_capacity < 0) {
                            // manipulate the cell
                            $cell->setBackground('#f44336');
                        }
                        if ($dato->efective_capacity == 0) {
                            // manipulate the cell
                            $cell->setBackground('#ffeb3b');
                        }
                        if ($dato->efective_capacity > 0) {
                            // manipulate the cell
                            $cell->setBackground('#4caf50');
                        }


                    });


                    $i++;
                }


                $total_efective_capacity = $total_hours_available - $total_hours_asigned;

                $sheet->appendRow(array(
                    ''
                ));
                $sheet->appendRow(array(
                    __('risk_report.totals_availabe_text'), $total_hours_available
                ));
                $sheet->appendRow(array(
                    __('risk_report.totals_asigned_text'), $total_hours_asigned
                ));
                $sheet->appendRow(array(
                    __('risk_report.totals_availabe_text'), $total_efective_capacity
                ));

                $i = $i + 3;
                $sheet->cell('B' . $i, function ($cell) use ($total_efective_capacity) {
                    if ($total_efective_capacity < 0) {
                        // manipulate the cell
                        $cell->setBackground('#f44336');
                    }
                    if ($total_efective_capacity == 0) {
                        // manipulate the cell
                        $cell->setBackground('#ffeb3b');
                    }
                    if ($total_efective_capacity > 0) {
                        // manipulate the cell
                        $cell->setBackground('#4caf50');
                    }
                });
            });
        });

        \PHPExcel_Shared_File::setUseUploadTempDirectory(true);

        $excel->setFilename('risk_report')->export('xls')->download('xls');
    }

    public function pdf(Request $request)
    {
        try{
            $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $from = $request->period_from;
            $to = $request->period_to;
            $sprint_from = isset($request->sprint_from)?$request->sprint_from:'';
            $sprint_to = isset($request->sprint_to)?$request->sprint_to:'';
            $customer_id = $request->customer_id;
            $project = $request->project_id;
            $workgroup_id = $request->workgroup;
            $report_label = $request->report_label;

            $data = array();
            $data['report_label'] = $report_label;
            $data['company'] = $company;

            $project_data = $this->getFromApi('GET', 'projects/' . $project);
            $data['customer'] = $this->getFromApi('GET', 'customers/' . $project_data->customer_id);
            $customer_id=$project_data->customer_id;
            $data['project']= $project_data;
            if (!empty($workgroup_id)) {
                $data['workgroup'] = $this->getFromApi('GET', 'workgroups/' . $workgroup_id);
            }

            if (is_object($data['project'])) {
                $data['contracts'] = $this->getFromApi('GET', 'contracts?project_id' . $data['project']->id);
            }

            if (isset($data['contracts'])) {

                $s = explode(':', $data['contracts'][0]->workinghours_from);
                $e = explode(':', $data['contracts'][0]->workinghours_to);
                $hours = $e[0] - $s[0];

                $data['hours'] = $hours;
            }
            if (isset($data['sprints'])) {
                $sprint_s = explode(':', $data['sprints'][0]->start_date);
                $sprint_e = explode(':', $data['sprints'][0]->finish_date);
                $sprint_hours = $sprint_e[0] - $sprint_s[0];
                $data['sprint_hours'] = $sprint_hours;
            }

            $data['period_from'] = $from;
            $data['period_to'] = $to;

            $data['sprint_from'] = $sprint_from;
            $data['sprint_to'] = $sprint_to;
            $sprints="";
            if($sprint_from!='' && $sprint_to!=''){
                $sprints="&sprint_from=" . $sprint_from . "&sprint_to=" . $sprint_to ;
            }


            $result = $this->apiCall('GET', 'capacity_planning/pdf?customer=' . $customer_id . '&project='. $project . "&company=" . $company->id . '&period_from=' . $from . '&period_to=' . $to .$sprints. '&workgroup=' . $workgroup_id );

            $result_pdf=json_decode($result->getBody()->__toString(), TRUE);
            $data['result'] = $result_pdf;
            //return $data;
            $pdf = \PDF::loadView('risk_report/pdf', $data);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('risk_report.pdf');
    
        }catch(\Exception $ex){
            return $ex;
        }
    
    }


}
