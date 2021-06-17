<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class ExchangeRateController extends Controller
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

    	$currencies = $this->getFromApi('GET', 'currencies');

        return view('exchange_rate/index', [
			'currencies'    => $currencies,
			'company'       => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$exchange_rate = $this->getFromApi('GET', 'exchange_rates/'.$id);

    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$currencies = $this->getFromApi('GET', 'currencies');

    	return response()->json([
    		'view' => view('exchange_rate/edit', [
    			'exchange_rate' => $exchange_rate,
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

			'value'      => 'numeric|required',
			'company_id'  => 'required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('POST', 'exchange_rates', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.exchange_rate_store')]
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

			'value'      => 'numeric|required',
			'currency_id' => 'required'
	    ]);

    	if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'exchange_rates/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.exchange_rate_store')]
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
    	$res = $this->apiCall('DELETE', 'exchange_rates/'.$id);

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

    	return redirect()->action('ExchangeRateController@index');
    }

    public function import()
    {

        return response()->json([
            'view' => view('exchange_rate/import')->render()
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

            foreach ($array as $value) {
            
                if (isset($value[2])) {
                $currency = $this->getFromApi('GET', 'currencies?code=' . $value[0]);

                    //  var_dump($industry);
                    if (isset($currency)) {

                        $item['value'] = $value[1];
                        $item['currency_id'] = $currency[0]->id;
                       
                        $item['quotation_date'] = $value[2];
                        $item['quotation_url'] = $value[3];

                        $res =  $this->apiCall('POST', 'exchange_rates', $item);

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
}
