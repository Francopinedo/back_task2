<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class TaskRowController extends Controller
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
    	$task = $this->getFromApi('GET', 'tasks/'.$task_id);

        return view('task_row/index', [
			'company'  => $company,
			'task'  => $task
        ]);
    }

}
