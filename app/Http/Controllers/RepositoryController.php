<?php

namespace App\Http\Controllers;

use Mail;
use Session;
use Redirect;
use File;
use Validator;
use TCPDF as PDF;
use Carbon\Carbon;
use App\models\Signature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RepositoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    /*
    public function index()
    {
        //$metavariables = $this->getFromApi('GET', 'metavariables');
        //$idiomas = $this->getFromApi('GET', 'languages');

        $user = $this->getFromApi('GET', 'users/' . Auth::id());
        $project = $this->getFromApi('GET', 'projects/' . session('project_id'));

        $companyRole = $this->getFromApi('GET', 'company_roles/' . $user->company_role_id .
            '/?include[]=role.directoryRoles.directory');
        $final_directories = array();
        if (is_object($companyRole)) {
            $directories = $this->getFromApi('GET', 'directories');

            $activeDirectoriesIdsRead = [];
            $activeDirectoriesIdsWrite = [];


            foreach ($companyRole->role->data->directoryRoles->data as $directoryRoles) {
                if (!empty($directoryRoles)) {
                    if (isset($directoryRoles->write) && $directoryRoles->write == 1) {
                        $activeDirectoriesIdsWrite[$companyRole->id][] = $directoryRoles->directory->data->id;
                    }
                    if (isset($directoryRoles->read) && $directoryRoles->read == 1) {
                        $activeDirectoriesIdsRead[$companyRole->id][] = $directoryRoles->directory->data->id;
                    }

                }
            }


            //var_dump($directories);
            foreach ($directories as $directory) {

                $dir = (Array)$directory;
                $folders = $this->getFromApi('GET', 'directories?parent=' . $directory->id);

                $finalfolders = array();

                foreach ($folders as $folder) {
                    $fold = (Array)$folder;

                    $subfolders = $this->getFromApi('GET', 'directories?parent=' . $folder->id);

                    $finalsubfolders = array();

                    foreach ($subfolders as $subfolder) {
                        $subfold = (Array)$subfolder;

                        array_push($finalsubfolders, $subfold);
                    }

                    $fold['subfolders'] = $finalsubfolders;


                    array_push($finalfolders, $fold);

                }
                $dir['folders'] = $finalfolders;

                array_push($final_directories, $dir);
            }

            //var_dump($final_directories);
        }

        $params = [
            'directories' => $final_directories,
            'project' => $project,
            'companyRole' => $companyRole,
            //'activeDirectoriesIdsRead' => $activeDirectoriesIdsRead,
            //'activeDirectoriesIdsWrite' => $activeDirectoriesIdsWrite,
          //  'metavariables' => $metavariables,
           // 'idiomas' => $idiomas,
        ];

        return view('repository/index', $params);
    }*/

    public function index($customer='',$project='',$lang='',$process_group='',$knowledge_area='',$directory='')
    {
        $idiomas = $this->getFromApi('GET', 'languages');


        $params =[
            'directories'       => array(),
            'idiomas'           => $idiomas,
            'customer'          => $customer,
            'project'           => $project,
            'lang'              => $lang,
            'process_group'     => $process_group,
            'knowledge_area'    => $knowledge_area,
            'dir'               => $directory,
        ];

        return view('repository/index' , $params);
    }
    
    public function uploadFile(Request $request)
    {
        
        try {
            
            $customer =  $this->getFromApi('GET', 'customers/' .  $request->customer_id); 
            $project =  $this->getFromApi('GET', 'projects/' .  $request->project_id);
            $file = $request->file('document');

            $process_group = $request->process_group;
            $knowledge_area = $request->knowledge_area;
            $directory = $request->directory;

            $validator =Validator::make($request->all(), [
                'language' => 'required',
                'customer_id' => 'required',
                'project_id' => 'required',
                'process_group' => 'required',
                'knowledge_area' => 'required',
                'directory' => 'required',
                'document' => 'required'
            ]);
            $versionfile = 1;

            $destinationPath = "app/public/repository/" . $customer->name . "/" . $project->name . "/". $request->language. "/". $request->process_group ."/". $request->knowledge_area ."/". $directory;

            // foreach ($files as $file) {
                // echo $file->getClientOriginalName();

    			/////////////////// 
    			$dt =  date('YmdHis');
    			$namefinal="";
    			foreach($project->name_convention as $nconvention)

    			{

    				switch($nconvention)
    				{
    				case "CustomerName":

    				$namefinal=  $namefinal==""? $namefinal . $customer->name : $namefinal ."-". $customer->name;
    				break;
    				case "ProjectName":
    				$namefinal =  $namefinal==""? $namefinal . $project->name : $namefinal ."-". $project->name;

    				break;
    				case "ArtifactName":
    				$namefinal =  $namefinal==""? $namefinal . str_replace("/","-",$directory) : $namefinal ."-".str_replace("/","-",$directory);

    				break;
    				case "YYYYMMDDHHMMSS":
    				$namefinal =  $namefinal==""? $namefinal . $dt : $namefinal ."-".$dt;

    				break;
    				case "VersionNumber":
    				$namefinal =  $namefinal==""? $namefinal . $versionfile : $namefinal ."-".$versionfile;

    				break;
    				}
    			}
    			$dt =  date('YmdHis');

                $namefinal=  $namefinal.".".$file->getClientOriginalExtension();

    			///////////////////////

                if ($exists = Storage::disk('repository')->exists($customer->name. "/" . $project->name . "/" . $request->language."/".$request->process_group."/"."/".$request->knowledge_area."/".$directory."/".$namefinal)) {
                    return response()->json(array('success' => true, 'message' => __('api_errors.error_upload')));
                } else {
                    $file->move(storage_path($destinationPath), $namefinal);
                    $versionfile++;
                    return response()->json(array('success' => false, 'message' => __('general.added')));
                }
            // }


        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }

    /**
     * Muestra listado
     */
    /*
    public
    function show($customer, $projet, $directory)
    {
        $customer =  $this->getFromApi('GET', 'customers/' .  $customer); 
        $project =  $this->getFromApi('GET', 'projects/' .  $projet); 

        $documentos = Storage::disk('repository')->files($customer->id . "/" . $project->id . "/" . $directory);

        $params = [

            'documentos' => $documentos,

        ];

        return response()->json($params);
    }*/

    public function show($customer_name,$project_name,$lang,$process_group,$knowledge_area,$directory)
    {
        //dd(Storage::disk('repository'));
        $documentos =Storage::disk('repository')->files($customer_name."/".$project_name."/".$lang."/".$process_group."/".$knowledge_area."/".$directory);
        // $documentos2 = Storage::disk('repository')->files($lang.'/'.$process_group);
        // array_push($documentos,$documentos2);

        $params = [
            'documentos'    => $documentos,
        ];

        return response()->json($params);
    }

    public function create(Request $request)
    {
        /*dd($request->all());*/
        $variables = $request->all();
        $extension = $request->extension ? $request->extension : 'docx';
        $idioma = $request->lenguage ? $request->lenguage : 'EN';
        $directorio_menu = $request->directory;//Initiating, Planning, Executing, Monitoring & Control, Closing
        $nameDocument = $request->document;
        $archivo = storage_path("app/doc/manual/$idioma/$directorio_menu/$nameDocument.docx");
        $template = new \PhpOffice\PhpWord\TemplateProcessor($archivo);

    }

    //$kind1: Es para verificar si es preview o se está generando doc definitivo
    //$kind2: Verifica tipo de doc (DOCX o PDF) o si se está guardando, o si es correo (3: Guardar doc)
    public function updateDocument($customer,$project,$language,$directory,$knowledge_area,$archives,$filename,$kind,$kind2=NULL,$customer_logo)
    {
        //print_r($_POST);
        $file = storage_path('app/public/catalog/'.$language.'/tagged/'.$directory.'/'.$filename);
        //Creamos tabla (si es que se agregó)
        //Obtenemos metagrids
        $filewithroute = explode('.',$filename);
        $filename2 = explode('.',$filename); //Solo nombre de archivo
        $metagrids = $this->getFromApi('GET', 'metagrids/'.$language.'/'.$filewithroute[0]);
        $tablexml = [];

        $document_with_table = new \PhpOffice\PhpWord\PhpWord();
        $template = new \PhpOffice\PhpWord\TemplateProcessor($file);
        $section = $document_with_table->addSection();

        // $sig = Signature::where('name',$filename.'.pdf')->first();
        // if($sig){          
        //     $bin = base64_decode($sig['signature']);
        //     $im = imageCreateFromString($bin);
        //     if (!$im) {
        //         die('Base64 value is not a valid image');
        //     }
        //     $img_file = storage_path('app/public/temp/logo.png');
        //     imagepng($im, $img_file, 0);
        //     //$template->setImageValue('Signature', ["path"=>$img_file,"width"=>380,"height"=>120]);
        //     if($kind2!=0)$template->setImageValue('Signature', $img_file);
        //     File::delete($img_file);
        //     if($kind2==0)DB::table('signature')->where('name',$filename.'.pdf')->delete();
        // }

        //Creamos writer para convertir doc a xml
        $k = 0;
        foreach ($metagrids as $m)
        {
            if (isset($_POST[$m->name.'_0_0'])) //Vemos si al menos hay un campo en la tabla
            {
                $section = $document_with_table->addSection();
                //Agregamos estilos a la tabla
                $tableStyle = new \PhpOffice\PhpWord\Style\Table;
                $tableStyle->setBorderColor('000000');
                $tableStyle->setBorderSize(1);
                $tableStyle->setUnit(\PhpOffice\PhpWord\Style\Table::WIDTH_PERCENT);
                $tableStyle->setWidth(100 * 50);

                $tableStyle = array(
                    'borderColor' => '000000',
                    'borderSize'  => 16,
                    'cellMargin'  => 50
                );

                $styleCell = array('valign' => 'center');
                $fontFirstStyle = array('bold' => true, 'size' => '10', 'color' => 'FFFFFF','name' => 'Verdana');
                $fontStyle = array('size' => '10','name' => 'Verdana');
                /*
                $document_with_table->addFontStyle(
                   $fontStyleName,
                  array('name' => 'Tahoma', 'size' => 12, 'color' => 'red', 'bold' => true)
                );
                */
                $firstRowStyle = array(
                    'bgColor' => '000080',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER
                );

                $table = $section->addTable($tableStyle);

                $i = 0;
                while ($i < $_POST[$m->name.'_rows'])
                {
                    $j = 0;
                    $table->addRow();
                    while ($j < $_POST[$m->name.'_columns'])
                    {
                        if ($i == 0)
                        {
                            $table->addCell(2000, $firstRowStyle)->addText($_POST[$m->name.'_'.$i.'_'.$j],$fontFirstStyle);
                        }
                        else
                        {
                            $table->addCell(2000)->addText($_POST[$m->name.'_'.$i.'_'.$j], $fontStyle);
                        }

                        $j+=1;
                    }
                    $i+=1;
                }

                //Creamos writer para convertir doc a xml
                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document_with_table, 'Word2007');
                //Obtenemos xml del documento temporal
                $fullxml = $objWriter->getWriterPart('Document')->write();

                //Obtenemos xml
                $tablexml[] = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);
                $template->setValue($m->name.'[[metagrid]]','</w:t></w:r></w:p>'.$tablexml[$k].'<w:p><w:r><w:t>');
                $k+=1;
            }
        }
        
        //Debería haber sólo una carpeta
        foreach (scandir('logos/companies') as $folder)
        {
            if ($folder != '.' && $folder != '..')
            {
                foreach (scandir('logos/companies/'.$folder) as $logo)
                {
                    if ($logo != '.' && $logo != '..')
                    {
                        if(!empty($company_logo)){
                            $template->setImageValue('OUR_LOGO', 'logos/companies/'.$folder.'/'.$company_logo);
                        }else{
                            $template->setImageValue('OUR_LOGO', 'logos/companies/'.$folder.'/'.$logo);
                        }
                    }
                }
            }
        }

        //También agregamos logo de cliente
        foreach (scandir('logos/customers') as $folder)
        {
            if ($folder != '.' && $folder != '..')
            {
                foreach (scandir('logos/customers/'.$folder) as $logo)
                {
                    if ($logo != '.' && $logo != '..')
                    {
                        if(!empty($customer_logo)){
                            $template->setImageValue('CUSTOMER_LOGO', 'logos/customers/'.$folder.'/'.$customer_logo);
                        }else{
                            $template->setImageValue('CUSTOMER_LOGO', 'logos/customers/'.$folder.'/'.$logo);
                        }
                    }
                }
            }
        }
        
        $vars = []; //En caso que se necesite para guardar documento
        $vars_not_allowed = ['_token', 'language', 'directory', 'filename'];
        foreach ($_POST as $key => $val)
        {
            if (!in_array($key,$vars_not_allowed))
            {
                //agregamos código al final del string, para esto, 1ro obtenemos metadocumento
                $lang = \App\Language::where('code',$language)->first();
                $metadocument = \App\Metadocument::where('path_ref',$filename2[0])->where('language_id',$lang->id)->first();
                
                $mv = \App\Metavariable::where('metadocument_id',$metadocument->id)->where('name',$key)->first();

                if (!empty($mv)) //Si no existe, puede ser porque el post es metagrid
                {
                    //Ahora obtenemos código de metavariable_kind_id
                    $mvk = \App\MetavariableKind::find($mv->metavariable_kind_id);
                    
                    //Ahora creamos variable que incluya código
                    $new_key = $key.'[['.$mvk->code.']]';
                    $template->setValue($new_key,$val);

                    if ($kind2 == 1 && $val != '') //Se está guardando doc, así que guardamos variable
                    {
                        $vars[] = [
                            'metavariable' => $key,
                            'value' => $val
                        ];
                    }
                }
                
            }
        }

        //Realizamos ciclo para Sacar metavariables del documento
        $metadocument = \App\Metadocument::where('path_ref',$filename2[0])->where('language_id',$lang->id)->first();        
        $mvs = \App\Metavariable::where('metadocument_id',$metadocument->id)->get();
        foreach ($mvs as $mv)
        {
            //Ahora obtenemos código de metavariable_kind_id
            $mvk = \App\MetavariableKind::find($mv->metavariable_kind_id);
                    
            //Ahora creamos variable que incluya código
            $new_key = $mv->name.'[['.$mvk->code.']]';
            $template->setValue($new_key,'<a href="#" id="'.$mv->name.'_prev" onclick="goToForm(\''.$mv->name.'\')">Ver en formulario</a>');
        }

        //Ahora sacamos de metagrids
        foreach ($metagrids as $mg)
        {           
            //Ahora creamos variable que incluya código
            $new_key = $mg->name.'[[metagrid]]';
            $template->setValue($new_key,'<a href="#" id="'.$mv->name.'_prev" onclick="goToForm(\''.$mv->name.'\')">Ver en formulario</a>aaaaa');
        }
        //Agregamos logo
        $header = $section->addHeader();
        //$header->addImage('');

        $new_file = $filename;
        
        //Cambiamos estado a todos los documentos asociados al metadocumento (se eliminan con deleted_at) en caso que no sea previsualización
        if ($kind2 == 0) 
        {
            $docs = \App\Document::where('metadocument_id',$metadocument->id)->get();
            foreach ($docs as $doc)
            {
                //Cambiamos estado también a variables asociadas
                $variables = \App\Variable::where('document_id',$doc->id)->delete();
                $doc->delete();
            }
        } else if ($kind2 == 1)
        {
            //Primero obtenemos última versión de documento
            $oldDoc = \App\Document::withTrashed()->where('metadocument_id',$metadocument->id)->orderBy('updated_at','DESC')->first();
            $version = !empty($oldDoc) ? $oldDoc->version+1 : 1;
            //Creamos un nuevo documento
            $document = \App\Document::create([
                'metadocument_id' => $metadocument->id,
                'version' => $version
            ]);

            //Ahora creamos las variables guardadas
            foreach ($vars as $v)
            {
                //obtenemos metavariable asociada
                $metavariable = \App\Metavariable::where('name',$v['metavariable'])->where('metadocument_id',$metadocument->id)->first();
                $variable = \App\Variable::create([
                    'document_id' => $document->id,
                    'metavariable_id' => $metavariable->id,
                    'value' => $v['value']
                ]);
            }
        }
        
        $template->saveAs($new_file);
        
        if ($kind2 < 1 || $kind2==4) //PDF
        {
            $command = "export HOME=/var/www/html/devpanel && libreoffice --headless --convert-to odt ".$new_file;

            $result = exec($command);
            $result = explode('/',$result);
            $result = explode('.',$result[sizeof($result)-1]);

            if(null!==(session('customer_id')) && null!==(session('project_id'))){
                //Movemos archivo
                if($kind2==0 && file_exists(storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.docx'))){
                    File::delete( storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.docx'));
                }
            }
            return $result[0];
        }

        if($kind2 == 1) // docx
        {
            $command = "export HOME=/var/www/html/devpanel && libreoffice --headless --convert-to odt ".$new_file;

            $result = exec($command);
            $result = explode('/',$result);
            $result = explode('.',$result[sizeof($result)-1]);

            //Movemos archivo
            rename($result[0].'.docx',storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.docx'));

            return $result[0];
        }

        if ($kind2 == 2) //PDF
        {
            $command = "export HOME=/var/www/html/devpanel && libreoffice --headless --convert-to pdf ".$new_file;
            $result = exec($command);
            $result = explode('/',$result);
            $result = explode('.',$result[sizeof($result)-1]);

            //Movemos archivo
            copy($result[0].'.pdf',storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.pdf'));

            return $result[0];
        }
        // Enviarlo por email
        if($kind2 == 5){
            $files = [];
            if(file_exists(storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.pdf'))){
                array_push( $files,
                    storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.pdf')

                );
            }
            if(file_exists(storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.docx'))){
                array_push( $files,
                    storage_path('app/public/repository/'.$customer.'/'.$project.'/'.$language.'/'.$directory.'/'.$knowledge_area.'/'.$archives.'/'.$filename2[0].'.docx')

                );
            }

            if(sizeof($files)>0){
                $to = Auth::user()->email;
                $from = 'mailchat.taskcontrol.net';
                $fromName = 'TaskControl';
                $subject = 'You have created this document';
                if(sizeof($files)>1)$subject = "You have created these documents";
                $htmlContent = '

                ';
                $headers = "From: $fromName"." <".$from.">";
                $semi_rand = md5(time());
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
                $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";
                if(!empty($files)){
                    for($i=0;$i<count($files);$i++){
                        if(is_file($files[$i])){
                            $file_name = basename($files[$i]);
                            $file_size = filesize($files[$i]);

                            $message .= "--{$mime_boundary}\n";
                            $fp =    @fopen($files[$i], "rb");
                            $data =  @fread($fp, $file_size);
                            @fclose($fp);
                            $data = chunk_split(base64_encode($data));
                            $message .= "Content-Type: application/octet-stream; name=\"".$file_name."\"\n" .
                            "Content-Description: ".$file_name."\n" .
                            "Content-Disposition: attachment;\n" . " filename=\"".$file_name."\"; size=".$file_size.";\n" .
                            "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                        }
                    }
                }

                $message .= "--{$mime_boundary}--";
                $returnpath = "-f" . $from;

                $mail = @mail($to, $subject, $message, $headers, $returnpath);

                // Return true, if email sent, otherwise return false
                if($mail){
                    return 'Email have sent successfully';
                }else{
                    return 'Error ! ';
                }

            }else{
                return 'You have not saved document yet.';
            }
        }
    }

    public function store(Request $request)
    {
        $customer = $this->getFromApi('GET', 'customers/'.$request->customer_id);
        $project = $this->getFromApi('GET', 'projects/'.$request->project_id);

        $this->updateDocument($customer->name,$project->name,$request->language,$request->directory,$request->knowledge_area,$request->archives,$request->filename,NULL,$request->kind);
        
        if ($request->kind == 1)
        {
            Session::flash('message','Document was successfully saved');
        }
        else
        {
            Session::flash('message','Document generated successfully');
        }

        return Redirect::to('/catalog');
    }

    //Actualiza vista previa de documento (guarda en carpeta public documento odt actualizado)
    public function updatePreview()
    {
        $customer = $this->getFromApi('GET', 'customers/'.$_POST['customer_id']);
        $project = $this->getFromApi('GET', 'projects/'.$_POST['project_id']);

        return $this->updateDocument($customer->name,$project->name,$_POST['language'],$_POST['directory'],$_POST['knowledge_area'],$_POST['archives'],$_POST['filename'],1,$_POST['kind'],$_POST['customer_logo']);
    }

    public function catchsignature($filename){
        $sig = Signature::where('name',$filename.'.odt')->first();
        if($sig){
            //DB::table('signature')->where('name','defaultname')->delete();
            return 'success';
        }else{
            return 'fail';
        }
    }

    public function modificarTemplate()
    {
        $array = [
            'PROJECT_NAME' => 'chanz',
            'OUR_LOGO' => 'asd',
            'CUSTOMER_LOGO' => 'asd',
            'NUMBER' => '123',
            'DATE' => date('d/m/Y')
        ];
        $extension = 'docx';
        $nameFile = 'TemplateTest';
        $archivo = storage_path("doc/" . $nameFile . '.docx');
        $template = new \PhpOffice\PhpWord\TemplateProcessor($archivo);

        foreach ($array as $key => $value) {
            if ($key == 'OUR_LOGO' or $key == 'CUSTOMER_LOGO') {
                $template->setImageValue("$key",
                    [
                        "path" => $value,
                        "width" => 45,
                        "height" => 45
                    ]
                );
            } else {
                $template->setValue($key, $value);
            }
        }

        $archivo = storage_path('doc/' . $nameFile . '2.docx');
        $template->saveAs($archivo);

        shell_exec('libreoffice --headless --convert-to pdf ' . $archivo);
        return response()->download(storage_path('doc/' . $nameFile . '2.pdf'));


        //return response()->download(storage_path('doc/'.$nameFile.'2.docx'));
    }

    public function download(Request $request)
    {
        $destinationPath = "app/public/repository/" . $request->file;
        // echo $destinationPath;
        if (Storage::disk('repository')->exists($request->file)) 
        {
            return response()->download(storage_path($destinationPath));
        }
    }

    public function delete(Request $request)
    {
        $destinationPath = "app/public/repository/" . $request->file;
        // echo $destinationPath;
        if ($exists = Storage::disk('repository')->exists($request->file)) {
            Storage::disk('repository')->delete($request->file);
            return response()->json(array('success' => true, 'message'=> __('general.deleted')));
        } else {
            return response()->json(array('success' => false));
        }
    }

    public function sendFile()
    {
        $cc = '';
        //Vemos si hay cc
        if ($_POST['cc'] != '')
        {
            $cc = str_replace(' ','',$_POST['cc']); //Eliminamos espacios si es que hay
            $cc = str_replace(',',';',$cc); //Si es que se agregaron , en vez de ;, los cambiamos

            if (strpos($cc,';')) 
            {
                $cc = explode(';',$cc);
            }
        }

        $file = public_path($_POST['filename']);
        $to = $_POST['to'];
        $user_mail = Auth::user()->email;
        $subject = $_POST['subject'];

        Mail::send('send_mail',['body' => $_POST['message']], function ($msg) use ($to,$user_mail,$subject,$cc,$file)
        {   
            $msg->to($to)->bcc($user_mail)->subject($subject);
            if ($cc != '') 
            {
                $msg->cc($cc);
            }

            $msg->attach($file, ['as' => $_POST['filename']]);
        });

        Session::flash('message','Document was successfully sended');

        return Redirect::to('/catalog');
    }
}