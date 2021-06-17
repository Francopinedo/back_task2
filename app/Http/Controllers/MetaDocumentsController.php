<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Redirect;

class MetaDocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $metadocuments = $this->getFromApi('GET', 'metadocuments/datatables');
        $languages = $this->getFromApi('GET', 'languages');
        $activities = \App\Activity::all();
        $docTypes = \App\DocType::all();
        return view('metadocuments/index', ['metadocuments' => $metadocuments,'languages' => $languages, 'activities' => $activities, 'docTypes' => $docTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*public function create()
    {

    }*/
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [
			'name' => 'required',
			'language_id' => 'required',
			'activity_id' => 'required',
            'doctype_id' => 'required',
            'version' => 'required',
            'path_ref' => 'required',
	    ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        } 
        
        $data = $request->all();
        $res = $this->apiCall('POST', 'metadocuments', $data);
        //$res = \App\Metadocu::create($data);

        // validacion de la respuesta del api      
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.metadocuments_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}
        
    	return response()->json();
        //
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
        $metadocument = $this->getFromApi('GET', 'metadocuments/'.$id);

    	$languages = $this->getFromApi('GET', 'languages');
        $activities = \App\Activity::all();
        $docTypes = \App\DocType::all();

    	return response()->json([
    		'view' => view('metadocuments/edit', ['metadocument' => $metadocument,'languages' => $languages, 'activities' => $activities, 'docTypes' => $docTypes] )->render()
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
			'language_id' => 'required',
			'activity_id' => 'required',
            'doctype_id' => 'required',
            'version' => 'required',
           
	    ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

        $res = $this->apiCall('PATCH', 'metadocuments/'.$data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.metadocuments_store')]
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
        $res = $this->apiCall('DELETE', 'metadocuments/'.$id);

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

    	return redirect()->action('MetaDocumentsController@index');
    }

    public function generateDocument()
    {
        if (!Auth::guest())
        {
             //$metavariables = $this->getFromApi('GET', 'metavariables');
            $idiomas = $this->getFromApi('GET', 'languages');


            $params =[
                'directories'    => array(),
                //'metavariables' => $metavariables,
                'idiomas'       => $idiomas,
            ];

            return view('metadocuments/generate' , $params);
        }
        else
        {
            return Redirect::to('/');
        }
    }
}
