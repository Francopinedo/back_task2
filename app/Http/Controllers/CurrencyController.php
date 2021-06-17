<?php

namespace App\Http\Controllers;

use App\Currency;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class CurrencyController extends Controller
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
        return view('currency/index');
    }

    /**
     * Form para crear
     */
    public function create()
    {
        return view('currency/create');
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $currency = Currency::find($id);

        return response()->json([
            'view' => view('currency/edit', ['currency' => $currency])->render(),
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
            'code' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'currencies', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.currency_store')]
            )->validate();
        } else {
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

            'name' => 'required',
            'code' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'currencies/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.currency_store')]
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
        $res = $this->apiCall('DELETE', 'currencies/' . $id);

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

        return redirect()->action('CurrencyController@index');
    }


    public function reload(Request $request)
    {

        $client = new GuzzleHttpClient();

        $res = $client->get('https://restcountries.eu/rest/v2/all');

        $this->apiCall('GET', 'currencies/destroy/all');
        $templates = json_decode($res->getBody()->__toString());
        // obtengo los country base
        // creo los nuevos holidays
        foreach ($templates as $template) {


            $currencies = $template->currencies;

            foreach ($currencies as $curr) {
                $exist = $this->getFromApi('GET', 'currencies?code=' . $curr->code);
                if (sizeof($exist) < 1) {
                    $name = $curr->name;
                    $currency =
                        array(
                            'name' => $name,
                            'code' => $curr->code
                        );

                    $this->apiCall('POST', 'currencies', $currency);
                }
            }


        }

        return response()->json();

    }
}
