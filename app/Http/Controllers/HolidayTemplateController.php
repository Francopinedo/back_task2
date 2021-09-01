<?php

namespace App\Http\Controllers;

use App\HolidayTemplate;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class HolidayTemplateController extends Controller
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
        $countries = $this->getFromApi('GET', 'countries');

        return view('holiday_template/index', [
            'countries' => $countries,
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $holiday = $this->getFromApi('GET', 'holidays_templates/' . $id);

        $countries = $this->getFromApi('GET', 'countries');

        return response()->json([
            'view' => view('holiday_template/edit', ['holiday' => $holiday, 'countries' => $countries])->render()
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'date' => 'required',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'holidays_templates', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.holiday_store')]
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

            'date' => 'required',
            'country_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'holidays_templates/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.holiday_store')]
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
        $res = $this->apiCall('DELETE', 'holidays_templates/' . $id);

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

        return redirect()->action('HolidayTemplateController@index');
    }


    public function reload(Request $request)
    {

        $client = new GuzzleHttpClient();
        $this->apiCall('GET', 'holidays_templates/destroy/all');


        $countries = $this->getFromApi('GET', 'countries');


        foreach ($countries as $count) {

            if (!empty($count->code)) {

                $res = $client->get('https://holidayapi.com/v1/holidays?key=29e184bd-8641-4496-b97f-5e791b37d9eb&country='
                    . $count->code . '&year=' . date('Y'));

                $templates = json_decode($res->getBody()->__toString());

                foreach ($templates as $template) {

                    $exist = $this->getFromApi('GET', 'holidays_templates?name=' . $template->description . '&country_id=' . $template->country_id);

                    if (sizeof($exist) < 1) {

                        $city =
                            array(
                                'description' => $template->description,
                                'date' => $template->date,
                                'country_id' => $count->id
                            );
                        $this->apiCall('POST', 'holidays_templates', $city);

                    }
                }
            }


        }


        return response()->json();
    }

}
