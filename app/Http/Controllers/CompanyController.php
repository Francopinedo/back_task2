<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Company;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show()
    {
		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

        return view('company/show', [
			'company' => $company
        ]);
    }

    /**
     * Form para editar
     */
    public function edit()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id().'?include=industry,city,currency');

    	$cities = $this->getFromApi('GET', 'cities?company_id='.$company->id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$industries = $this->getFromApi('GET', 'industries');

    	return view('company/edit', [
			'company'                   => $company,
			'cities'                    => $cities,
			'currencies'                => $currencies,
			'industries'                => $industries
        ]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
    	/*==========================================================
    	=            ACTUALIZO DATOS BASICOS DE COMPANY            =
    	==========================================================*/
    	$companyData = $request->company;

    	$res = $this->apiCall('PATCH', 'companies/'.$companyData['id'], $companyData);

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
    		dd($res);
    		session()->flash('message', __('general.updated'));
			session()->flash('alert-class', 'success');
    	}

    	if ($request->hasFile('logo'))
    	{
    		$file = Request::file('logo');
			$extension = $file->getClientOriginalExtension();

			$name = $res->
			Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		}
    	/*=====  End of ACTUALIZO DATOS BASICOS DE COMPANY  ======*/

    	return response()->json();
    }
}
