<?php

namespace App\Http\Controllers;

use Validator;
use ZipArchive;
use App\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
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
        $data['company'] = $company;

        $data['customers'] = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        // $data['contracts'] = $this->getFromApi('GET', 'contracts?company_id='.$company->id);
        $data['departments'] = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        $data['users'] = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $data['project_managers'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
        $data['technical_directors'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Technical Director');
        $data['delivery_managers'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Delivery Manager');
        $data['engagements'] = $this->getFromApi('GET', 'engagements');
        return view('project/index', $data);
    }

    public function show($id)
    {
        $project = $this->getFromApi('GET', 'projects/'.$id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);
        return response()->json([
            'view' => view('project/show', [
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
        $project = $this->getFromApi('GET', 'projects/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        // $contracts = $this->getFromApi('GET', 'contracts?company_id='.$company->id);
        $departments = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');

        $project_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
        $technical_directors = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Technical Director');
        $delivery_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Delivery Manager');

        return response()->json([
            'view' => view('project/edit', [
                'project' => $project,
                'technical_directors' => $technical_directors,
                'delivery_managers' => $delivery_managers,
                'project_managers' => $project_managers,
                'project' => $project,
                'engagements' => $engagements,
                'customers' => $customers,
                // 'contracts' => $contracts,
                'departments' => $departments,
                'users' => $users,
                'company' => $company,
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
            'name' => 'required',
            'hours_by_day' => 'required',
            // 'sow_number'                    => 'required',
            // 'identificator'                 => 'required',
            // 'engagement'                    => 'required',
            // 'estimated_revenue'             => 'required|numeric|min:0',
            // 'estimated_cost'                => 'required|numeric|min:0',
            // 'estimated_margin'              => 'numeric|required',
            // 'target_margin'                 => 'numeric|required',
            'customer_id' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'status'                        => 'required',
            // 'financial_deviation_threshold' => 'numeric|required',
            // 'time_deviation_threshold'      => 'numeric|required',
            // 'department_id'                 => 'required',
            'project_manager_id' => 'required',
          //  'technical_director_id' => 'required',
          //  'delivery_manager_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        $data = $request->all();

        $res = $this->apiCall('POST', 'projects', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            //var_dump($jsonRes);
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_store')]
            )->validate();
        } else {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);


            $this->rawDirectory( $request, $jsonRes['data']['id']);

            //var_dump($final_directories);


            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        $res = $this->getFromApi('POST', 'rcprojectchannel', $data);
        $data = ['name' => $res->fullname];
        $res = $this->iredmailApiCall('POST','rcchannel',$data);

        return response()->json();
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
            'name' => 'required',
            'customer_id' => 'required',
            'customer_name' => 'required',
            'start' => 'required',
            'finish' => 'required',
            'project_manager_id' => 'required',
            'technical_director_id' => 'required',
            'delivery_manager_id' => 'required',
            'sow_number'                    => 'required',
            'identificator'                 => 'required',
            'status'                        => 'required',
            'presales_responsable'          => 'required',
            'technical_estimator'           => 'required',
            'engagement'                    => 'required',
            'estimated_revenue'             => 'required|numeric|min:0',
            'estimated_cost'                => 'required|numeric|min:0',
            'estimated_margin'              => 'numeric|required',
            'target_margin'                 => 'numeric|required',
            'financial_deviation_threshold' => 'required|numeric',
            'name_convention'               => 'required',
            'holy_days'                     => 'required',
            // 'financial_deviation_threshold' => 'numeric|required',
            'time_deviation_threshold'      => 'numeric|required',
            'hours_by_day' => 'required',
            'department_id'                 => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all();

        $res = $this->apiCall('PATCH', 'projects/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project')]
            )->validate();
        } else {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);

            $this->rawDirectory( $request, $data['id']);


            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    // Function to recursively add a directory,
    // sub-directories and files to a zip archive
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
        $project = $this->getFromApi('GET', 'projects/' . $request->id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);

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
                if ($archive->close() && Storage::disk('repository')->exists($customer->name."/".$project->name."/".$name_file)) { 
                    // archive is now downloadable ...
                    return response()->download(storage_path($destinationPath . "/".$name_file))->deleteFileAfterSend(true);
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
        
        $project = $this->getFromApi('GET', 'projects/' . $request->id);
        $customer = $this->getFromApi('GET', 'customers/'.$project->customer_id);
        
        $res = $this->apiCall('DELETE', 'projects/' . $request->id);
    
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

    public function forProjectSelection($customer_id)
    {
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $customer_id . '&user_id=' . Auth::id());

        return response()->json([
            'view' => view('project/forProjectSelection', ['projects' => $projects])->render()
        ]);
    }

    public function forProjectSelectionButton($customer_id)
    {
        $projects = $this->getFromApi('GET', 'projects?project_id=' . $customer_id);

        return response()->json([
            'view' => view('project/forProjectSelectionButton', ['projects' => $projects])->render()
        ]);
    }


    public function select(Request $request)
    {
        session(['project_id' => $request->id]);
        session(['project_name' => $request->name]);
        session(['customer_id' => $request->customer_id]);
        session(['customer_name' => $request->customer_name]);
        return response()->json();
    }

    public function forContracts($customer_id)
    {
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $customer_id);
        return response()->json($projects);
        /*return response()->json([
            'view' => view('project/forContracts', ['projects' => $projects] )->render()
        ]);*/
    }


    public function rawDirectory($request, $projectid)
    {

        $project = $this->getFromApi('GET', 'projects/' . $projectid);
        $customer = $this->getFromApi('GET', 'customers/'.$request->customer_id);

        $path = storage_path() . '/app/public/repository/' . $customer->name . '/' . $project->name;
        File::makeDirectory($path, $mode = 0777, true, true); // Client - Proyecto

        $directories = $this->getFromApi('GET', 'directories');

        foreach ($directories as $directory) {

            $path = storage_path() . '/app/public/repository/' . $customer->name . '/' . $project->name . '/' . $directory->path;
            File::makeDirectory($path, $mode = 0777, true, true); // EN - ES


            $folders = $this->getFromApi('GET', 'directories?parent=' . $directory->id);

            foreach ($folders as $folder) {

                $path = storage_path() . '/app/public/repository/' . $customer->name . '/' .$project->name . '/'
                    . $directory->path . '/' . $folder->path;

                File::makeDirectory($path, $mode = 0777, true, true); // Initial - Inicio

                $subfolders = $this->getFromApi('GET', 'directories?parent=' . $folder->id);
                // dd($subfolders);
                foreach ($subfolders as $subfolder) {
                    $path = storage_path() . '/app/public/repository/' . $customer->name . '/' . $project->name . '/'
                        . $directory->path . '/' . $folder->path . '/' . $subfolder->path;
                    File::makeDirectory($path, $mode = 0777, true, true); // Integration Management - Manejo de Integracion

                    $last_level = $this->getFromApi('GET', 'directories?parent='. $subfolder->id);

                    foreach ($last_level as $level) {
                        $path = storage_path() . '/app/public/repository/' . $customer->name . '/' . $project->name . '/'
                        . $directory->path . '/' . $folder->path . '/' . $subfolder->path . '/'. $level->path;
                        File::makeDirectory($path, $mode = 0777, true, true); // Urgent
                    }
                }

            }

        }

    }

        /**
     * Form para editar
     * @param  int $id ID
     */
    public function pdf($id)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $data['project']   = $this->getFromApi('GET', 'projects/'.$id);
        $data['contract'] = $this->getFromApi('GET', 'contracts?project_id=' . $id)[0] ;
        $data['project_managers'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
        $data['technical_directors'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Technical Director');
        //return $data['contract'] ;
        $pdf = \PDF::loadView('project/pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('project.pdf');
    }

}
