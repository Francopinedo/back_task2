<?php

namespace App\Http\Controllers;

use App\Language;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado de idiomas
     */
    public function index()
    {
        return view('language/index');
    }

    /**
     * Form para crear idioma
     */
    public function create()
    {
        return view('language/create');
    }

    /**
     * Form para editar idioma
     * @param  int $id ID
     */
    public function edit($id)
    {
        $language = Language::find($id);

        return response()->json([
            'view' => view('language/edit', ['language' => $language])->render(),
        ]);
    }

    /**
     * Crear nuevo idioma
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

        $res = $this->apiCall('POST', 'languages', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.languages_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Actualizo idioma
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

        $res = $this->apiCall('PATCH', 'languages/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.languages_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.updated'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }

    /**
     * Elimina el idioma
     * @param  int $id ID
     */
    public function delete($id)
    {
        $res = $this->apiCall('DELETE', 'languages/' . $id);

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

        return redirect()->action('LanguageController@index');
    }


    public function reload(Request $request)
    {

        $client = new GuzzleHttpClient();

        $res = $client->get('https://restcountries.eu/rest/v2/all');

        $this->apiCall('GET', 'languages/destroy/all');
        $templates = json_decode($res->getBody()->__toString());
        // obtengo los country base
        // creo los nuevos holidays
        foreach ($templates as $template) {
            $languages = $template->languages;

            foreach ($languages as $language) {

                $exist = $this->getFromApi('GET', 'languages?name=' . $language->name);
                if (sizeof($exist)<1) {
                    $lang =
                        array(
                            'name' => $language->name,
                            'code' => strtoupper($language->iso639_1)
                        );
                    $this->apiCall('POST', 'languages', $lang);
                }
            }


        }

        return response()->json();

    }
}
