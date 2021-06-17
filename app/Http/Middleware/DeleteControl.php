<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;

class DeleteControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $client = new GuzzleHttpClient();
        $params['http_errors'] = false;
        $params['timeout'] = 300;

        // Settings
        $url_settings = env('API_PATH').'settings';
        $res = $client->request('GET', $url_settings, $params);
        $Settings = json_decode($res->getBody()->__toString(), TRUE)['data'];

        if($Settings[0]['system_log']==1 && $Settings[0]['sox_audit_log']==1) {
            $now = Carbon::now();
            $currentAction=\Route::getRoutes()->match($request)->action;
            // Obtener metodo y controlador a ejecutar
            if($currentAction!='')
            {
                $controller=\Route::getRoutes()->match($request)->uri;

                if(isset($currentAction['controller'])) {   
                    $method=explode('@',$currentAction['controller'])[1];

                    $Controlador=explode('/',\Route::getRoutes()->match($request)->uri)[0];
                    $name_table=explode('/',\Route::getRoutes()->match($request)->uri)[0];

                }else{
                    $method='login';
                }
            }else{
                $controller='';
                $method='';
            }
            
            // Se tomaran los datos de proyecto y contrato y se asignaran en respectivas variables
            // project_status, project_finish, contracth_finish_date
            if($method == 'download' || $method == 'delete') {
                
                // Datos de la tabla que esta siendo eliminado
                $url_tabla = env('API_PATH').$name_table.'/'.$request->id;
                $ress = $client->request('GET', $url_tabla, $params);
                $datos = json_decode($ress->getBody()->__toString(), TRUE)['data'];

                // Consultando datos
                if ($Controlador != 'contract_resources' && $Controlador != 'contract_expenses' && $Controlador != 'contract_services' && $Controlador != 'contract_materials') {
                    // Consultando datos de tabla Project
                    if($Controlador == 'projects') {
                        $project_status = $datos['status'];
                        $project_finish = $datos['finish'];
                    } else {
                        
                        $url_project = env('API_PATH').'projects/'.$datos['project_id'];
                        $res_project = $client->request('GET', $url_project, $params);
                        $project = json_decode($res_project->getBody()->__toString(), TRUE)['data'];

                        $project_status = $project['status'];
                        $project_finish = $project['finish'];
                    }

                    // Consultando datos de tabla Contract
                    if ($Controlador == 'contracts') {
                        $contract_finish_date = $datos['finish_date'];
                    } else {
                        if($Controlador == 'projects'){
                            $url_contract = env('API_PATH').'contracts?project_id='.$datos['id'];
                        }else{
                            $url_contract = env('API_PATH').'contracts?project_id='.$project['id'];
                        }
                        $res_contract = $client->request('GET', $url_contract, $params);
                        $contract = json_decode($res_contract->getBody()->__toString(), TRUE)['data'];

                        $contract_finish_date = $contract[0]['finish_date'];
                    }

                } else {
                    $url_contract = env('API_PATH').'contracts/'.$datos['contract_id'];
                    $res_contract = $client->request('GET', $url_contract, $params);
                    $contract = json_decode($res_contract->getBody()->__toString(), TRUE)['data'];

                    $contract_finish_date = $contract['finish_date'];
                }
            }

            // Validando si el contrato o proyecto esten activos
            if ($method == 'delete') { // Cualquier item que esta siendo eliminado
                
                // Si se trata de eliminar un sprints
                if ($Controlador == 'sprints') {
                    if ($datos['task_status'] != 'Completed' && $datos['time_status'] != 'Finished' ) {
                        session()->flash('message', __('general.deleted_item'));
                        session()->flash('alert-class', 'danger');
                        
                        return redirect()->back();
                    }
                }else if($Controlador == 'contract_resources' || $Controlador =='contract_expenses' || $Controlador == 'contract_services' || $Controlador == 'contract_materials'){
                    if($contract_finish_date >= $now->toDateString()){
                        
                        session()->flash('message', __('general.deleted_item'));
                        session()->flash('alert-class', 'danger');
                        
                        return redirect()->back();
                    }
                } else {
                    if ($project_status != 'Closing' && $project_finish >= $now->toDateString() || $contract_finish_date >= $now->toDateString()){

                        session()->flash('message', __('general.deleted_item'));
                        session()->flash('alert-class', 'danger');
                        
                        return redirect()->back();
                    }
                }

            }else if($method == 'download') { // Exclusivamente solo si es Proyecto o Contrado que se esta eliminando antes se activa el metodo download
                
                if ($contract_finish_date >= $now->toDateString() || $project_status != 'Closing' && $project_finish >= $now->toDateString()) {
                    session()->flash('message', __('general.delete_project_contract'));
                    session()->flash('alert-class', 'danger');
                    return redirect()->back();
                }
                
            }
        }
        
        return $next($request);
    }
}
