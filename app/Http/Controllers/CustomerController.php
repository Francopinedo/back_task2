<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Customer;

class CustomerController extends Controller
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
    	$data['cities'] = $this->getFromApi('GET', 'cities');
    	$data['currencies'] = $this->getFromApi('GET', 'currencies');
    	$data['industries'] = $this->getFromApi('GET', 'industries');

    	if (Auth::user()->hasRole('admin'))
    	{
    		$data['customers'] = $this->getFromApi('GET', 'customers?include=industry,city,currency');
    	}
    	else
    	{
    		$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());
    		$data['company'] = $company;
    		$data['customers'] = $this->getFromApi('GET', 'customers?include=industry,city,currency&company_id='.$company->id);
    	}

        return view('customer/index', $data);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$customer = $this->getFromApi('GET', 'customers/'.$id);

    	$cities = $this->getFromApi('GET', 'cities');
    	$currencies = $this->getFromApi('GET', 'currencies');
    	$industries = $this->getFromApi('GET', 'industries');

    	return response()->json([
    		'view' => view('customer/edit', ['customer' => $customer, 'cities' => $cities, 'currencies' => $currencies, 'industries' => $industries] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$this->validate($request, [
			'name'       => 'required',
			'company_id' => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('POST', 'customers', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.customer_store')]
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
			'name'     => 'required'
	    ]);

    	$data = $request->all();

    	$res = $this->apiCall('PATCH', 'customers/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.customer_store')]
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
    	$res = $this->apiCall('DELETE', 'customers/'.$id);

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

    	return redirect()->action('CustomerController@index');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
		$customer = $this->getFromApi('GET', 'customers/'.$id.'?include=industry,city,currency');

    	return response()->json([
    		'view' => view('customer/show', ['customer' => $customer] )->render(),
    	]);
    }

    /**
     * Muestra listado
     */
    public function forProjectSelection()
    {
    	$company = $this->getFromApi('GET', 'companies/fromUser/'.Auth::id());

    	$customers = $this->getFromApi('GET', 'customers?include=projects&company_id='.$company->id);

    	foreach ($customers as $key => $customer)
    	{
    		if (empty($customer->projects->data))
    		{
    			unset($customers[$key]);
    		}
    	}

    	return response()->json([
    		'view' => view('customer/forProjectSelection', ['customers' => $customers] )->render()
    	]);
    }

    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('customer/import', [

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
            $this->validate($request, [
                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);



            foreach ($array as $value) {


                if (isset($value[2])) {
                    $item = array();


                    $city = $this->getFromApi('GET', 'cities/?name=' . $value[2] . '&company_id=' . $company->id);



                    if (isset($city[0])) {

                        $item['city_id'] = $city[0]->id;
                        $item['company_id'] =$company->id;

                        $item['name'] = $value[0];
                        $item['address'] = $value[1];
                        $item['email'] = $value[3];
                        $item['phone'] = $value[4];
                        $item['billing_name'] = $value[5];
                        $item['billing_address'] = $value[6];
                        $item['tax_number1'] = $value[7];
                        $item['tax_number2'] = $value[8];



                        $this->apiCall('POST', 'customers', $item);

                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }
}