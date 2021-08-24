<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
    	$countries = $this->getFromApi('GET', 'countries');
    	$cities = array();
    	$industries = $this->getFromApi('GET', 'industries');

        return view('contact/index', [
			'company'   => $company,
			'projects'  => $projects,
			'countries' => $countries,
			'cities' => $cities,
			'industries' => $industries,
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {

    	// validacion del formulario
    	$validator =Validator::make($request->all(), [
			//'project_id'            => 'required',
			'company_id'            => 'required',
			'name'                  => 'required',
			'company'               => 'required',
			'department'            => 'required',
			'country_id'            => 'required',
			'industry_id'           => 'required',
			'email'                 => 'required|email',
			'phone'                 => 'required|phone:VE,US,AR'
	    ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        $data = $request->all();
        $data['user_id']=Auth::id();
    	$res = $this->apiCall('POST', 'contacts', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.contact_store')]
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
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$contact = $this->getFromApi('GET', 'contacts/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$projects = $this->getFromApi('GET', 'projects?company_id='.$company->id);
	
    	$countries = $this->getFromApi('GET', 'countries');
    	$cities = $this->getFromApi('GET', 'cities?country_id='.$contact->country_id);
    	$industries = $this->getFromApi('GET', 'industries');

    	return response()->json([
    		'view' => view('contact/edit', [
				'contact'   => $contact,
				'company'   => $company,
				'projects'  => $projects,
				'countries' => $countries,
				'cities' => $cities,
				'industries' => $industries,
			] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [
            //'project_id'            => 'required',
            'name'                  => 'required',
            'company'               => 'required',
            'department'            => 'required',
            'country_id'            => 'required',
            'industry_id'           => 'required',
            'email'                 => 'required|email',
            'phone'                 => 'required|phone:VE,US,AR'
	    ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();
        $data['user_id']=Auth::id();
    	$res = $this->apiCall('PATCH', 'contacts/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.contact_store')]
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
    	$res = $this->apiCall('DELETE', 'contacts/'.$id);

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

    	return redirect()->action('ContactController@index');
    }

    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('contact/import', [

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
            $item['user_id']=Auth::id();
            $item['company_id'] =$company->id;

            foreach ($array as $value) {

                if (isset($value[2])) {

                    $country = $this->getFromApi('GET', 'countries?name=' . $value[2] . '&company_id=' . $company->id);
                    $city = $this->getFromApi('GET', 'cities?name=' . $value[3] . '&company_id=' . $company->id);
                    $industry = $this->getFromApi('GET', 'industries?name=' . $value[4] . '&company_id=' . $company->id);

                    if (isset($city[0]) && isset($country[0]) && isset($industry[0]) ) {

                        $item['name'] = $value[0];

                        $item['department'] = $value[1];
                        $item['country_id'] = $country[0]->id;
                        $item['city_id'] = $city[0]->id;
                        $item['industry_id'] = $industry[0]->id;
                        $item['email'] = $value[5];
                        $item['phone'] = $value[6];
                        $item['comments'] = $value[7];
                        $item['company'] = $value[8];

                        $result = $this->apiCall('POST', 'contacts', $item);

                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }

}
