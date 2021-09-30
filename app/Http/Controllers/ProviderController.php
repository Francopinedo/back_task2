<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use App\Provider;

class ProviderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel']);
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
        $validator =Validator::make($request->all(), [

            'name' => 'required',
            'city_id' => 'required',
            'currency_id' => 'required',
            'industry_id' => 'required',
            'phone_1'                 => 'phone|nullable',
            'phone_2'                 => 'phone|nullable',
            'phone_3'                 => 'phone|nullable',
            'swiftcode'               => 'min:8|max:11',
            'aba'                     => 'min:9',
            'email_1'                 => 'email|nullable',
            'email_2'                 => 'email|nullable',
            'email_3'                 => 'email|nullable'
        ]);
    
        $file = $request->file('logo_path');

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();
        $data['logo_path'] =($file!=null || $file!='') ? $file->getClientOriginalName() : '';
        $res = $this->apiCall('POST', 'providers', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.company_store')]
            )->validate();
        } else {
		$prov=array();
		$prov=json_decode($res->getBody(), true);
		$destinationPath = "assets/img/users/providers/" . $prov['data']['id'].'/';

	
            if($file!=null || $file!='') {
                $file->move(($destinationPath), $file->getClientOriginalName());

            }
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

        //return $provider;

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
	$provider = Provider::find($request->id);
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'name' => 'required',
            'phone_1'                 => 'nullable',
            'phone_2'                 => 'nullable',
            'phone_3'                 => 'nullable',
            'email_1'                 => 'email|nullable',
            'swiftcode'               => 'min:8|max:11',
            'aba'                     => 'min:9',
            'email_2'                 => 'email|nullable',
            'email_3'                 => 'email|nullable'
        ]);
        $file = $request->file('logo_path');

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();
        $data['logo_path'] =($file!=null || $file!='') ? $file->getClientOriginalName() : $provider->logo_path;
        $res = $this->apiCall('PATCH', 'providers/' . $data['id'], $data);


  	$destinationPath = "assets/img/providers/" . $request->id.'/';

 	if($file!=null || $file!='') {
                $file->move(($destinationPath), $file->getClientOriginalName());

            }


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
            $validator =Validator::make($request->all(), [

                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);

        //    var_dump($array);

            $city =array();
            $currency =array();
            $industry =array();
            $item = array();

            foreach ($array as $value) {
              //  foreach ($val as $value) {
                if (isset($value[16]) && isset($value[17])  && isset($value[2])) {

 //var_dump($value); 


                    $city = $this->getFromApi('GET', 'cities?name=' . $value[2] . '&company_id=' . $company->id);
                    $currency = $this->getFromApi('GET', 'currencies?code=' . $value[16]);
                    $industry = $this->getFromApi('GET', 'industries?name=' . $value[17]);

                   // var_dump($industry);
                  
                    if (!empty($city) && !empty($currency) && !empty($industry)) {

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
                        $item['swiftcode'] = $value[14];
                        $item['aba'] = $value[15];

                   // var_dump($item);
                        $res = $this->apiCall('POST', 'providers', $item);
               // var_dump($res);
                      //  return (json_decode($res->getBody()->__toString(), TRUE));
    if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
             session()->flash('message', 'Error with format file, some rows not import');
            session()->flash('alert-class', 'error');
             return response()->json(array('error' => true, 'message' => 'Error with format file, some rows not import'));
        }
                    }else{
                         session()->flash('message', 'Error with format file, some rows not import');
            session()->flash('alert-class', 'error');
                        return response()->json(array('error' => true, 'message' => 'Error with data in rows'));
                    }
                }
            }
        //}
        } catch (Exception $exception) {
            session()->flash('message', 'Error with format file');
            session()->flash('alert-class', 'error');
          return response()->json(array('error' => true, 'message' => 'Error with format file'));
       }
         session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        //return response()->json();
        return response()->json(array('success' => true));
           
    }


  public function upload(Request $request, $id)
    {
        try {
            var_dump($request);
            $file = $request->file('logo_path');

		$data = $request->all();
            $data['logo_path'] = !isNull($file) ? $file->getClientOriginalName() : '';
            //$res = $this->apiCall('PATCH', 'providers/' . $id, $data);


            $destinationPath = "assets/img/providers/" . $id.'/';
            // echo $file->getClientOriginalName();
 	if($file!=null || $file!='') {
                $file->move(($destinationPath), $file->getClientOriginalName());

            }



        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }



}
