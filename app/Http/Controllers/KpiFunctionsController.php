<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Validator;

class KpiFunctionsController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);

    }

    /**
     * Muestra listado
     */
    public function index($category_kpi='')
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' .Auth::id());
        //$indicadores= $this->getFromApi('GET', 'kpis/indicadores?company_id=' . $company->id.'&project_id='.session('project_id'));


        $kpis = $this->getFromApi('GET', 'kpis?company_id=' . $company->id);

        $categories = $this->getFromApi('GET', 'kpis_category?company_id=' . $company->id);


        $return =[
            'kpis' => $kpis,
            'categories' => $categories,
            'category_kpi'=>$category_kpi,
        ];

    /*    foreach ($indicadores as $clave => $valor){
            $return[$clave]=$valor;
        }*/
        //var_dump($return);
        return view('kpi_functions/index', $return);
    }





}
