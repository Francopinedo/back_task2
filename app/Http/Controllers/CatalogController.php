<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class CatalogController extends Controller
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
        $metavariables = $this->getFromApi('GET', 'metavariables');
        $idiomas = $this->getFromApi('GET', 'languages');


        $params =[
            'directories'    => array(),
            'metavariables' => $metavariables,
            'idiomas'       => $idiomas,
        ];

        return view('catalog/index' , $params);
    }


    /**
     * Muestra listado
     */
    public function show($lang, $directory)
    {

        $documentos =Storage::disk('catalog')->files(strtolower($lang)."/".$directory);

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
        $idioma = $request->lenguage? $request->lenguage : 'EN';
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


    public function download($lang, $directory, $file){


        if($exists = Storage::disk('catalog')->exists(strtolower($lang)."/".$directory."/".$file)){

            return response()->download(storage_path("app/public/catalog/".strtolower($lang)."/".$directory."/".$file, 'test'));
        }else{
           // echo 'archivo no existe';
        }

    }



    /**
     * Crear nuevo
     */
    public function store(Request $request)
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
    public function update(Request $request)
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

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
        /* $res = $this->apiCall('DELETE', 'offices/'.$id);

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

         return redirect()->action('OfficeController@index');*/
    }


}
