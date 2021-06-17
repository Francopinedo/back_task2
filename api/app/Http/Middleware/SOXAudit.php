<?php

namespace App\Http\Middleware;


use Closure;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\Http\Events\RequestHandled;

use Illuminate\Http\Response as LaravelResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

use Illuminate\Http\Request;

use DB;
use Illuminate\Routing\Router;
use Carbon\Carbon;

use App\Models\Settings;
use Transformers\SettingsTransformer;
use App\Models\Auditlog;
use Transformers\AuditlogTransformer;


class SOXAudit
{



    public function handle($request, Closure $next)
    {

	$Settings =  Settings::select('*')->first();

	if($Settings->system_log=='1')

	{
	$now = Carbon\Carbon::now();	
	$new_setting = Settings::create([
	'date_action'=>$now->toDateString(),
	'process_name'=>'CRUD '.  str_replace('Controller','', $request->route()->parameters['controller']),
	'action_name'=>$request->route()->getAction(),	
	'user_id'=>isset($request->user_id)?$request->user_id:'',
	'user_comment'=>'LOG for '.$request->route()->getAction(),
	'reason'=>'LOG for '.$request->route()->getAction(),
	'business_rule'=>'',
	'customer_id'=>isset($request->customer_id)?$request->customer_id:'',
	'project_id'=>isset($request->project_id)?$request->project_id:'',
	'role'=>isset($request->user_id)?\App\Role::find(\App\RoleUser::where('user_id',$request->user_id)->first()->role_id)->name:'',
	]);
	
	}

	if($Settings->sox_audit_log=='1')

	{
	
	$now = Carbon\Carbon::now();	
	$new_setting = Settings::create([
	'date_action'=>$now->toDateString(),
	'process_name'=>'CRUD '.  str_replace('Controller','', $request->route()->parameters['controller']),
	'action_name'=>$request->route()->getAction(),	
	'user_id'=>isset($request->user_id)?$request->user_id:'',
	'user_comment'=>'LOG for '.$request->route()->getAction(),
	'reason'=>'LOG for '.$request->route()->getAction(),
	'business_rule'=>'',
	'customer_id'=>isset($request->customer_id)?$request->customer_id:'',
	'project_id'=>isset($request->project_id)?$request->project_id:'',
	'role'=>isset($request->user_id)?\App\Role::find(\App\RoleUser::where('user_id',$request->user_id)->first()->role_id)->name:'',
	]);
	
	}


         return $next($request);
    }

    

}
