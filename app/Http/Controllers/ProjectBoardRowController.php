<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectBoardRowController extends Controller
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
		$data['company']   = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        $data['currencies'] = $this->getFromApi('GET', 'currencies');
        $data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
        $data['contracts'] = [];
		if (!empty(session('project_id')))
		{

            $data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');
            $data['contracts'] = $this->getFromApi('GET', 'contracts/?project_id='.session('project_id').'');
            $data['currency'] = $this->getFromApi('GET', 'currencies/'.$data['contracts'][0]->currency_id);
			$data['countRows'] = $this->getFromApi('GET', 'projects/'.session('project_id').'/count_rows');
		}

        return view('project_board_row/index', $data);
    }

}
