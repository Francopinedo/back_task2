<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use Validator;
use ZipArchive;
use Carbon\Carbon;

class RepositoryBackupController extends Controller
{
    public function __construct()
    {
        /*$this->middleware(['auth','systemaudit']);*/
    }

    /**
     * Muestra listado
     */
    public function index()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);

        $params = [
            'customers' => $customers,

        ];

        return view('repository_backup/index', $params);
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
        $validator =Validator::make($request->all(), [
            'customer' => 'required',
            'project' => 'required',
        ]);

        $now = Carbon::now(); // Para manipular Hora y Fecha
        $project = $this->getFromApi('GET', 'projects/' . $request->project);
        $customer = $this->getFromApi('GET', 'customers/'.$request->customer);

        $destinationPath = "app/public/repository/" . $customer->name . "/" . $project->name;
        
        $file_download = $customer->name . "_".$project->name."_".$now->toDateString()."_".$now->toTimeString()."_repository.zip"; // Nombre del archivo zip

        if (Storage::disk('repository')->has($customer->name . "/" . $project->name)) {

            // create a list of files that should be added to the archive.
            $directories = File::directories(storage_path($destinationPath));
         
            // define the name of the archive and create a new ZipArchive instance.
            $archiveFile = storage_path($destinationPath . "/".$file_download);
            $archive = new ZipArchive();
            // echo $destinationPath;

            if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                //$archive->addEmptyDir('test');
                // loop trough all the files and add them to the archive.
                $destination = $str = str_replace('\\', '/', $destinationPath);
                $archiveFile =  $this->addFolderToZip(storage_path($destination), $archive, $customer->name.'_'.$project->name."_".$now->toDateString()."_".$now->toTimeString().'_repository/');

                // close the archive.
                if ($archive->close() && $name = Storage::disk('repository')->exists($customer->name . "/" . $project->name . "/".$file_download)) { // && Storage::disk('repository')->exists($archiveFile)
                    // archive is now downloadable ...
                    if ($exists = Storage::disk('repository')->exists($customer->name . "/" . $project->name . "/".$file_download)) {     // archive is now downloadable ...
                        return response()->download(storage_path($destinationPath . "/".$file_download))->deleteFileAfterSend(true);
                    }

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

    public function delete(Request $request)
    {


        $destinationPath = "app/public/repository/" . $request->file;
        // echo $destinationPath;
        if ($exists = Storage::disk('repository')->exists($request->file)) {
            Storage::disk('repository')->delete($request->file);
            return response()->json(array('success' => true));
        } else {
            return response()->json(array('success' => false));
        }

    }


    /**
     * Crear nuevo
     */
    public
    function store(Request $request)
    {
        // validacion del formulario
        /*$validator =Validator::make($request->all(), [

            'title'             => 'required',
            'company_id'        => 'required',
            'city_id'           => 'required',
            'workinghours_from' => 'required',
            'workinghours_to'   => 'required',
            'hours_by_day'      => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'offices', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.office_store')]
            )->validate();
        }
        else
        {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();*/
    }

    /**
     * Actualizo
     */
    public
    function update(Request $request)
    {
        // validacion del formulario
        /* $validator =Validator::make($request->all(), [

             'title'             => 'required',
             'company_id'        => 'required',
             'city_id'           => 'required',
             'workinghours_from' => 'required',
             'workinghours_to'   => 'required',
             'hours_by_day'      => 'required'
         ]);

         if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

         $res = $this->apiCall('PATCH', 'offices/'.$data['id'], $data);

         // validacion de la respuesta del api
         if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
         {
             $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
             Validator::make($jsonRes,
                 ['status_code' => [Rule::in(['201', '200'])]],
                 ['in' => __('api_errors.office_store')]
             )->validate();
         }
         else
         {
             session()->flash('message', __('general.updated'));
             session()->flash('alert-class', 'success');
         }

         return response()->json();*/
    }


}
