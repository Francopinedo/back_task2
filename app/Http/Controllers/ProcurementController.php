<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProcurementController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'deletecontrol', 'loglevel']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

        return view('procurement/index', [
			'currencies' => $currencies,
			'company'    => $company,
			'providers'  => $providers,
			'users'      => $users,
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'project_id'       => 'required',
			'cost_currency_id' => 'required',
			'cost'             => 'numeric|required',
			'description'      => 'required',
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'procurements', $data);


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
    	$procurement = $this->getFromApi('GET', 'procurements/'.$id);

    	$currencies = $this->getFromApi('GET', 'currencies');
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$providers = $this->getFromApi('GET', 'providers?company_id='.$company->id);
    	$users = $this->getFromApi('GET', 'users?company_id='.$company->id);

    	return response()->json([
    		'view' => view('procurement/edit', [
    			'procurement'   => $procurement,
				'currencies' => $currencies,
				'providers' => $providers,
				'company'    => $company,
				'users'    => $users,
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

			'description'     => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'procurements/'.$data['id'], $data);

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
    	$res = $this->apiCall('DELETE', 'procurements/'.$id);

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

    	return redirect()->back();
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$res = $this->apiCall('GET', 'procurements/'.$id.'?include=industry,city,currency');
    	$company = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('procurement/show', ['company' => $company] )->render(),
    	]);
    }

    /**
     * Muestra listado de rows
     */
    public function rows($procurement_id)
    {
    	$data['procurement_id'] = $procurement_id;

    	$data['currencies'] = $this->getFromApi('GET', 'currencies');
		$data['company'] = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
		$data['contacts'] = $this->getFromApi('GET', 'contacts?company_id='.$data['company']->id);
		$data['project'] = $this->getFromApi('GET', 'projects/'.session('project_id').'?include=customer');

        return view('procurement/rows', $data);
    }
}
