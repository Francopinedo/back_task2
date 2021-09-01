<?php

namespace App\Http\Controllers;

use App\Wiki;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Validator;

class WikiController extends Controller
{
	public function __construct() {
		$this->middleware(['auth','systemaudit', 'loglevel']);
	}

  public function index() 
  {
  	if(!Auth::guest()){
    	$wiki = $this->getFromApi('GET', 'wiki');

      $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
      $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
      $projects = $this->getFromApi('GET', 'projects?company_id=' . $company->id);

    	// return $wiki;
    	return view('wiki/index', [
    		'wiki' => $wiki,
        'customers' => $customers,
        'projects' => $projects,
        'company' => $company,
    	]);
  	}
  }

  /**
  * Tomar datos en especifico
  */
  public function show($id)
  {
    $wiki = $this->getFromApi('GET', 'wiki/'.$id);
    $project = $this->getFromApi('GET', 'projects/'.$wiki->project_id);
    $customer = $this->getFromApi('GET', 'customers/'.$wiki->customer_id);

    $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
    $project_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');

    foreach ($project_managers as $manager) {
      if($project->project_manager_id == $manager->id){
        $project_manager = $manager;
      }
    }
    return response()->json([
      'view' => view('wiki/show', [
        'wiki'=> $wiki,
        'project' => $project,
        'customer' => $customer,
        'project_manager' => $project_manager
      ])->render()
    ]);
  }

  /**
  * Crear nuevo
  */
  public function store(Request $request)
  {
  	// validacion del formulario
  	$validator =Validator::make($request->all(), [
	  	'customer_id'					  => 'required',
	  	'project_id'            => 'required',
	  	'process_group_code'  	=> 'required',
	  	'knowledge_code'				=> 'required',
	  	'swot_code'							=> 'required',
	  	'explanation'						=> 'required',
	  	'action_taken'					=> 'required',
	  	'additionals_comments' 	=> 'required',
    ]);
    $file = $request->file('attached_file');
		if ($validator->fails()) {
	    return response()->json($validator->errors(), 422);
	  }

    $data = $request->all();
    $data['attached_file'] = ($file!=null || $file!='') ? $file->getClientOriginalName() : '';
    $data['user_id'] = Auth::user()->id;
    $res = $this->apiCall('POST', 'wiki', $data);
    // validacion de la respuesta del api
    if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
      $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
      Validator::make($jsonRes,
        ['status_code' => [Rule::in(['201', '200'])]],
        ['in' => __('api_errors.wiki_store')]
      )->validate();
    }else {
      $prov=array();
      $prov=json_decode($res->getBody(), true);
      $destinationPath = "assets/img/wiki/". $prov['data']['id'].'/';

      if ($file!=null || $file!='') {
        $file->move(($destinationPath), $file->getClientOriginalName());

      }

    	session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    }

    return response()->json();
	}

	/**
	* Form para editar
	* @param  int $id ID
	*/
  public function edit($id)
  {
  	$wiki = $this->getFromApi('GET', 'wiki/'.$id);
  	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

  	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
    $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);

  	return response()->json([
  		'view' => view('wiki/edit', [
			'wiki'   => $wiki,
      'projects' => $projects,
      'customers' => $customers,
      'company' => $company
		] )->render()
  	]);
  }

  /**
  * Actualizo
  */
  public function update(Request $request)
  {
    $wiki = Wiki::find($request->id);
    // validacion del formulario
    $validator =Validator::make($request->all(), [
      'customer_id'           => 'required',
      'project_id'            => 'required',
      'process_group_code'    => 'required',
      'knowledge_code'        => 'required',
      'swot_code'             => 'required',
      'explanation'           => 'required',
      'action_taken'          => 'required',
      'additionals_comments'  => 'required',
    ]);
    $file = $request->file('attached_file');

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    } 
    $data = $request->all();
    $data['attached_file'] =($file!=null || $file!='') ? $file->getClientOriginalName() : $wiki->attached_file;
    $data['user_id'] = Auth::user()->id;
    $res = $this->apiCall('PATCH', 'wiki/' . $data['id'], $data);
    $destinationPath = "assets/img/wiki/". $request->id.'/';

    File::deleteDirectory($destinationPath);//Eliminar archivo existente para luego agregar nuevo archivo

    if($file!=null || $file!='') {
      $file->move(($destinationPath), $file->getClientOriginalName());
    }


    // validacion de la respuesta del api
    if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
      $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
      Validator::make($jsonRes,
        ['status_code' => [Rule::in(['201', '200'])]],
        ['in' => __('api_errors.wiki_store')])->validate();
      } else {
      session()->flash('message', __('general.updated'));
      session()->flash('alert-class', 'success');
    }

    return response()->json();
  }


  // public function upload(Request $request, $id)
  // {
  //   try {
  //     var_dump($request);
  //     $file = $request->file('attached_file');

  //     $data = $request->all();
  //     $data['attached_file'] = !isNull($file) ? $file->getClientOriginalName() : '';

  //     $destinationPath = "assets/img/wiki/" . $id.'/';
      
  //     if($file!=null || $file!='') {
  //       $file->move(($destinationPath), $file->getClientOriginalName());
  //     }
  //   }
  //   catch (FileException $exception) {
  //     return response()->json(array('success' => false, 'message' => 'Error uplading file'));
  //   }

  //   return response()->json(array('success' => true));
  // }

  /**
  * Elimina
  * @param  int $id ID
  */
  public function delete($id)
  {
    $res = $this->apiCall('DELETE', 'wiki/' . $id);
    // validacion de la respuesta del api
    if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
      session()->flash('message', __('api_errors.delete'));
      session()->flash('alert-class', 'danger');

      $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
      Validator::make($jsonRes,
          ['status_code' => [Rule::in(['201', '200'])]],
          ['in' => __('api_errors.delete')]
      )->validate();

    } else {
      $path = 'assets/img/wiki/' . $id;
      File::deleteDirectory($path);
      
      session()->flash('message', __('general.deleted'));
      session()->flash('alert-class', 'success');
    }

    return redirect()->action('WikiController@index');
  }

  //Descargar Datos en pdf
  public function pdf($wiki_id)
  {
    $data['wiki'] = $this->getFromApi('GET', 'wiki/'.$wiki_id);
    $data['project'] = $this->getFromApi('GET', 'projects/'.$data['wiki']->project_id);
    $data['customer']   = $this->getFromApi('GET', 'customers/'.$data['wiki']->customer_id);

    //Consultas para extraer datos de project manager
    $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
    $project_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
    //Tomando datos de project manager
    foreach ($project_managers as $manager) {
      if($data['project']->project_manager_id == $manager->id){
        $data['project_manager'] = $manager;
      }
    }

    $pdf = \PDF::loadView('wiki/pdf', $data);
    // $pdf->setPaper('A4', 'landscape');
    return $pdf->stream('wiki.pdf');
  }

}


