<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class QuotationMaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($quotation_id){
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$quotation = $this->getFromApi('GET', 'quotation/'.$quotation_id);
    	$materials = $this->getFromApi('GET', 'materials?company_id='.$company->id);

    	return response()->json([
    		'view' => view('quotation_material/create', [
				'currencies'   => $currencies,
				'quotation'     => $quotation,
				'materials'     => $materials,
			] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'quotation_id' => 'required',
			'cost'        => 'required',
			'amount'        => 'required',
			'detail'        => 'required',
			'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'quotation_materials', $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.item_store')]
	    	)->validate();
    	}
    	else
    	{
            $this->apiCall('GET', 'quotation/'.$request->quotation_id."/update_total");
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
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    	$quotationMaterial = $this->getFromApi('GET', 'quotation_materials/'.$id);
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$materials = $this->getFromApi('GET', 'materials?company_id='.$company->id);
        $quotation = $this->getFromApi('GET', 'quotation/'.$quotationMaterial->quotation_id);
    	return response()->json([
    		'view' => view('quotation_material/edit', [
				'quotationMaterial'   => $quotationMaterial,
				'currencies'        => $currencies,
				'materials'        => $materials,
				'quotation'        => $quotation,
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
			 'cost'        => 'required',
			 'amount'   => 'required',
			 'detail'   => 'required',
			 'currency_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'quotation_materials/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.item_store')]
	    	)->validate();
    	}
    	else
    	{
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);
            $this->apiCall('GET', 'quotation/'.$jsonRes['data']['quotation_id']."/update_total");
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
    	$quotationMaterial = $this->getFromApi('GET', 'quotation_materials/'.$id);
    	$res = $this->apiCall('DELETE', 'quotation_materials/'.$id);

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
            $this->apiCall('GET', 'quotation/'.$quotationMaterial->quotation_id."/update_total");

    		session()->flash('message', __('general.deleted'));
			session()->flash('alert-class', 'success');
    	}

    	return redirect('quotations/rows/'.$quotationMaterial->quotation_id);

    	// if (!isset($jsonRes))
    	// {
    	// 	return redirect('project_board/rows/');
    	// }
    	// else
    	// {
    	// 	return redirect()->action('ProjectController@index');
    	// }
    }
}
