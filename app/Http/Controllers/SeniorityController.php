<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SeniorityController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

        return view('seniority/index', [
			'company'       => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$seniority = $this->getFromApi('GET', 'seniorities/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	return response()->json([
    		'view' => view('seniority/edit', [
    			'seniority' => $seniority
    		] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'title'      => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('POST', 'seniorities', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.senioritys_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'title'      => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'seniorities/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.seniority_store')]
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
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
    	$res = $this->apiCall('DELETE', 'seniorities/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	session()->flash('message', __('api_errors.delete'));
			session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.seniority_delete')]
	    	)->validate();

    	}
    	else
    	{
    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect()->action('SeniorityController@index');
    }


    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('seniority/import', [

                'company' => $company,
                'cities' => $cities
            ])->render()
        ]);
    }

    public function do_import(Request $request)
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $array = array();
        try {
            $validator =Validator::make($request->all(), [

                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);


            $item = array();
            $item['company_id'] = $company->id;
            
            foreach ($array as $value) {

                if (isset($value[0])) {

                    $item['title'] = $value[0];

                    $this->apiCall('POST', 'seniorities', $item);

                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }

}
