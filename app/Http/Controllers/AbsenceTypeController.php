<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

use App\AbsenceType;

class AbsenceTypeController extends Controller
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
    	$countries = json_decode($res->getBody()->__toString())->data;
        $cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);

        $absence_types = $this->getFromApi('GET', 'absence_types?company_id='.$company->id);

        if(!empty($absence_types)){
           // $this->apiCall('POST', 'absence_types/reload', ['company_id'=>$company->id]);
        }


        return view('absence_type/index', [
        	'countries' => $countries,
            'cities' => $cities,
        	'company' => $company,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$absenceType = $this->getFromApi('GET', 'absence_types/'.$id);

    	$res = $this->apiCall('GET', 'countries');
    	$countries = json_decode($res->getBody()->__toString())->data;
    	$cities = $this->getFromApi('GET', 'cities?country_id='.$absenceType->country_id);

    	return response()->json([
    		'view' => view('absence_type/edit', ['absenceType' => $absenceType, 'countries' => $countries, 'cities'=>$cities] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [
			'title'      => 'required',
			'days'       => 'numeric|required',
			'city_id'       => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } 
        $data = $request->all();

    	$res = $this->apiCall('POST', 'absence_types', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.absence_type_store')]
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
			'title'     => 'required',
			'days'   => 'numeric|required',
			'city_id'   => 'required',
			'country_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'absence_types/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.absence_type_store')]
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
    	$res = $this->apiCall('DELETE', 'absence_types/'.$id);

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

    	return redirect()->action('AbsenceTypeController@index');
    }

    public function forAbsences($country_id)
    {
    	$absenceTypes = $this->getFromApi('GET', 'absence_types?country_id='.$country_id);

    	return response()->json([
    		'view' => view('absence_type/forAbsences', ['absenceTypes' => $absenceTypes] )->render()
    	]);
    }

    public function import()
    {
        return response()->json([
            'view' => view('absence_type/import')->render()
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

                if (isset($value[2]) && isset($value[3])) {
                   
                    $city = $this->getFromApi('GET', 'cities?name=' . $value[3] . '&company_id=' . $company->id);

                    $country = $this->getFromApi('GET', 'countries?name=' . $value[0]);
                     //var_dump($country);
                    if (!empty($city) && !empty($country)) {

                        $item['country_id'] = $country[0]->id;
                        $item['title'] = $value[1];
                        $item['days'] = $value[2];
                        $item['city_id'] = $city[0]->id;
                        $res =  $this->apiCall('POST', 'absence_types', $item);

                        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
                        {
                            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                            session()->flash('message', 'Error with format file, some rows not import');
                            session()->flash('alert-class', 'error');
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

        $res = $this->apiCall('POST', 'absence_types/reload',$data);

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

        }else{
            session()->flash('message', __('general.reloaded'));
            session()->flash('alert-class', 'success');
        }

        return response()->json(array('success' => true));   
    }

}
