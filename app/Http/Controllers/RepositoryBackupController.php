<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Exception;
use Validator;
use ZipArchive;

class RepositoryBackupController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('auth');*/
    }

    /**
     * Muestra listado
     */
    public function index()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $customers = $this->getFromApi('GET', 'customers/?company_id=' . $company->id);

        $params = [
            'customers' => $customers,

        ];

        return view('repository_backup/index', $params);
    }


    public
    function download(Request $request)
    {


        $destinationPath = "app/public/repository/" . $request->customer . "/" . $request->project;


        if ($exists = Storage::disk('repository')->exists($request->customer . "/" . $request->project . "/backup.zip")) {     // archive is now downloadable ...
            return response()->download(storage_path($destinationPath . "/backup.zip"))->deleteFileAfterSend(true);


        } else {

            return response()->json(array('error' => 'could not close zip file: '));
        }
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

    public
    function validate_download(Request $request)
    {
        $this->validate($request, [
            'customer' => 'required',
            'project' => 'required',

        ]);


        $destinationPath = "app/public/repository/" . $request->customer . "/" . $request->project;


        if (Storage::disk('repository')->has($request->customer . "/" . $request->project)) {


            // create a list of files that should be added to the archive.
            $directories = File::directories(storage_path($destinationPath));


            //var_dump($directories);

            // define the name of the archive and create a new ZipArchive instance.
            $archiveFile = storage_path($destinationPath . "/backup.zip");
            $archive = new ZipArchive();
            // echo $destinationPath;


            if ($archive->open($archiveFile, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
                //$archive->addEmptyDir('test');
                // loop trough all the files and add them to the archive.
                $destination = $str = str_replace('\\', '/', $destinationPath);
                $archiveFile =  $this->addFolderToZip(storage_path($destination), $archive, 'backup/');
                /*
                $archive->addEmptyDir('backup');
                foreach ($directories as $directory) {


                    $directory = $str = str_replace('\\', '/', $directory);
                    //   echo $directory;
                    $folder = explode('/', $directory);

                    $folder = $folder[sizeof($folder) - 1];

                    $directoryadd = 'backup/' . $folder;
                    $archive->addEmptyDir($directoryadd);

                    $options = array('add_path' => $folder, 'remove_all_path' => TRUE);
                    $files = File::files($directory);
                    //var_dump($files);
                    // $archive->addGlob('*.*', GLOB_BRACE, $options);
                    foreach ($files as $file) {

                        $file = $str = str_replace('\\', '/', $file);
                        $filename = explode('/', $file);
                        $filename = $filename[sizeof($filename) - 1];
                        //echo $directory."/".$filename;
                        if ($archive->addFile($directory . "/" . $filename, basename($file))) {

                            // do something here if addFile succeeded, otherwise this statement is unnecessary and can be ignored.
                            continue;
                        } else {
                            throw new Exception("file `{$file}` could not be added to the zip file: " . $archive->getStatusString());
                        }
                    }
                }
*/

                //var_dump($archive);
                // close the archive.
                if ($archive->close() && Storage::disk('repository')->exists($request->customer . "/" . $request->project . "/backup.zip")) { // && Storage::disk('repository')->exists($archiveFile)
                    // archive is now downloadable ...
                    return response()->json(array('success' => ''));
                    //return response()->download($archiveFile, basename($archiveFile))->deleteFileAfterSend(true);

                } else {

                    return response()->json(array('error' => 'Empty repository'));
                }
            } else {

                return response()->json(array('error' => 'zip file could not be created: ' . $archive->getStatusString()));
            }
        } else {
            return response()->json(array('error' => 'Reposotory not found'));
        }


    }

    public
    function delete(Request $request)
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
        /*$this->validate($request, [
            'title'             => 'required',
            'company_id'        => 'required',
            'city_id'           => 'required',
            'workinghours_from' => 'required',
            'workinghours_to'   => 'required',
            'hours_by_day'      => 'required'
        ]);

        $data = $request->all();

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
        /* $this->validate($request, [
             'title'             => 'required',
             'company_id'        => 'required',
             'city_id'           => 'required',
             'workinghours_from' => 'required',
             'workinghours_to'   => 'required',
             'hours_by_day'      => 'required'
         ]);

         $data = $request->all();

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
