<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Validator;

class CityTemplateController extends Controller
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
        $res = $this->apiCall('GET', 'countries');

        $countries = json_decode($res->getBody()->__toString())->data;

        return view('city_template/index', [
            'countries' => $countries

        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $city = $this->getFromApi('GET', 'cities_template/' . $id);

        $res = $this->apiCall('GET', 'countries');
        $countries = json_decode($res->getBody()->__toString())->data;

        return response()->json([
            'view' => view('city_template/edit', ['city' => $city, 'countries' => $countries])->render()
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
            'location_name' => 'required',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

        $res = $this->apiCall('POST', 'cities_template', $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.city_store')]
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
            'location_name' => 'required',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } $data = $request->all();

        $res = $this->apiCall('PATCH', 'cities_template/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.city_store')]
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
        $res = $this->apiCall('DELETE', 'cities_template/' . $id);

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

        return redirect()->action('CityTemplateController@index');
    }

    public function reload(Request $request)
    {

        $client = new GuzzleHttpClient();
        $this->apiCall('GET', 'cities_template/destroy/all');

        $res = $client->get('https://restcountries.eu/rest/v2/all');
        $templates = json_decode($res->getBody()->__toString());
        // obtengo los country base
        // creo los nuevos holidays
        foreach ($templates as $template) {

            $exist = $this->getFromApi('GET', 'cities_template?name=' . $template->capital);

            if (sizeof($exist)<1) {
                $country = $this->getFromApi('GET', 'countries?name=' . $template->name);

                if (sizeof($country)>0) {
                    $city =
                        array(
                            'name' => $template->capital,
                            'location_name' => $template->capital,
                            'country_id' => $country[0]->id,
                            'timezone' => isset($template->timezones[0]) ? $template->timezones[0] : NULL
                        );
                     $this->apiCall('POST', 'cities_template', $city);
                }
            }
        }
        return response()->json();
    }
}
