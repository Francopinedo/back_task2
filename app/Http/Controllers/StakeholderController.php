<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class StakeholderController extends Controller
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
    	$contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

        return view('stakeholder/index', [
			'company'   => $company,
			'contacts'     => $contacts,
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'influence'    => 'required',
			'impacted'     => 'required',
			'impact'       => 'required',
			'expectations' => 'required',
			'contact_id'   => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'stakeholders', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.stakeholder_store')]
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
    	$stakeholder = $this->getFromApi('GET', 'stakeholders/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$contacts = $this->getFromApi('GET', 'contacts?company_id='.$company->id);

    	return response()->json([
    		'view' => view('stakeholder/edit', [
				'stakeholder'   => $stakeholder,
				'company'   => $company,
				'contacts'  => $contacts
			] )->render()
    	]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'influence'    => 'required',
			'impacted'     => 'required',
			'impact'       => 'required',
			'expectations' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'stakeholders/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.stakeholder_store')]
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
    	$res = $this->apiCall('DELETE', 'stakeholders/'.$id);

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

    	return redirect()->action('StakeholderController@index');
    }
}
