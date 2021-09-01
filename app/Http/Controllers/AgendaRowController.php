<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class AgendaRowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index($agenda_id)
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$agenda = $this->getFromApi('GET', 'agendas/'.$agenda_id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

        return view('agenda_row/index', [
			'company'  => $company,
			'agenda'  => $agenda,
			'users'  => $users,
        ]);
    }

}
