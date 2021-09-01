<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class OfficeController extends Controller
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

        $cities = $this->getFromApi('GET', 'cities');

        return view('office/index', [
            'cities' => $cities,
            'company' => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $office = $this->getFromApi('GET', 'offices/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('office/edit', [
                'office' => $office,
                'company' => $company,
                'cities' => $cities
            ])->render()
        ]);
    }



    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
            'title' => 'required',
            'company_id' => 'required',
            'city_id' => 'required',
            'workinghours_from' => 'required',
            'workinghours_to' => 'required',
            'hours_by_day' => 'required',
		'effective_workinghours' => 'required',
        ]);
if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  }
        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'offices', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.office_store')]
            )->validate();
        } else {
            session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        }

        return response()->json();
    }
    public function import()
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $cities = $this->getFromApi('GET', 'cities');

        return response()->json([
            'view' => view('office/import', [

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

            foreach ($array as $value) {

                if (isset($value[1])) {
                    $item = array();


                    $city = $this->getFromApi('GET', 'cities?name=' . $value[1].'&company_id='.$company->id);


                  //  var_dump($city);
                    if (isset($city[0])) {

                        $item['city_id'] = $city[0]->id;
                        $item['company_id'] = $company->id;
                        $item['title'] = $value[0];
                        $item['workinghours_from'] = $value[2];
                        $item['workinghours_to'] = $value[3];
                        $item['hours_by_day'] = $value[4];
			 $item['effective_workinghours'] = $value[5];


                        $this->apiCall('POST', 'offices', $item);
                    }
                }
            }
        } catch (FileException $exception) {

            return response()->json(array('success' => false, 'message' => 'Error uplading file'));
        }

        return response()->json(array('success' => true));
    }


    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
            'title' => 'required',
            'company_id' => 'required',
            'city_id' => 'required',
            'workinghours_from' => 'required',
            'workinghours_to' => 'required',
            'hours_by_day' => 'required',
	'effective_workinghours' => 'required',

        ]);
if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  }
        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'offices/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.office_store')]
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
        $res = $this->apiCall('DELETE', 'offices/' . $id);

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

        return redirect()->action('OfficeController@index');
    }
}
