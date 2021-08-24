<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Company;

class AdminCompanyController extends Controller
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
    	$res = $this->apiCall('GET', 'cities');
    	// $cities = json_decode($res->getBody()->__toString())->data;

    	$res = $this->apiCall('GET', 'currencies');
    	$currencies = json_decode($res->getBody()->__toString())->data;

    	$res = $this->apiCall('GET', 'industries');
    	$industries = json_decode($res->getBody()->__toString())->data;

        $countries = $this->getFromApi('GET','countries');

    	if (Auth::user()->hasRole('admin'))
    	{
    		$urlDatatables = env('API_PATH').'companies/datatables';
    	}
    	else
    	{
    		$urlDatatables = env('API_PATH').'companies/datatables?user_id='.Auth::id();
    	}

        return view('admin_company/index', [
        	// 'cities' => $cities,
            'countries' => $countries,
        	'currencies' => $currencies,
        	'industries' => $industries,
        	'urlDatatables' => $urlDatatables
        ]);
    }

    public function edit(Request $request)
    {
        $company = $this->getFromApi('GET', 'companies/'.$request->id.'?include=industry,city,currency');

        $cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);
        // $cities = $this->getFromApi('GET', 'cities');
        $currencies = $this->getFromApi('GET', 'currencies');
        $industries = $this->getFromApi('GET', 'industries');

        return response()->json([
            'view' => view('admin_company/edit', [
                'company'                   => $company,
                'cities'                    => $cities,
                'currencies'                => $currencies,
                'industries'                => $industries
            ])->render(),
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
        $validator =Validator::make($request->all(), [
            'name'       => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $data = $request->all() + ['roomName' => 'General'];

        /** Se guarda la ciudad de la compania  */
        $new_city = [
            'name' => $data['city_name'],
            'location_name' => $data['city_name'],
            'country_id' => $data['country_id'],
            // 'company_id' => $company->id,
            'added_by' => 'form'
        ];

        $res = $this->apiCall('POST', 'cities', $new_city);
        $city = json_decode($res->getBody()->__toString())->data;

        $data['city_id'] = $city->id; // Se asigna el identificador de la ciudad a la compania
        
        //call taskcontrol-api for the creation of company and domain
        $apiRoutes = ["companies","irmdomain","irmmailadm","rcadmin","admin","rcgeneralchannel"];
        foreach ($apiRoutes as $route)
        {
            if($route == 'companies')
            {
                $res = $this->apiCall('POST', $route, $data);
                
                $company = json_decode($res->getBody()->__toString())->data;
            }
            else
            {
                $res = $this->apiCall('POST', $route, $data);
            }

            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
            {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.company_store')]
                )->validate();
            }
        }

        $new_city['company_id'] = $company->id;
        $res = $this->apiCall('PATCH', 'cities/'.$city->id, $new_city);

        //call iredmail-api for the creation of domain on mailserver

        if(env('IREDMAIL_API_HOST'))
        {
            $irmApiRoutes = ['irmdomain','admin_mailbox','rcadmin'];
            foreach($irmApiRoutes as  $route)
            {
                $res = $this->iredmailApiCall('POST', $route, $data);
                if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
                {
                    $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                    Validator::make($jsonRes,
                        ['status_code' => [Rule::in(['201', '200'])]],
                        ['in' => __('api_errors.company_store')]
                    )->validate();
                }
            }
        }

        session()->flash('message', __('general.added'));
        session()->flash('alert-class', 'success');

        return response()->json();
    }


    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'     => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'companies/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.company_store')]
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
    	$res = $this->apiCall('DELETE', 'companies/'.$id);

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

    	return redirect()->action('AdminCompanyController@index');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'companies/'.$id.'?include=industry,city,currency');
    	$company = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('admin_company/show', ['company' => $company] )->render(),
    	]);
    }
}
