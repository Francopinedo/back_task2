<?php

namespace App\Http\Controllers;

use Validator;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');
        $currencies = $this->getFromApi('GET', 'currencies');

        return view('contract/index', [
            'customers' => $customers,
            'engagements' => $engagements,
            'currencies' => $currencies,
            'company' => $company
        ]);
    }

    public function show($id)
    {
        $contract = $this->getFromApi('GET', 'contracts/'.$id);
        $project = $this->getFromApi('GET', 'projects/'.$contract->project_id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);
        return response()->json([
            'view' => view('contract/show', [
                'contract' => $contract,
                'project' => $project,
                'customer' => $customer
            ])->render()
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $contract = $this->getFromApi('GET', 'contracts/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $contract->customer_id);
        $currencies = $this->getFromApi('GET', 'currencies');
        return response()->json([
            'view' => view('contract/edit', [
                'contract' => $contract,
                'customers' => $customers,
                'engagements' => $engagements,
                'company' => $company,
                'currencies' => $currencies,
                'projects' => $projects
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

            'customer_id' => 'required',
            'currency_id' => 'required',
            'sow_number' => 'required',
            'date' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required',
            'engagement_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        $data = $request->all();

	   if($data['project_id']==""||$data['project_id']==0){

        	$Project= array();
        	$Project['start']=$data['start_date'];
        	$Project['finish']=$data['finish_date'];
        	$Project['customer_id']=$data['customer_id'];
        	$Project['name']="Project-".$data['sow_number'];
        	$Project['hours_by_day']=(new \Carbon\Carbon($data['workinghours_to']))->diff(new \Carbon\Carbon($data['workinghours_from']))->h;
        	$Project['name_convention']="";
        	$Project['holy_days']="";

        	$res = $this->apiCall('POST', 'projects', $Project);


            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                var_dump($jsonRes);
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.project_store')]
                )->validate();
            } else {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE);
                $requestProject = new Request($Project);
                // dd($jsonRes);
                app('App\Http\Controllers\ProjectController')->rawDirectory($requestProject, $jsonRes['data']['id']);


                $data['project_id']=$jsonRes['data']['id'];
            }


	   }else{
            $contracts = $this->apiCall('GET', 'contracts?project_id=' . $data['project_id']);
            $contracts = json_decode($contracts->getBody()->__toString(), TRUE);
            $contracts= $contracts['data'];

            if (sizeof($contracts) > 0 && $data['amendment_number'] == '') {
                Validator::make($data,
                    ['amendment_number' => 'required'])->validate();
                return response()->json();
            }


            if (sizeof($contracts) == 0 && $data['amendment_number'] != '') {
                Validator::make($data,
                    ['amendment_number' => 'max:0|nullable'])->validate();

                return response()->json();
            }

        }

        $res = $this->apiCall('POST', 'contracts', $data);
        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            var_dump($jsonRes);
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.contract_store')]
            )->validate();
        } else {

            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'customer_id' => 'required',
            'sow_number' => 'required',
            'currency_id' => 'required',
            'date' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        $data = $request->all();


        $contracts = $this->apiCall('GET', 'contracts?project_id=' . $data['project_id']);
        $contracts = json_decode($contracts->getBody()->__toString(), TRUE);
        $contracts= $contracts['data'];

        if (sizeof($contracts) > 0 && $data['amendment_number'] == '') {

            $validar = true;
            foreach ($contracts as $contract){
                if($contract['project_id']==$data['project_id']){
                    $validar= false;
                }
            }
            if($validar){
                Validator::make($data,
                    ['amendment_number' => 'required'])->validate();
                return response()->json();
            }

        }


        if (sizeof($contracts) == 0 && $data['amendment_number'] != '') {
            Validator::make($data,
                ['amendment_number' => 'max:0|nullable'])->validate();

            return response()->json();
        }


        $res = $this->apiCall('PATCH', 'contracts/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.contract_store')]
            )->validate();
        } else {


            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    public function download(Request $request)
    {
        $now = Carbon::now(); // Para manipular Hora y Fecha
        $contract = $this->getFromApi('GET', 'contracts/'.$request->id);
        $project = $this->getFromApi('GET', 'projects/' . $contract->project_id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);
        // Creando el archivo zip de backup para luego Descargarse
        $this->validate_download($project->id);


        $destinationPath = "app/public/repository/" . $customer->name . "/" . $project->name;

        if ($exists = Storage::disk('repository')->exists($customer->name . "/" . $project->name . "/".$customer->name."_".$project->name."_".$now->toDateString()."_".$now->toTimeString()."_repository.zip")) {  // archive is now downloadable ...
            return response()->download(storage_path($destinationPath . "/".$customer->name."_".$project->name."_".$now->toDateString()."_".$now->toTimeString()."_repository.zip"))->deleteFileAfterSend(true); 
            
        } else {

            return response()->json(array('error' => 'could not close zip file: '));
        }
    }

    private function addFolderToZip($dir, $zipArchive, $zipdir = '')
    {
      if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
          //Add the directory
          // echo $zipdir;
          if (!empty($zipdir)) $zipArchive->addEmptyDir($zipdir);
          // Loop through all the files
          while (($file = readdir($dh)) !== false) {
            //If it's a folder, run the function again!
            if (!is_file($dir . $file)) {
              $dir  = str_replace('\\', '/', $dir);
              // Skip parent and root directories
              if (($file !== ".") && ($file !== "..")) {
                $this->addFolderToZip($dir ."/". $file . "/", $zipArchive, $zipdir ."/". $file . "/");
              }
            } else {
              // Add the files
              $zipArchive->addFile($dir . $file, $zipdir . $file);
            }
          }
        }
      };
      return $zipArchive;
    }

    public function validate_download(Request $request)
    {

        $now = Carbon::now(); // Para manipular Hora y Fecha
        $contract = $this->getFromApi('GET', 'contracts/'.$request->id);
        $project = $this->getFromApi('GET', 'projects/' . $contract->project_id);
        $customer = $this->getFromApi('GET', 'customers/'.$contract->customer_id);

        $destinationPath = "app/public/repository/" . $customer->name . "/" . $project->name;
        $name_file = $customer->name . "_".$project->name."_".$now->toDateString()."_".$now->toTimeString()."_repository.zip";

        if (Storage::disk('repository')->has($customer->name . "/" . $project->name)) {

            // create a list of files that should be added to the archive.
            $directories = File::directories(storage_path($destinationPath));

            // define the name of the archive and create a new ZipArchive instance.
            $archiveFile = storage_path($destinationPath . "/".$name_file);
            $archive = new ZipArchive();
            // echo $destinationPath;

            if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                //$archive->addEmptyDir('test');
                // loop trough all the files and add them to the archive.
                $destination = $str = str_replace('\\', '/', $destinationPath);
                $archiveFile =  $this->addFolderToZip(storage_path($destination), $archive, $customer->name.'_'.$project->name."_".$now->toDateString()."_".$now->toTimeString().'_repository/');
                
                // close the archive.
                if ($archive->close() && Storage::disk('repository')->exists($customer->name . "/" . $project->name . "/".$name_file)) { 
                    // archive is now downloadable ...
                    return response()->download(storage_path($destinationPath . "/".$name_file))->deleteFileAfterSend(true);
                    //return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);
                } else {
                    return response()->json(array('error' => 'Empty repository'));
                }
            } else {
                return response()->json(array('error' => 'zip file could not be created: ' . $archive->getStatusString()));
            }
        } else {
            return response()->json(array('error' => 'Repository not found / Empty repository'));
        }
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete(Request $request)
    {
        $contract = $this->getFromApi('GET', 'contracts/'.$request->idcontract);
        $project = $this->getFromApi('GET', 'projects/' . $contract->project_id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);


        $res = $this->apiCall('DELETE', 'contracts/' . $request->idcontract);
        //Eliminar el proyecto que depende del contrato que esta siendo eliminado
        $this->apiCall('DELETE', 'projects/'.$project->id);

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

            $path = storage_path() . '/app/public/repository/' . $customer->name . "/" . $project->name;
            File::deleteDirectory($path);

            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->back();
    }

    // public function select(Request $request)
    // {
    // 	session(['project_id' => $request->id]);
    // 	session(['project_name' => $request->name]);

    // 	return response()->json();
    // }
}
