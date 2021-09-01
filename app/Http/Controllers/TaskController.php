<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
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
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
    	$project = $this->getFromApi('GET', 'projects/'.session('project_id'));
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
    	$requirements = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));
    	//$tasks = $this->getFromApi('GET', 'tasks?project_id='.session('project_id'));
    	$holidays = $this->getFromApi('GET', 'holidays?country_id='.$company->city->data->country_id.'&company_id='.$company->id);
    	$holidaysForGantt = '';
    	foreach ($holidays as $holiday)
    	{
    		$holidaysForGantt .= '#'.date('m', strtotime($holiday->date)).'_'.date('d', strtotime($holiday->date)).'#';
    	}

      return view('task/index', [
        'users'        => $users,
        //'tasks'        => $tasks,
        'requirements' => $requirements,
        'project' => $project,
        'holidaysForGantt' => $holidaysForGantt
      ]);
    }


    public function export(Request $request)
    {
       
      $project = $this->getFromApi('GET', 'projects/'.session('project_id'));
      $contracts = $this->apiCall('GET', 'contracts?project_id=' . session('project_id'));
      $contracts = json_decode($contracts->getBody()->__toString(), TRUE);
      $contract= $contracts['data'];
 
      \Excel::create('Gantt', function($excel) {


        $excel->sheet('Table_Tasks', function($sheet) {
          $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
          $project = $this->getFromApi('GET', 'projects/'.session('project_id'));


          $tasks = $this->getFromApi('GET', 'tasks/index_export?project_id='.session('project_id'));
          $sheet->fromArray(json_decode( json_encode($tasks), true));
        });
         // Our first sheet
        $excel->sheet('Table_Human_Resources', function($sheet) {
          $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');

          $project_human_resources = $this->getFromApi('GET', 'users/index_export?company_id='.$company->id);
          $sheet->fromArray(json_decode( json_encode($project_human_resources), true));

        });

        $excel->sheet('Table_Resources', function($sheet) {
          $project_services = $this->getFromApi('GET', 'services/index_export');
          $project_materials = $this->getFromApi('GET', 'materials/index_export');
          $project_expenses = $this->getFromApi('GET', 'expenses/index_export');

          $sheet->fromArray(json_decode( json_encode(array_merge($project_services,$project_materials,$project_expenses)), true));
        });

        $excel->sheet('Table_Assigments_HR', function($sheet) {
          $project_resources = $this->getFromApi('GET', 'task_resources/index_export?project_id='.session('project_id'));
          $sheet->fromArray(json_decode( json_encode(($project_resources)), true));
        });

        $excel->sheet('Table_Assigments', function($sheet) {
          $project_services = $this->getFromApi('GET', 'task_services/index_export?project_id='.session('project_id'));
          $project_materials = $this->getFromApi('GET', 'task_materials/index_export?project_id='.session('project_id'));
          $project_expenses = $this->getFromApi('GET', 'task_expenses/index_export?project_id='.session('project_id'));
          $sheet->fromArray(json_decode( json_encode(array_merge($project_services,$project_materials,$project_expenses)), true));
        });
      })->export('xls');
    }


      public function import()
    {

       return response()->json([
            'view' => view('task/import')->render()
        ]);
    }

    public function do_import(Request $request)
    {
      $array = array();
      try {
        $validator =Validator::make($request->all(), [
          'file' => 'required'
        ]);
        $file = $request->file('file');
        $path = $file->getRealPath();
        $data = \Excel::load($path)->get();

        $user = $this->getFromApi('GET', 'users/'.Auth::id());
        $arrayRes=array();
        //Tasks
        foreach ($data[0] as $row) {
          array_push($arrayRes, $this->import_taks($row));
        }

        //Human Resources
        foreach ($data[1] as $row) {
          if(strtolower($user->email)!=strtolower($row->email)){
            array_push($arrayRes, $this->import_taks_HR($row));
          }
        }

        //Resources
        foreach ($data[2] as $row) {
          array_push($arrayRes, $this->import_taks_Resources($row));     
        }

        //Assigment Human Resources
        foreach ($data[3] as $row) {
          array_push($arrayRes, $this->import_taks_Assigment_HR($row));
        }

        //Assigment Resources
        foreach ($data[4] as $row) {
          array_push($arrayRes, $this->import_taks_Assigment_Resources($row));
        }
             
      } catch (Exception $exception) {
        session()->flash('message', 'Error with format file');
        session()->flash('alert-class', 'error');
        return response()->json(array('success' => false, 'message' => 'Error with format file'));
      }
      session()->flash('message', __('general.added'));
      session()->flash('alert-class', 'success');
      //return response()->json();
      // return $arrayRes;
      $resarray = array_search('false', array_column($arrayRes, 'success')); 

      if ($resarray!=false) {
        return response()->json(array('success' => false, 'message' => 'Error with format file, please Review and import Again'));
      }
      return response()->json(array('success' => true));
    }


    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

  			'description' => 'required',
  			'project_id'  => 'required',
  			'start_date'  => 'required',
  			'due_date'  => 'required',
  			'phase'       => 'required'
	    ]);

    	if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
      } $data = $request->all();

    	$res = $this->apiCall('POST', 'tasks', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$task = $this->getFromApi('GET', 'tasks/'.$id);
    	$project = array();
    	if(session()->has('project_id')){
            $project = $this->getFromApi('GET', 'projects/'.session('project_id'));
        }

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);
    	$requirements = $this->getFromApi('GET', 'requirements?project_id='.session('project_id'));

    	return response()->json([
    		'view' => view('task/edit', [
				'task'  => $task,
				'project'  => $project,
				'users' => $users,
				'requirements' => $requirements,
    		] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'description'     => 'required',
			'phase'     => 'required',
            'start_date'  => 'required',
            'due_date'  => 'required',
	    ]);
    	if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
		  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'tasks/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.requirement_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.updated'));
        session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
    	$res = $this->apiCall('DELETE', 'requirements/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	session()->flash('message', __('api_errors.delete'));
        session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.delete')]
	    	)->validate();

    	}
    	else
    	{
    		session()->flash('message', __('general.deleted'));
        session()->flash('alert-class', 'success');
    	}

    	return redirect()->action('RequirementController@index');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'requirements/'.$id);
    	$company = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('task/show', ['company' => $company] )->render(),
    	]);
    }

    public function import_taks($row)
    {
      $item = array();
      $item['project_id']= session('project_id');
      $item['index']=   $row->index==NULL ? 0: $row->index;
      //    $item['requirement_id']=   NULL;
      $item['duration']=  $row->duration;
      $item['start_is_milestone']=  $row->start_is_milestone;
      $item['end_is_milestone']=  $row->end_is_milestone;
      $item['duration']=  $row->duration;
      $item['description']=  $row->description;
      $item['start_date']=  $row->start_date;
      $item['due_date']=  $row->due_date;
      $item['progress']=  $row->progress;
      $item['depends']=  $row->depends;

       $item['estimated_hours']=  $row->estimated_hours;
      $item['burned_hours']=  $row->burned_hours;

      $item['status']=  $row->status;
      $item['priority']=  $row->priority;
      $item['business_value']=  $row->business_value;
      $item['phase']=  $row->phase;
      $item['version']=  $row->version;
      $item['release']=  $row->release;
      $item['label']=  $row->label;
      $item['comments']=  $row->comments;
      $item['level']=  $row->level==NULL ? 0: $row->level;
      $item['status']=  $row->status==NULL ? 'STATUS_ACTIVE': $row->status;
      //   return $item;
      $validator =Validator::make($item, [
        'description'     => 'required',
        'phase'     => 'required',
        'start_date'  => 'required',
        'due_date'  => 'required',
      ]);

      if ($validator->fails()) {
          return response()->json($validator->errors(), 422);
      } 

      $task = $this->getFromApi('GET', 'tasks?index='.$item['index'].'&description='.$item['description'].'&level='.$item['level']);
                   // 
      if(!empty($task))
      {
        $taksUnique =json_decode(json_encode($task),TRUE)[0];
        //return $item;//.$taksUnique['id'];
        $res = $this->apiCall('POST', 'tasks/'.$taksUnique['id'], $item);
      }else{
        $res =  $this->apiCall('POST', 'tasks', $item);
      }

      if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
                {
        return array('success' => false, 'message' => 'Error with format file','data' => json_decode($res->getBody()->__toString(), TRUE)['error']);
 
      }else{
        return array('success' => true, 'message' => '','data' => '');
      }
    }

    public function import_taks_HR($row)
    {
      $item = array();
      $item['email']= $row->email;
      $item['name']= $row->name;
      $item['password']= $row->email;
      $item['address']=   $row->address;
      $item['office_phone']=  $row->office_phone;
      $item['home_phone']=  $row->home_phone;
      $item['cell_phone']=  $row->cell_phone;
      //City
      $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

      $res = $this->getFromApi('GET', 'cities?name='.$row->city_name.'&company_id='.$company->id);
      if(!empty($res))
      {
        $city =json_decode(json_encode($res),TRUE)[0];
      }else{

      }
      $item['city_id']=  $city['id'];
      ///////////////
      //Office
      $res = $this->getFromApi('GET', 'offices?title='.$row->office_name.'&company_id='.$company->id);
      if(!empty($res))
      {
        $office =json_decode(json_encode($res),TRUE)[0];
      }else{
 
      }
      $item['office_id']= $office['id'];
      ///////////////
      //Rol
      $res = $this->getFromApi('GET', 'company_roles?title='.$row->role_name.'&company_id'.$company->id);
      if(!empty($res))
      {
        $rol =json_decode(json_encode($res),TRUE)[0];
      }else{
 
      }
      $item['company_role_id']=  $rol['id'];
      ///////////////

      //Project Rol
      $res = $this->getFromApi('GET', 'project_roles?title='.$row->project_role_name.'&company_id='.$company->id);
      if(!empty($res))
      {
        $project_role =json_decode(json_encode($res),TRUE)[0];
      }else{
 
      }
      $item['project_role_id']=  $project_role['id'];
      ///////////////
      //Seniority
      $res = $this->getFromApi('GET', 'seniorities?title='.$row->seniority.'&company_id='.$company->id);
      if(!empty($res))
      {
        $seniorities =json_decode(json_encode($res),TRUE)[0];

      }else{
 
      }
      $item['seniority_id']=  $seniorities['id'];
      ///////////////

      //Seniority
      $res = $this->getFromApi('GET', 'workgroups?title='.$row->workgroup_title.'&company_id='.$company->id);
      if(!empty($res))
      {
        $workgroup_title =json_decode(json_encode($res),TRUE)[0];
      }else{
 
      }
      $item['workgroup_id']=  $workgroup_title['id'];
      ///////////////

      $item['workplace']=  $row->workplace==NULL?'offshore':$row->workplace;
      $item['hours_by_day']=  $row->hours_by_day==NULL?0:$row->hours_by_day;

      $validator =Validator::make($item, [
        'name' => 'required',
        'email' => 'required',
        'office_id' => 'required',
        'seniority_id' => 'required',
        'city_id' => 'required',
        'workgroup_id' => 'required',
      ]);
      if ($validator->fails()) {
//                        return response()->json($validator->errors(), 422);
      return $validator->errors();
      } 

      $user = $this->getFromApi('GET', 'users?name='.$item['name']);

      if(!empty($user))
      {
      $userUnique =json_decode(json_encode($user),TRUE)[0];

      $res = $this->apiCall('PATCH', 'users/'.$userUnique['id'], $item);
      }else{
       $res =  $this->apiCall('POST', 'users', $item);
      }
      if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
                {
        return array('success' => false, 'message' => 'Error with format file','data' => json_decode($res->getBody()->__toString(), TRUE)['error']);
 
      }else{
        return array('success' => true, 'message' => '','data' => '');
      }
    }

    public function import_taks_Resources($row)
    {
      $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=city');
      $item = array();
      $item['reimbursable']= $row->reimbursable==NULL?1:$row->reimbursable;
      $item['detail']= $row->detail;
      $item['amount']=   $row->amount;
      $item['cost']=  $row->cost;
      $item['company_id']=  $company->id;
      //Currencies
      $res = $this->getFromApi('GET', 'currencies?name='.$row->currency_name);
      if(!empty($res))
      {
        $currencies =json_decode(json_encode($res),TRUE)[0];
      }else{

      }
      $item['currency_id']=  $currencies['id'];
      $item['cost_currency_id']=  $currencies['id'];

      $type_res="";
      if($row->type=='Material'){

        $resources = $this->getFromApi('GET', 'materials?detail='.$item['detail'].'&company_id='.$company->id);
        $type_res="materials";
      }
      if($row->type=='Expense'){
        $resources = $this->getFromApi('GET', 'expenses?detail='.$item['detail'].'&company_id='.$company->id);
        $type_res="expenses";
      }
      if($row->type=='Service'){
        $resources = $this->getFromApi('GET', 'services?detail='.$item['detail'].'&company_id='.$company->id);
        $type_res="services";
      }

      $validator =Validator::make($item, [

        'detail'      => 'required',
        'amount'        => 'numeric|required',
        'company_id'  => 'required',
        'currency_id' => 'required'
      ]);

      if ($validator->fails()) {
        return $validator->errors();
      //return false;
      }
      //return json_decode(json_encode($resources),TRUE);

      if(!empty($resources)){
        $resourcesUnique =json_decode(json_encode($resources),TRUE)[0];
        $res = $this->apiCall('PATCH', $type_res.'/'.$resourcesUnique['id'], $item);
      }else{
        $res = $this->apiCall('POST', $type_res, $item);
      }
      // validacion de la respuesta del api
      if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
      {
        return array('success' => false, 'message' => 'Error with format file','data' => json_decode($res->getBody()->__toString(), TRUE)['error']);
 
      }else{
        return array('success' => true, 'message' => '','data' => '');
      }
    }

    public function import_taks_Assigment_HR($row)
    {
      $item = array();
      $item['rate']= $row->rate==NULL?0:$row->rate;
      $item['quantity']= $row->quantity==NULL?0:$row->quantity;
            
 
      $res = $this->getFromApi('GET', 'tasks?index='.$row->index);  
      if(!empty($res))
      {
        $task =json_decode(json_encode($res),TRUE)[0];
      }else{
        return ($row->index);   
      }       
      $item['task_id']=  $task['id'];

      $res = $this->getFromApi('GET', 'users?name='.$row->user_name);
      if(!empty($res))
      {
        $user =json_decode(json_encode($res),TRUE)[0];
      }else{

      }       
      $item['user_id']=  $user['id'];
      $res = $this->getFromApi('GET', 'project_roles?title='.$row->project_role_title.'&company_id='.$company->id);
      if(!empty($res))
      {
        $project_role =json_decode(json_encode($res),TRUE)[0];

      }else{

      }
       //Seniority
   
      $item['project_role_id']=  $project_role['id'];

      $res = $this->getFromApi('GET', 'seniorities?title='.$row->seniority.'&company_id='.$company->id);
      if(!empty($res))
      {
        $seniorities =json_decode(json_encode($res),TRUE)[0];

      }else{

      }
      $item['seniority_id']=  $seniorities['id'];

      //Currencies
      $res = $this->getFromApi('GET', 'currencies?name='.$row->currency_name);
      if(!empty($res))
      {
        $currencies =json_decode(json_encode($res),TRUE)[0];

      }else{

      }
      $item['currency_id']=  $currencies['id'];

      $taks_resource = $this->getFromApi('GET', 'task_resources?user_id='.$user['id'].'&task_id='.$task['id']);

   
      $validator =Validator::make($item, [

        'task_id' => 'required',
        'project_role_id' => 'required',
        'seniority_id' => 'required',
        'rate' => 'numeric|required',
        'currency_id' => 'required',
        // 'workplace'       => 'required',
        'quantity' => 'required',
        // 'load'            => 'required'
      ]);

      if ($validator->fails()) {
        return $validator->errors();
        // return false;
      } 
      if(!empty($taks_resource)){
        $resourcesUnique =json_decode(json_encode($taks_resource),TRUE)[0];
        $res = $this->apiCall('PATCH', 'task_resources/'.$resourcesUnique['id'], $item);
      }else{
        $res = $this->apiCall('POST', 'task_resources', $item);
      }

      if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
      {
        return array('success' => false, 'message' => 'Error with format file','data' => json_decode($res->getBody()->__toString(), TRUE)['error']);

      }else{
        return array('success' => true, 'message' => '','data' => '');
      }

    }

    public function import_taks_Assigment_Resources($row)
    {

      $item = array();
      $item['reimbursable']= $row->reimbursable==NULL?1:$row->reimbursable;
      $item['detail']= $row->detail;
      $item['amount']=   $row->amount==NULL?0:$row->amount;
      $item['cost']=  $row->cost==NULL?0:$row->cost;

      $res = $this->getFromApi('GET', 'tasks?index='.$row->index);  
      if(!empty($res))
      {
        $task =json_decode(json_encode($res),TRUE)[0];
      }else{
        return ($row->index);   
      }       
      $item['task_id']=  $task['id'];
      //Currencies
      $res = $this->getFromApi('GET', 'currencies?name='.$row->currency_name);
      if(!empty($res))
      {
        $currencies =json_decode(json_encode($res),TRUE)[0];

      }else{

      }
      $item['currency_id']=  $currencies['id'];

      $type_res="";
      if($row->type=='Material'){

        $resources = $this->getFromApi('GET', 'task_materials?task_id='.$task['id']);
        $type_res="task_materials";
      }
      if($row->type=='Expense'){
        $resources = $this->getFromApi('GET', 'task_expenses?task_id='.$task['id']);
        $type_res="task_expenses";
      }
      if($row->type=='Service'){
        $resources = $this->getFromApi('GET', 'task_services?task_id='.$task['id']);
        $type_res="task_services";
      }

      $validator =Validator::make($item, [
        'detail'      => 'required',
        'amount'        => 'numeric|required',
        'currency_id' => 'required'
      ]);

      if ($validator->fails()) {
        return $validator->errors();
        //return false;
      }
      if(!empty($resources)){
        $resourcesUnique =json_decode(json_encode($resources),TRUE)[0];

        $res = $this->apiCall('PATCH', $type_res.'/'.$resourcesUnique['id'], $item);

      }else{
        $res = $this->apiCall('POST', $type_res, $item);
      }
      // validacion de la respuesta del api
      if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
      {
        return array('success' => false, 'message' => 'Error with format file','data' => json_decode($res->getBody()->__toString(), TRUE)['error']);

      }else{
        return array('success' => true, 'message' => '','data' => '');
      }
    }
}
