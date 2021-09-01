<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectRowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index($project_id)
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$kpis = $this->getFromApi('GET', 'kpis?company_id='.$company->id);
    	$project = $this->getFromApi('GET', 'projects/'.$project_id);

        return view('project_row/index', [
            'project_id'=>$project_id,
			'company'  => $company,
			'project'  => $project,
			'kpis'  => $kpis,
        ]);
    }

}
