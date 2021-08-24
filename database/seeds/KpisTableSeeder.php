<?php

use Illuminate\Database\Seeder;

class KpisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kpis')->insert([
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'Budgeted Cost of Work Performed.  Total PV * % of Completion.',
                'query' => '$PCW  * $PB',
                'graphic_type' => 'BAR',
                'nombre' => 'Earned Value',
                'kpi' => 'EV or BCWP',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'Actual Cost of Work Performed',
                'query' => '$AV',
                'graphic_type' => 'BAR',
                'nombre' => 'Actual Cost',
                'kpi' => 'AC or ACWP',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'ROI= (Ganancia del Proyecto - Costo del Proyecto) entre el Costo  del Proyecto',
                'query' => '($PF-$AV)/$AV',
                'graphic_type' => 'DONUT',
                'nombre' => 'Return Of Investment',
                'kpi' => 'ROI',
                'type_of_result' => 'PERCENT',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => '% of Work Completed per dollar spent . EV / AC. If > 1 ahead of schedule and/or under budget. <1 behind schedule and/or over budget.-',
                'query' => '$',
                'graphic_type' => 'BAR',
                'nombre' => 'Cost Perfomance Index',
                'kpi' => 'CPI',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'Work Performed against Work Scheduled. EV / PV. If > 1 ahead of schedule and/or under budget. <1 behind schedule and/or over budget.-',
                'query' => '$',
                'graphic_type' => 'BAR',
                'nombre' => 'Schedule Perfomance Index',
                'kpi' => 'SPI',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'Case 1 (you suppose your future perfomance will be the same than the actual one: PV/CPI. In the beginning of the project PV = EAC. Case 2 (you are over budget but wont happen again and you will continue with the planned cost estimated).  EAC = AC + (BAC – EV).   Case 3 (your are over budget, behind schedule but customer still requires to complete the project on time). EAC = AC + (BAC – EV)/(CPI*SPI).  Case 4 (This is the case when you find out that your cost estimate was flawed and you need to calculate the new cost estimate for the remaining project’s work.). EAC = AC + Bottom-up Estimate to Complete. The results from all of them are USD.-',
                'query' => '$',
                'graphic_type' => 'BAR',
                'nombre' => 'Estimate at Completion',
                'kpi' => 'EAC',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'PV-EAC. If the value < 1 may be over budget when it is complete. If the value > 1 your project may go under budget when it is complete. ',
                'query' => '$',
                'graphic_type' => 'BAR',
                'nombre' => 'Variance at Completion (VAC)',
                'kpi' => 'VAC',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'EV-PV. If < 1 behind schedule and/or over budget. If > 1 ahead of shedule and/or under budget.',
                'query' => '$',
                'graphic_type' => 'BAR',
                'nombre' => 'Schedule Variance',
                'kpi' => 'SV',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'Minimum Funds Needed if things do not get worse = PV/CPI',
                'query' => 'PV/CPI',
                'graphic_type' => 'BAR',
                'nombre' => 'Minimum Funds Needed',
                'kpi' => 'MFN ',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'PV / (CPI * SPI) .- Funds Need to finish the project with the actual level of slippage ',
                'query' => 'PV / (CPI * SPI)',
                'graphic_type' => 'BAR',
                'nombre' => 'Funds Need with the same level of slippage',
                'kpi' => 'FNSL ',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 1,
                'description' => 'RRR= ( 1+Nominal Rate / 1+Inflation Rate ) -1. Can be used to determine the effective return on an investment after adjusting for inflation.',
                'query' => '( 1+Nominal Rate / 1+Inflation Rate ) -1',
                'graphic_type' => '$',
                'nombre' => 'Real Rate Of Return',
                'kpi' => 'RRR',
                'type_of_result' => 'NUMERIC',
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => '% of missed milestones up to date. If this number is high may be is time to re-estime the efforts and process.',
                'query' => 'Milestones',
                'graphic_type' => NULL,
                'nombre' => 'Milestones',
                'kpi' => 'Milestones',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => 'Number of task that should have been started but  has been reescheduled (%). If it is high there may be some problem with the team capacity or others related issues to check.-',
                'query' => 'Activities',
                'graphic_type' => NULL,
                'nombre' => 'Activities',
                'kpi' => 'Activities',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => 'Number of commitments in the current sprint',
                'query' => 'Commitments',
                'graphic_type' => NULL,
                'nombre' => 'Commitments',
                'kpi' => 'Commitments',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => 'Tasks started but not finished on time',
                'query' => 'Overdue Tasks',
                'graphic_type' => NULL,
                'nombre' => 'Overdue Tasks',
                'kpi' => 'Overdue Tasks',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => 'Number of scope changes that were approved',
                'query' => 'Scope',
                'graphic_type' => NULL,
                'nombre' => 'Scope Changes',
                'kpi' => 'Scope',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => '% of Task Completed',
                'query' => 'Task Completed',
                'graphic_type' => NULL,
                'nombre' => 'Task Completed',
                'kpi' => 'Task Completed',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
            [
                'company_id' => 1,
                'category' => 2,
                'description' => 'Planned Hours Vs  Actual Hours',
                'query' => 'Planned Hours',
                'graphic_type' => NULL,
                'nombre' => 'Planned Hours',
                'kpi' => 'Planned Hours',
                'type_of_result' => NULL,
                'showkpi' => 1,
                'showdashboard' => 1
            ],
        ]);
    }
}
