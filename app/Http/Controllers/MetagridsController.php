<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MetavariablesController;
 use PhpOffice\PhpWord\TemplateProcessor;

class MetagridsController extends Controller
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
            $metagrids = $this->getFromApi('GET', 'metagrids/datatables');
            $metadocuments = $this->getFromApi('GET', 'metadocuments');
            return view('metagrids/index', ['metagrids' => $metagrids, 'metadocuments' => $metadocuments]);
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
                'metadocument_id' => 'required'
            ]);

            if ($validator->fails()) 
            {
                return response()->json($validator->errors(), 422);
            } 
            
            $data = $request->all();
            $res = $this->apiCall('POST', 'metagrids', $data);

            // validacion de la respuesta del api      
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
            {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.metagrids_store')]
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
        $metagrid = $this->getFromApi('GET', 'metagrids/'.$id);

    	$metadocuments = $this->getFromApi('GET', 'metadocuments');

    	return response()->json([
    		'view' => view('metagrids/edit', ['metagrid' => $metagrid,'metadocuments' => $metadocuments] )->render()
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
	    ]);

        if ($validator->fails()) 
        {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

        $res = $this->apiCall('PATCH', 'metagrids/'.$data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.metagrids_store')]
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
        $res = $this->apiCall('DELETE', 'metagrids/'.$id);

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

    	return redirect()->action('MetagridsController@index');
    }

    public function getFromFile($language,$folder,$file)
    {
        //Actualizamos
        $metavariable = new MetavariablesController;

        $metavariable->updateVariables($language,$folder,$file,NULL);
        $metagrids = $this->getFromApi('GET', 'metagrids/'.$language.'/'.$file);
        return $metagrids;
    }
}
