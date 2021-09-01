<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class WhatIfTaskRowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index($task_id)
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$task = $this->getFromApi('GET', 'whatif_task/'.$task_id);

        return view('whatif_task_row/index', [
			'company'  => $company,
			'task'  => $task
        ]);
    }

}
