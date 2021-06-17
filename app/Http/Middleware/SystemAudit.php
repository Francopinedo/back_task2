<?php

namespace App\Http\Middleware;


use Closure;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use DB;
use Illuminate\Routing\Router;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Contracts\Auth\Guard;

// Para consumir APIs
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;


class SystemAudit
{

 

    public function handle($request, Closure $next)
    {



		$client = new GuzzleHttpClient();
			$params['http_errors'] = false;
			$params['timeout'] = 300;

			$url = env('API_PATH').'settings';

			$res = $client->request('GET', $url, $params);

			$Settings = json_decode($res->getBody()->__toString(), TRUE)['data'];

	if($Settings[0]['system_log']==1)

	{
		try{
//				 \Log::info('System LOG');
//		 \Log::info(Carbon::now());
			$now = Carbon::now();	
			$currentAction=\Route::getRoutes()->match($request)->action;

			if($currentAction!='')
			{
				$controller=\Route::getRoutes()->match($request)->uri;
				if(isset($currentAction['controller']))	{	
					$method=explode('@',$currentAction['controller'])[1];
					$table_name=explode('/',\Route::getRoutes()->match($request)->uri)[0];
				}else{
					$method='login';
				}
			}else{
				$controller='';
				$method='';
			}
			if($method!='login' || $method!='index' || $method!='show'  || $method!='create'|| $method!='edit'|| $method!='select' || $method!='forContracts' || $method!='rawDirectory'|| $method!='forProjectSelection') {
		
				$data['date_action'] = $now->toDateTimeString();
				$data['process_name'] =$controller;
				$data['action_name'] =$method;
				$data['user_id'] =isset($request->user_id)?$request->user_id:Auth::id();
				$data['user_name'] =isset($request->user_id)?\App\User::find($request->user_id)->name: 
				empty(Auth::id())?\App\User::find(Auth::id())->name:'';
				$data['user_comment'] ='SYSTEM LOG';
				$data['action'] =$method;
				$data['table_name'] =$table_name;
				$data['reason'] = isset($request->reason) ? $request->reason : 'LOG '.$method;
				$data['business_rule'] ='';
				$data['customer_id'] =isset($request->customer_id)?$request->customer_id:(session('customer_id'))?session('customer_id'):'';
				$data['project_id'] =isset($request->project_id)?$request->project_id:(session('project_id'))?session('project_id'):'';
				$data['role'] =isset($request->user_id)?\App\Role::find(\App\RoleUser::where('user_id',$request->user_id)->first()->role_id)->name: (Auth::user())? \App\Role::find(\App\RoleUser::where('user_id',Auth::user()->id)->first()->role_id)->name: 'N/A';


				$client2 = new GuzzleHttpClient();
		    	$params2 = ['form_params' => $data];
				$params2['http_errors'] = false;
				$params2['timeout'] = 300;
		    	$res=$client2->request('POST', env('API_PATH').'audit_log', $params2);
	    	
				$jsonres=json_decode($res->getBody()->__toString(), TRUE);
					//$res = $client->request('POST', env('API_PATH').'audit_log', $data);
				//\Log::info($jsonres);

			}


		 // validacion de la respuesta del api
     
	
		}catch(\Exception $ex)
		{
			\Log::info($ex);
		}
	}




         return $next($request);
    }

    

}
