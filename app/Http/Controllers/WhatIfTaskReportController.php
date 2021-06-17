<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WhatIfTaskReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
        $project = $this->getFromApi('GET', 'projects/'.session('project_id'));
        $users = $this->getFromApi('GET', 'users?company_id='.$company->id);
        $requirements = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));
        $tasks = $this->getFromApi('GET', 'whatif_task?project_id='.session('project_id'));

        $response = (object) array(
            'project'       => $project,
            'users'         => $users,
            'requirements'  => $requirements,
            'tasks'         => $tasks
        );

        return view('reports.tasks.index', [
            'response' => $response
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
