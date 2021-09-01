<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectBoardGanttController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
		$data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

        return view('project_board_gantt/index', $data);
    }

}
