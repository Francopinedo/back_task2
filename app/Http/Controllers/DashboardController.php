<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {

            $company = $this->getFromApi('GET', 'companies/fromUser/' . \Auth::id());
            if(empty($company))
            {
                return view('dashboard.index');
            }
    	$categories = $this->getFromApi('GET', 'dashboard_category?company_id='.$company->id.'&withdashboard=1');


        $kpis = $this->getFromApi('GET', 'dashboard?company_id=' . $company->id.'&showdashboard=1');


        $kpiscount=count($kpis);
       
         return view('dashboard.index',compact('kpis','kpiscount','categories'));
         
        }catch(Exception $ex)
        {
        echo $ex;
        }
            }
        }
