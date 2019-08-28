<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class ProviderController extends Controller
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
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $countries = $this->getFromApi('GET', 'countries');
        $cities = $this->getFromApi('GET', 'cities?company_id=' . $company->id);
        $currencies = $this->getFromApi('GET', 'currencies');
        $industries = $this->getFromApi('GET', 'industries');
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        return view('provider/index', [
            'countries' => $countries,
            'cities' => $cities,
            'currencies' => $currencies,
            'industries' => $industries,
            'company' => $company
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
            'currency_id' => 'required',
            'industry_id' => 'required'
        ]);

        $data = $request->all();

        $res = $this->apiCall('POST', 'providers', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.company_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $provider = $this->getFromApi('GET', 'providers/' . $id);

        $countries = $this->getFromApi('GET', 'countries');
        $cities = $this->getFromApi('GET', 'cities');
        $currencies = $this->getFromApi('GET', 'currencies');
        $industries = $this->getFromApi('GET', 'industries');
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        return response()->json([
            'view' => view('provider/edit', [
                'provider' => $provider,
                'countries' => $countries,
                'cities' => $cities,
                'currencies' => $currencies,
                'industries' => $industries,
                'company' => $company
            ])->render()
        ]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'name' => 'required'
        ]);

        $data = $request->all();

        $res = $this->apiCall('PATCH', 'providers/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.company_store')]
            )->validate();
        } else {
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
        $res = $this->apiCall('DELETE', 'providers/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');

            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('ProviderController@index');
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
        $res = $this->apiCall('GET', 'providers/' . $id . '?include=industry,city,currency');
        $company = json_decode($res->getBody()->__toString())->data;

        return response()->json([
            'view' => view('provider/show', ['company' => $company])->render(),
        ]);
    }


    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('provider/import', [

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

            //var_dump($array);

            foreach ($array as $value) {

                $city =array();
                $currency =array();
                $industry =array();
                if (isset($value[17]) && isset($value[18])  && isset($value[2])) {
                    $item = array();


                    $city = $this->getFromApi('GET', 'cities/?name=' . $value[2] . '&company_id=' . $company->id);
                    $currency = $this->getFromApi('GET', 'currencies/?code=' . $value[17]);
                    $industry = $this->getFromApi('GET', 'industries/?name=' . $value[18]);


                      //var_dump($city);
                    //  var_dump($industry);
                    if (isset($city[0]) && isset($currency[0]) && isset($industry[0])) {

                        $item['city_id'] = $city[0]->id;
                        $item['currency_id'] = $currency[0]->id;
                        $item['industry_id'] = $industry[0]->id;
                        $item['company_id'] = $company->id;
                        $item['name'] = $value[0];
                        $item['address'] = $value[1];
                        $item['email_1'] = $value[3];
                        $item['email_2'] = $value[4];
                        $item['email_3'] = $value[5];
                        $item['phone_1'] = $value[6];
                        $item['phone_2'] = $value[7];
                        $item['phone_3'] = $value[8];
                        $item['billing_name'] = $value[9];
                        $item['billing_address'] = $value[10];
                        $item['tax_number'] = $value[11];
                        $item['bank_name'] = $value[12];
                        $item['account_number'] = $value[13];
                        $item['account_number'] = $value[14];
                        $item['swiftcode'] = $value[15];
                        $item['aba'] = $value[16];


                        $this->apiCall('POST', 'providers', $item);
                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }


}
