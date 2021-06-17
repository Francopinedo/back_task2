<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ServicesController extends Controller
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

    	$currencies = $this->getFromApi('GET', 'currencies');

        return view('service/index', [
			'currencies'    => $currencies,
			'company'       => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$service = $this->getFromApi('GET', 'services/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$currencies = $this->getFromApi('GET', 'currencies');

    	return response()->json([
    		'view' => view('service/edit', [
    			'service' => $service,
				'currencies'    => $currencies
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

			'detail'      => 'required',
			'amount'        => 'numeric|required',
			'company_id'  => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('POST', 'services', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.service_store')]
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

			'detail'      => 'required',
			'amount'        => 'numeric|required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'services/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.service_store')]
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
    	$res = $this->apiCall('DELETE', 'services/'.$id);

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

    	return redirect()->action('ServicesController@index');
    }

    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('service/import', [

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
            $item['company_id'] =$company->id;

            foreach ($array as $value) {

                if (isset($value[1])) {

                    $curency_amount = $this->getFromApi('GET', 'currencies?code=' . $value[4] . '&company_id=' . $company->id);
                    $curency_cost = $this->getFromApi('GET', 'currencies?code=' . $value[5] . '&company_id=' . $company->id);

                    if (isset($curency_amount[0]) && isset($curency_cost[0])) {

                        $item['reimbursable'] = $value[0];
                        $item['detail'] = $value[1];
                        $item['amount'] = $value[2];
                        $item['cost'] = $value[3];
                        $item['cost_currency_id'] =$curency_cost[0]->id;
                        $item['currency_id'] = $curency_amount[0]->id;

                        $this->apiCall('POST', 'services', $item);

                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }
}
