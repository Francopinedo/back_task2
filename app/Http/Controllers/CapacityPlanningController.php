<?php

namespace App\Http\Controllers;

use App\Project;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Validator;


class CapacityPlanningController extends Controller
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
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $data['company'] = $company;
        $data['project'] = $this->getFromApi('GET', 'projects/' . session('project_id'));

        if (is_object($data['project'])) {
            $data['contracts'] = $this->getFromApi('GET', 'contracts/?project_id' . $data['project']->id);
        }

        if (isset($data['contracts'])) {


            $s = explode(':', $data['contracts'][0]->workinghours_from);
            $e = explode(':', $data['contracts'][0]->workinghours_to);
            $hours = $e[0] - $s[0];

            $data['hours'] = $hours;
        }

        $data['customers'] = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        $data['workgroups'] = $this->getFromApi('GET', 'workgroups?company_id=' . $company->id);


        // $data['contracts'] = $this->getFromApi('GET', 'contracts?company_id='.$company->id);
        $data['departments'] = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        //$data['users'] = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $data['users'] = $this->getFromApi('GET', 'users?company_id=' . $company->id);

        return view('capacity_planning/index', $data);
    }


    public function excel(Request $request)
    {




        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $from = $request->period_from;
        $to = $request->period_to;
        $customer_id = $request->customer;
        $project = $request->project;
        $workgroup_id = $request->workgroup;
        $report_label = $request->report_label;


        $data = array();
        $data['report_label'] = $report_label;
        $data['company'] = $company;
        $data['customer'] = $this->getFromApi('GET', 'customers/' . $customer_id);
        $data['project'] = $this->getFromApi('GET', 'projects/' . $project);

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


        $result = $this->getFromApi('GET', 'capacity_planning/datatables/?customer=' . $customer_id . '&project='
            . $project . '&length=-1' . "&company=" . $company->id . '&period_from=' . $from . '&period_to=' . $to . '&workgroup=' . $workgroup_id .
            '&draw=1&start=0');

        $data['data'] = $result;
        $data['period_from'] = $from;
        $data['period_to'] = $to;


        $excel = Excel::create('New file', function ($excel) use ($data) {
            $excel->sheet('New sheet', function ($sheet) use ($data) {


                $sheet->setOrientation('landscape');

                $sheet->appendRow(array(
                    __('capacity_planning.customer_name'), $data['customer']->name, __('capacity_planning.projects'),
                    $data['project']->name, __('capacity_planning.workgroup'), isset($data['workgroup']) ? $data['workgroup']->title : ''
                ));


                $workinghours = $data['hours'] . " Hours ";
                $workinghours2 ='';
                if (isset($data['contract_working_hours'])) {
                    $workinghours2 =  $data['contract_working_hours'][0]->workinghours_from . " - "
                        . $data['contract_working_hours'][0]->workinghours_to;
                }

                $sheet->appendRow(array(
                    __('capacity_planning.period_from'), $data['period_from'], __('capacity_planning.period_to'),
                    $data['period_to'], __('capacity_planning.contract_working_hours'),
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
                    __('users.name'), __('capacity_planning.working_hours'), __('capacity_planning.replacements_hours'),
                    __('capacity_planning.absents')
                , __('capacity_planning.holidays'), __('capacity_planning.hours_available'),
                    __('capacity_planning.hours_asigned'), __('capacity_planning.efective_capacity')
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
                    __('capacity_planning.totals_availabe_text'), $total_hours_available
                ));
                $sheet->appendRow(array(
                    __('capacity_planning.totals_asigned_text'), $total_hours_asigned
                ));
                $sheet->appendRow(array(
                    __('capacity_planning.totals_availabe_text'), $total_efective_capacity
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

        $excel->setFilename('capacity_planning')->export('xls')->download('xls');
    }

    public function pdf(Request $request)
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $from = $request->period_from;
        $to = $request->period_to;
        $customer_id = $request->customer;
        $project = $request->project;
        $workgroup_id = $request->workgroup;
        $report_label = $request->report_label;


        $data = array();
        $data['report_label'] = $report_label;
        $data['company'] = $company;
        $data['customer'] = $this->getFromApi('GET', 'customers/' . $customer_id);
        $data['project'] = $this->getFromApi('GET', 'projects/' . $project);

        if (!empty($workgroup_id)) {
            $data['workgroup'] = $this->getFromApi('GET', 'workgroups/' . $workgroup_id);
        }

        if (is_object($data['project'])) {
            $data['contracts'] = $this->getFromApi('GET', 'contracts/?project_id' . $data['project']->id);
        }

        if (isset($data['contracts'])) {


            $s = explode(':', $data['contracts'][0]->workinghours_from);
            $e = explode(':', $data['contracts'][0]->workinghours_to);
            $hours = $e[0] - $s[0];

            $data['hours'] = $hours;
        }


        $data['period_from'] = $from;
        $data['period_to'] = $to;

        $result = $this->getFromApi('GET', 'capacity_planning/datatables/?customer=' . $customer_id . '&project='
            . $project . '&length=-1' . "&company=" . $company->id . '&period_from=' . $from . '&period_to=' . $to . '&workgroup=' . $workgroup_id .
            '&draw=1&start=0');
        // var_dump($result[0]->name);
        $data['result'] = $result;


        $pdf = \PDF::loadView('capacity_planning/pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('capacity_planning.pdf');
    }


}
