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
        $this->middleware('auth');
    }

    /**
     * Muestra listado
     */
    public function index()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$res = $this->apiCall('GET', 'countries');
    	$countries = json_decode($res->getBody()->__toString())->data;


        $absence_types = $this->getFromApi('GET', 'absence_types?company_id='.$company->id);

        if(count($absence_types)<1){
           // $this->apiCall('POST', 'absence_types/reload', ['company_id'=>$company->id]);
        }


        return view('absence_type/index', [
        	'countries' => $countries,
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
    	$this->validate($request, [
			'title'      => 'required',
			'days'       => 'required',
			'city_id'       => 'required',
			'country_id' => 'required'
	    ]);

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
    	$this->validate($request, [
			'title'     => 'required',
			'days'   => 'required',
			'city_id'   => 'required',
			'country_id' => 'required'
	    ]);

    	$data = $request->all();

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
}
