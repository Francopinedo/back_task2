<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTasks()
    {
        $company        = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
        $project        = $this->getFromApi('GET', 'projects/'.session('project_id'));
        $users          = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $requirements   = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));
        $tasks          = $this->getFromApi('GET', 'tasks?project_id='.session('project_id'));

        foreach ($tasks as $index => $task) {
            $start = explode('-', $task->start_date);
            $diff = Carbon::create($start[0],$start[1],$start[2])->diffInDays();
            $result = (($diff * 8) / $task->estimated_hours) * 100;
            $real_prog = ($task->burned_hours/$task->estimated_hours)*100;
            $task->progress =$real_prog;

            if ($result > 100) {
                $result = 100;
            } else if($result < 0){
                $result = 0;
            }
            if($result < $task->progress || ($result == 100 and $task->progress == 100)){
                $task->color = 'green';
            }else if($result > $task->progress){
                $task->color = 'red';
            }else{
                $task->color = 'yellow';
            }

             if ($real_prog > 100) {
                $real_prog = 100;
            } else if($real_prog < 0){
                $real_prog = 0;
            }
            if($real_prog < $task->progress || ($result == 100 and $task->progress == 100)){
                $task->color = 'green';
            }else if($result > $task->progress){
                $task->color = 'red';
            }else{
                $task->color = 'yellow';
            }
            $task->real_progress = $real_prog;

            $task->estimated_progress = $result;

        }

        $response = (object) array(
            'users'         => $users,
            'tasks'         => $tasks,
            'requirements'  => $requirements,
            'project'       => $project,
        );


        return view('reports.tasks.index', [
            'response' => $response
        ]);
    }

    public function pdf()
    {
        $company        = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
        $project        = $this->getFromApi('GET', 'projects/'.session('project_id'));
        $users          = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $requirements   = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));
        $tasks          = $this->getFromApi('GET', 'tasks?project_id='.session('project_id'));

        foreach ($tasks as $index => $task) {
            $start = explode('-', $task->start_date);
            $diff = Carbon::create($start[0],$start[1],$start[2])->diffInDays();
            $result = (($diff * 8) / $task->estimated_hours) * 100;
            $real_prog = ($task->burned_hours/$task->estimated_hours)*100;
            $task->progress =$real_prog;

            if ($result > 100) {
                $result = 100;
            } else if($result < 0){
                $result = 0;
            }
            if($result < $task->progress || ($result == 100 and $task->progress == 100)){
                $task->color = 'green';
            }else if($result > $task->progress){
                $task->color = 'red';
            }else{
                $task->color = 'yellow';
            }

             if ($real_prog > 100) {
                $real_prog = 100;
            } else if($real_prog < 0){
                $real_prog = 0;
            }
            if($real_prog < $task->progress || ($result == 100 and $task->progress == 100)){
                $task->color = 'green';
            }else if($result > $task->progress){
                $task->color = 'red';
            }else{
                $task->color = 'yellow';
            }
            $task->real_progress = $real_prog;

            $task->estimated_progress = $result;

        }
        $response = (object) array(
            'users'         => $users,
            'tasks'         => $tasks,
            'requirements'  => $requirements,
            'project'       => $project,
        );
      
        $data['company'] = $company;
        $data['customer'] = $this->getFromApi('GET', 'customers/' . session('customer_id'));
        $data['project'] = $this->getFromApi('GET', 'projects/' . session('project_id'));

 
        $data['response']=$response;

        $pdf = \PDF::loadView('reports.tasks.pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('task_report.pdf');
        //return view('reports.tasks.pdf', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTicketsByTask($id)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);
        $task = $this->getFromApi('GET', 'tasks/'.$id);

        return view('reports.tickets.index', [
            'users'  => $users,
            'contacts'  => $contacts,
            'task'  => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
