<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;
use PhpOffice\PhpWord\IOFactory;
use ZipArchive;
use DomDocument;
use Redirect;

class CatalogController extends Controller
{
    public function __construct()
    {
        /*$this->middleware(['auth','systemaudit']);*/
    }

    /**
     * Muestra listado
     */
    public function index($parameter='', $lang='', $type='', $directory='')
    {
        if (!Auth::guest())
        {
            $metavariables = $this->getFromApi('GET', 'metavariables');
            $idiomas = $this->getFromApi('GET', 'languages');


            $params =[
                'directories'    => array(),
                'metavariables' => $metavariables,
                'idiomas'       => $idiomas,
                'type'       => $type=='delete' || $type=='download' || $type=='view'?'':$type,
                'lang'       => $lang,
                'dir'       => $directory,
            ];

            return view('catalog/index' , $params);
        }
        else
        {
            return Redirect::to('/');
        }
    }


    /**
     * Muestra listado
     */
     public function show($lang_system, $type, $directory)
         {

         $documentos =Storage::disk('catalog')->files($lang_system."/".$type."/".$directory);
         
        $params =[

            'documentos'    => $documentos,

        ];

        return response()->json($params);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public $tmp_path = '/home/celit/tmp';

    public function create(Request $request){
        /*dd($request->all());*/
        $variables = $request->all();
        $extension = $request->extension? $request->extension : 'docx';
        $idioma = $request->language? $request->language : 'EN';
        $directorio_menu = $request->directory;//Initiating, Planning, Executing, Monitoring & Control, Closing
        $nameDocument = $request->document;
        $archivo = storage_path("app/doc/manual/$idioma/$directorio_menu/$nameDocument.docx");
        $template = new \PhpOffice\PhpWord\TemplateProcessor($archivo);

        $variables['OUR_LOGO'] = asset('assets/img/favicon_32.png');
        $variables['CUSTOMER_LOGO'] = $variables['OUR_LOGO'];
        foreach( $variables as $key => $value) {

            if($key == 'OUR_LOGO' or $key == 'CUSTOMER_LOGO'){
                $template->setImageValue("$key",
                    [
                        "path" => $value,
                        "width" => 45,
                        "height" => 45
                    ]
                );
            }else{
                $template->setValue($key, $value);
            }
        }
        /*  $archivo = storage_path('app/doc/'.$nameFile.'2.'.$extension);
          $template->saveAs($archivo);*/

        // dd('libreoffice --headless --convert-to pdf '.$archivo);

        if($extension == 'pdf'){
            $archivo = storage_path('app/doc/descargas_pdf/'.$nameDocument.'.docx');
            $template->saveAs($archivo);

            shell_exec('libreoffice --headless --convert-to pdf '.$archivo.' --outdir '.storage_path('app/doc/descargas_pdf'));

            header("Content-Type: application/force-download");
            header("Content-type: application/pdf");
            header('Content-Description: File Download');
            //header('Content-Disposition: attachment; filename=' . $nameFile);
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');

            return response()->download(storage_path('app/doc/descargas_pdf/'.$nameDocument.'.pdf'));
        }else{
            $archivo = storage_path('app/doc/descargas_pdf/'.$nameDocument.'.'.$extension);
            $template->saveAs($archivo);
            return response()->download($archivo);
        }

    }

    public function modificarTemplate(){
        $array=[
            'PROJECT_NAME'  => 'chanz',
            'OUR_LOGO'      => 'asd',
            'CUSTOMER_LOGO' => 'asd',
            'NUMBER'        => '123',
            'DATE'          =>  date('d/m/Y')
        ];
        $extension='docx';
        $nameFile = 'TemplateTest';
        $archivo = storage_path("doc/".$nameFile.'.docx');
        $template = new \PhpOffice\PhpWord\TemplateProcessor($archivo);

        foreach ($array as $key => $value){
            if($key == 'OUR_LOGO' or $key=='CUSTOMER_LOGO'){
                $template->setImageValue("$key",
                    [
                        "path" => $value,
                        "width" => 45,
                        "height" => 45
                    ]
                );
            }else{
                $template->setValue($key, $value);
            }
        }

        $archivo = storage_path('doc/'.$nameFile.'2.docx');
        $template->saveAs($archivo);

        shell_exec('libreoffice --headless --convert-to pdf '.$archivo);
        return response()->download(storage_path('doc/'.$nameFile.'2.pdf'));


        //return response()->download(storage_path('doc/'.$nameFile.'2.docx'));


    }

    public function download(Request $request)
    {


        $destinationPath = "app/public/catalog/" . $request->file;
        $pathArr = explode(DIRECTORY_SEPARATOR, $destinationPath);
        $filename = end($pathArr);
        // echo $destinationPath;
        if ($exists = Storage::disk('catalog')->exists($request->file)) {

            $destinationPath = "app/public/catalog/" . $request->file;
            if ($exists = Storage::disk('catalog')->exists($request->file)) {
                return response()->download(storage_path($destinationPath));
            } else {
                //  echo 'archivo no existe';
            }
            // In case of failure return empty string
            return "";
        }
   }

    public function getHTML($lang, $directory, $file)
    {
        //Obtenemos nombre de archivo
        $file = explode('.',$file);
        //Obtenemos html de tabla html_docs
        $html = \App\HtmlDoc::where('lang',$lang)->where('name',$file[0])->first();
        
        return json_encode($html);
    }

    public function delete(Request $request)
    {
        $destinationPath = "app/public/catalog/" . $request->file;
        // echo $destinationPath;
        if ($exists = Storage::disk('catalog')->exists($request->file)) {
            Storage::disk('catalog')->delete($request->file);
           return response()->json(array('success' => true));
        } else {
           return response()->json(array('success' => false));
        }
              
        //     session()->flash('message', __('general.deleted'));
        //     session()->flash('alert-class', 'success');
        // return Redirect::to('/catalog');
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
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
    public function update(Request $request)
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

 



   public function uploadFile(Request $request)
    {
        try {
            $file = $request->file('document');
            $directory = $request->directory;
            $option =$request->dataType=="1"? "nontagged" :"tagged" ;

            $validator =Validator::make($request->all(), [

        		'language' => 'required',                
        		'directory' => 'required',
                'document' => 'required'
            ]);

            $destinationPath = "app/public/catalog/".$request->language. "/" . $option . "/" . $request->directory;
            
            // foreach ($files as $file) {
                // echo $file->getClientOriginalName();

				$namefinal=  $file->getClientOriginalName();


			///////////////////////

                $file->move(storage_path($destinationPath), $namefinal);
	
            // }


        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }


}
