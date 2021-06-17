<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
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
    	$res = $this->apiCall('GET', 'countries');

        $cties = $this->getFromApi('GET', 'cities?company_id='.$company->id);

        if(count($cties)<1){
          //  $this->apiCall('POST', 'cities/reload', ['company_id'=>$company->id]);
        }


    	$countries = json_decode($res->getBody()->__toString())->data;
        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
        return view('city/index', [
        	'countries' => $countries,
            'company' => $company,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$city = $this->getFromApi('GET', 'cities/'.$id);

    	$res = $this->apiCall('GET', 'countries');
    	$countries = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('city/edit', ['city' => $city, 'countries' => $countries] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'       => 'required',
			'location_name'   => 'required',
			'company_id'   => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('POST', 'cities', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.city_store')]
	    	)->validate();
    	}
    	else
    	{
    		session()->flash('message', __('general.added'));
			session()->flash('alert-class', 'success');
    	}

    	return response()->json();
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'     => 'required',
			'location_name'   => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'cities/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.city_store')]
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
    	$res = $this->apiCall('DELETE', 'cities/'.$id);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{

	    	session()->flash('message', __('api_errors.delete').' this record has relations with others fields in Taskcontrol');
			session()->flash('alert-class', 'danger');

	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            //return $jsonRes;
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

    	return redirect()->action('CityController@index');
    }

    public function import()
    {

        return response()->json([
            'view' => view('city/import')->render()
        ]);
    }

    public function do_import(Request $request)
    {

        $array = array();
        try {
            $validator =Validator::make($request->all(), [

                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);

            $city =array();
            $company =array();
            $country =array();
            $item = array();
            $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $item['company_id'] = $company->id;
         	$item['added_by'] = Auth::id();

            foreach ($array as $value) {
            
                if (isset($value[2])) {

                    $country = $this->getFromApi('GET', 'country?name=' . $value[2]);

                    //  var_dump($industry);
                    if (isset($city[0]) && isset($country[0])) {

                        $item['name'] = $value[0];
                        $item['location_name'] = $value[1];
                        $item['timezone'] = $value[3];
                        $item['country_id'] = $country[0]->id;

                        $res=  $this->apiCall('POST', 'cities', $item);
                        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
                        {
                            session()->flash('message', 'Error with format file, some rows not import');
                            session()->flash('alert-class', 'error');
                            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                            return response()->json(array('success' => false, 'message' => 'Error with format file, some rows not import'));
                        }
                    }
                }
            }
        } catch (Exception $exception) {
            session()->flash('message', 'Error with format file');
            session()->flash('alert-class', 'error');
          return response()->json(array('success' => false, 'message' => 'Error with format file'));
       }
         session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        //return response()->json();
        return response()->json(array('success' => true));
    }


public function reload(Request $request)
{
    $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

    $data = $request->all();
    $data['company_id'] = $company->id;
    
    $res = $this->apiCall('POST', 'cities/reload',$data);

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

        }else
        {
            session()->flash('message', __('general.reloaded'));
            session()->flash('alert-class', 'success');
        }

        return response()->json(array('success' => true));
}




}
