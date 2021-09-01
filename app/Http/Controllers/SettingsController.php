<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class SettingsController extends Controller
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
    	$settings = $this->getFromApi('GET', 'settings');


    	        return view('settings/edit' , [
			'settings'   => $settings[0],

        ]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request,$id)
    {
    	

//    	if ($validator->fails()) {
//    return response()->json($validator->errors(), 422);
//  } 
		
		if(!empty($request['chat_server_enable']) && $request['chat_server_enable']=='on' )
		   {
			$request->merge(['chat_server_enable'=>'1']);
		   }else{
		   	$request->merge(['chat_server_enable'=>'0']);
		   }
		if(!empty($request['mail_server_enable']) && $request['mail_server_enable']=='on' )
		   {
			$request->merge(['mail_server_enable'=>'1']);
		   }else{
		   	$request->merge(['mail_server_enable'=>'0']);
		   }
		if(!empty($request['plugins_enabled']) && $request['plugins_enabled']=='on' )
		   {
			$request->merge(['plugins_enabled'=>'1']);
		   }else{
		   	$request->merge(['plugins_enabled'=>'0']);
		   }
		if(!empty($request['payments_enabled']) && $request['payments_enabled']=='on' )
		   {
			$request->merge(['payments_enabled'=>'1']);
		   }else{
		   	$request->merge(['payments_enabled'=>'0']);
		   }
		if(!empty($request['wiki_enabled']) && $request['wiki_enabled']=='on' )
		   {
			$request->merge(['wiki_enabled'=>'1']);
		   }else{
		   	$request->merge(['wiki_enabled'=>'0']);
		   }
		if(!empty($request['payment_integration']) && $request['payment_integration']=='on' )
		   {
			$request->merge(['payment_integration'=>'1']);
		   }else{
		   	$request->merge(['payment_integration'=>'0']);
		   }
			if(!empty($request['digital_signature']) && $request['digital_signature']=='on' )
		   {
			$request->merge(['digital_signature'=>'1']);
		   }else{
		   	$request->merge(['digital_signature'=>'0']);
		   }
			if(!empty($request['cloud_storage']) && $request['cloud_storage']=='on' )
		   {
			$request->merge(['cloud_storage'=>'1']);
		   }else{
		   	$request->merge(['cloud_storage'=>'0']);
		   }
			if(!empty($request['task_creation_email']) && $request['task_creation_email']=='on' )
		   {
			$request->merge(['task_creation_email'=>'1']);
		   }else{
		   	$request->merge(['task_creation_email'=>'0']);
		   }
			if(!empty($request['fields_add_feature']) && $request['fields_add_feature']=='on' )
		   {
			$request->merge(['fields_add_feature'=>'1']);
		   }else{
		   	$request->merge(['fields_add_feature'=>'0']);
		   }
			if(!empty($request['alfred_active']) && $request['alfred_active']=='on' )
		   {
			$request->merge(['alfred_active'=>'1']);
		   }else{
		   	$request->merge(['alfred_active'=>'0']);
		   }
			if(!empty($request['field_captions']) && $request['field_captions']=='on' )
		   {
			$request->merge(['field_captions'=>'1']);
		   }else{
		   	$request->merge(['field_captions'=>'0']);
		   }

		   if(!empty($request['process_group_active']) && $request['process_group_active']=='on' )
		   {
			$request->merge(['process_group_active'=>'1']);
		   }else{
		   	$request->merge(['process_group_active'=>'0']);
		   }

		   		   if(!empty($request['knowledge_areas_active']) && $request['knowledge_areas_active']=='on' )
		   {
			$request->merge(['knowledge_areas_active'=>'1']);
		   }else{
		   	$request->merge(['knowledge_areas_active'=>'0']);
		   }
		
		
		$data = $request->all();
        $data['log_level'] = json_encode($data['log_level']);
		
    	$res = $this->apiCall('POST', 'settings/'.$id, $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.service_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.updated'));
			session()->flash('alert-class', 'success');
    	}

    	$settings = $this->getFromApi('GET', 'settings');
	
    return redirect()->back();
    }

}
