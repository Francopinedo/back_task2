<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use PhpOffice\PhpWord\TemplateProcessor;
use File;

class MetavariablesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guest())
        {
            $metavariables = $this->getFromApi('GET', 'metavariables/datatables');
            $metadocuments = $this->getFromApi('GET', 'metadocuments');
            $metavariable_kinds = $this->getFromApi('GET', 'metavariable_kinds');
            return view('metavariables/index', ['metavariables' => $metavariables, 'metadocuments' => $metadocuments, 'metavariable_kinds' => $metavariable_kinds]);
        }
        else
        {
            return Redirect::to('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::guest())
        {
            // validacion del formulario
            $validator =Validator::make($request->all(), [
                'name' => 'required',
                'metadocument_id' => 'required',
                'metavariable_kind_id' => 'required',
                'width' => 'integer|between:1,100',
            ]);

            if ($validator->fails()) 
            {
                return response()->json($validator->errors(), 422);
            } 
            
            $data = $request->all();
            $res = $this->apiCall('POST', 'metavariables', $data);

            // validacion de la respuesta del api      
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
            {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.metavariables_store')]
                )->validate();
            }
            else
            {
                session()->flash('message', __('general.added'));
                session()->flash('alert-class', 'success');
            }
            
            return response()->json();
        }
        else
        {
            return Redirect::to('/');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $metavariable = $this->getFromApi('GET', 'metavariables/'.$id);

    	$metadocuments = $this->getFromApi('GET', 'metadocuments');
        $metavariable_kinds = $this->getFromApi('GET', 'metavariable_kinds');

    	return response()->json([
    		'view' => view('metavariables/edit', ['metavariable' => $metavariable,'metadocuments' => $metadocuments, 'metavariable_kinds' => $metavariable_kinds] )->render()
    	]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
			'name' => 'required',
			'metadocument_id' => 'required',
            'metavariable_kind_id' => 'required',
            'width' => 'numeric|between:1,100',
	    ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

        $res = $this->apiCall('PATCH', 'metavariables/'.$data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.metavariables_store')]
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = $this->apiCall('DELETE', 'metavariables/'.$id);

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

    	return redirect()->action('MetavariablesController@index');
    }

    public function updateVariables($language,$folder,$filename,$kind)
    {
        //try 
        //{
            DB::transaction(function() use ($language,$folder,$filename,$kind) 
            {
                if(file_exists(storage_path('app/public/catalog/'.$language.'/tagged/'.$folder.'/'.$filename.'.docx'))){
                    $file = storage_path('app/public/catalog/'.$language.'/tagged/'.$folder.'/'.$filename.'.docx');
                    $extension = ".docx";
                }
                if(file_exists(storage_path('app/public/catalog/'.$language.'/tagged/'.$folder.'/'.$filename.'.doc'))){
                    $file = storage_path('app/public/catalog/'.$language.'/tagged/'.$folder.'/'.$filename.'.doc');
                    $extension = ".doc";
                }

                // $file = storage_path('app/public/catalog/'.$language.'/tagged/'.$folder.'/'.$filename.'.docx');
                $template = new \PhpOffice\PhpWord\TemplateProcessor($file);
                $vars = $template->getVariables();

                //Lenguaje
                $lang = \App\Language::where('code','=',$language)->first();
                //Obtenemos metadocument
                $metadocument = \App\Metadocument::where('path_ref','=',$filename)->where('language_id','=',$lang->id)->first();

                //Si no existe, lo creamos (y sólo si kind = 1, que es cuando se llama desde metavariables (para que no se guarde 2 veces))
                if (empty($metadocument) && $kind == 1)
                {
                    $metadocument = \App\Metadocument::create([
                        'name' => $filename,
                        'language_id' => $lang->id,
                        'version' => 1,
                        'path_ref' => $filename,
                        'activity_id' => 1,
                        'doctype_id' => 1,
                        'code' => 0
                    ]);
                }
                $ovars = []; //Guardamos el nombre de las variables
                //Primero creamos las variables que estén en el documento y no en la bf
                foreach ($vars as $v)
                {
                    //Si es logo, no hacemos nada (OUR_LOGO, CUSTOMER_LOGO u otro)
                    if (!strpos($v,'LOGO'))
                    {
                        //separamos nombre de código
                        $var = explode('[[',$v);

                        //Vemos si es que alguna variable no está formateada correctamente
                        if (!isset($var[1]))
                        {
                            return 99;
                        }
                        //Ahora obtenemos sólo código
                        $code = explode(']]',$var[1]);
                        $code = $code[0];
                        $var = $var[0];
                        $ovars[] = $var;
                        if ($code != 'metagrid' && $code != '1')
                        {
                            //$name = $language == 'ES' ? 'name_es' : 'name_en';
                            //Vemos si ya existe en DB
                            $metavariable = \App\Metavariable::where('name','=',$var)->where('metadocument_id','=',$metadocument->id)->withTrashed()->first();
                            
                            if (empty($metavariable) && $kind == 1)
                            {
                                //Verificamos que no exista ya eliminada
                                //Guardamos, para esto tomamos también el tipo (que es el siguiente índice)
                                $metavariable_kind = \App\MetavariableKind::where('code','=',$code)->first();

                                //Vemos si existe metavariable_kind
                                if (empty($metavariable_kind))
                                {
                                    return 99;
                                }
                                $metakind = !empty($metavariable_kind) ? $metavariable_kind->id : NULL;
                                $metavariable = \App\Metavariable::create([
                                    'name'=> $var,
                                    'metavariable_kind_id' => $metakind,
                                    'metadocument_id' => $metadocument->id
                                ]);
                            }
                            else if ($metavariable->deleted_at != NULL)
                            {
                                $metavariable->restore();
                            }
                        }
                        else if ($code == 'metagrid')
                        {
                            //Vemos si existe metagrid
                            $metagrid = \App\Metagrid::where('metadocument_id','=',$metadocument->id)->where('name','=',$var)->first();

                            if (empty($metagrid) && $kind == 1)
                            {
                                $metagrid = \App\Metagrid::create([
                                    'name' => $var,
                                    'metadocument_id' => $metadocument->id
                                ]);
                            }
                        }
                    }
                }

                //Ahora buscamos si hay alguna variable en la base que no esté en el documento (para eliminarla)
                $metavariables = $this->getFromApi('GET', 'metavariables/'.$language.'/'.$filename);

                foreach ($metavariables as $m)
                {
                    //Vemos si la metavariable existe en el doc
                    if (!in_array($m->name,$ovars))
                    {
                        $mv = \App\Metavariable::find($m->id);
                        $mv->delete();
                    }
                }

                return 0;
            });
        //}
        //catch (\Exception $e)
        //{
        //    print_r($e->getMessage());
        //    return 99;
        //}
    }
    public function getFromFile($lang,$folder,$file)
    {
        if(file_exists(storage_path('app/public/catalog/'.$lang.'/tagged/'.$folder.'/'.$file.'.docx'))){
            $file2 = storage_path('app/public/catalog/'.$lang.'/tagged/'.$folder.'/'.$file.'.docx');
            $extension = ".docx";
        } 
        else if(file_exists(storage_path('app/public/catalog/'.$lang.'/tagged/'.$folder.'/'.$file.'.doc'))){
            $file2 = storage_path('app/public/catalog/'.$lang.'/tagged/'.$folder.'/'.$file.'.doc');
            $extension = '.doc';
        }else {
            return "File Type must be .doc or .docx"; 
        }
        // echo $file2;
        File::delete($file.$extension);
        File::delete($file.'.odt');

        $filewithroute = explode('.',$file);
        $filename2 = explode('.',$file);
        $metagrids = $this->getFromApi('GET', 'metagrids/'.$lang.'/'.$filewithroute[0]);
        $template = new \PhpOffice\PhpWord\TemplateProcessor($file2);

        //Realizamos ciclo para Sacar metavariables del documento
        $language = \App\Language::where('code',$lang)->first();
        $metadocument = \App\Metadocument::where('path_ref',$filename2[0])->where('language_id',$language->id)->first();        
        $mvs = \App\Metavariable::where('metadocument_id',$metadocument->id)->get();

        foreach ($mvs as $mv)
        {
            //Ahora obtenemos código de metavariable_kind_id
            $mvk = \App\MetavariableKind::find($mv->metavariable_kind_id);
                    
            //Ahora creamos variable que incluya código
            $new_key = $mv->name.'[['.$mvk->code.']]';
            $template->setValue($new_key,'<a href="#" id="'.$mv->name.'_prev" onclick="goToForm(\''.$mv->name.'\')">Ver en formulario</a>');
        }

        $docs = \App\Document::where('metadocument_id',$metadocument->id)->get();
        foreach ($docs as $doc)
        {
            //Cambiamos estado también a variables asociadas
            $variables = \App\Variable::where('document_id',$doc->id)
                                        ->delete();
            $doc->delete();
        }

        //Ahora sacamos de metagrids
        foreach ($metagrids as $mg)
        {           
            //Ahora creamos variable que incluya código
            $new_key = $mg->name.'[[metagrid]]';
            $template->setValue($new_key,'<a href="#" id="'.$mv->name.'_prev" onclick="goToForm(\''.$mv->name.'\')">Ver en formulario</a>aaaaa');
        }

        $new_file = $file.$extension;

        $template->saveAs($new_file);
        
        $command = "export HOME=/var/www/html/devpanel && libreoffice --headless --convert-to odt ".$new_file;
        exec($command);
        
        //Primero actualizamos variables en caso de ser necesario
        $response = $this->updateVariables($lang,$folder,$file,1);
        if ($response != 0)
        {
            return $response;
        }
        $metavariables = $this->getFromApi('GET', 'metavariables/'.$lang.'/'.$file);
        
        //Obtenemos valores guardados (si es que existen)
        foreach ($metavariables as $m)
        {
            $var = \App\Variable::where('metavariable_id',$m->id)->orderBy('created_at','DESC')->first();
            $m->var = !empty($var) ? $var->value : '';
        }
        // array_push($metavariables,Auth::user()->id);
        return $metavariables;
    }
}