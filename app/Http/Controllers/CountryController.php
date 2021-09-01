<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;

class CountryController extends Controller
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
        $languages = $this->getFromApi('GET', 'languages');


        $currencies = $this->getFromApi('GET', 'currencies');

        return view('country/index', [
        	'languages' => $languages,
        	'currencies' => $currencies,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id){
    	$country = $this->getFromApi('GET', 'countries/'.$id);

    	$res = $this->apiCall('GET', 'languages');
    	$languages = json_decode($res->getBody()->__toString())->data;

    	$res = $this->apiCall('GET', 'currencies');
    	$currencies = json_decode($res->getBody()->__toString())->data;

    	return response()->json([
    		'view' => view('country/edit', ['country' => $country, 'languages' => $languages, 'currencies' => $currencies] )->render()
    	]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
    	// validacion del formulario
    	$validator =Validator::make($request->all(), [

			'name'     => 'required',
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('POST', 'countries', $data);


    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.country_store')]
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

			'name'     => 'required',
	    ]);

    	if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

    	$res = $this->apiCall('PATCH', 'countries/'.$data['id'], $data);

    	// validacion de la respuesta del api
    	if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
    	{
	    	$jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
	    	Validator::make($jsonRes,
	    		['status_code' => [Rule::in(['201', '200'])]],
	    		['in' => __('api_errors.country_store')]
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
    	$res = $this->apiCall('DELETE', 'countries/'.$id);

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

    	return redirect()->action('CountryController@index');
    }



    public function reload(Request $request){

        $client = new GuzzleHttpClient();

        $res = $client->get('https://restcountries.eu/rest/v2/all');

        $this->apiCall('GET', 'countries/destroy/all');
        $templates=  json_decode($res->getBody()->__toString());
        // obtengo los country base
        // creo los nuevos holidays
        foreach ($templates as $template)
        {
            $language = $this->getFromApi('GET', 'languages?name=' . $template->languages[0]->name);
            $currency = $this->getFromApi('GET', 'currencies?name=' . $template->currencies[0]->name);

            $exist = $this->getFromApi('GET','countries?name='.$template->name);
            if (sizeof($exist)<1) {

                $country =
                    array(
                        'name'        => $template->name,
                        'code'        => $template->alpha2Code,
                        'language_id' => sizeof($language)>0?$language[0]->id:NULL,
                        'currency_id' => sizeof($currency)>0?$currency[0]->id:NULL,
                    );
                $this->apiCall('POST', 'countries', $country);
            }else{


                 $country =
                     array(
                         //'name'        => $template->name,
                         'code'        => $template->alpha2Code,
                         'language_id' => sizeof($language)>0?$language[0]->id:NULL,
                         'currency_id' => sizeof($currency)>0?$currency[0]->id:NULL,
                     );


                 $this->apiCall('PATCH', 'countries/'.$exist[0]->id, $country);
            }

        }

        return response()->json();

    }
}
