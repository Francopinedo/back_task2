<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class AbsenceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit', 'loglevel', 'deletecontrol']);
    }

    /**
     * Muestra listado
     */
    public function index()
    {
        $countries = $this->getFromApi('GET', 'countries');

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);

        return view('absence/index', [
            'countries' => $countries,
            'users' => $users,
            'cities' => [],
            'company' => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $absence = $this->getFromApi('GET', 'absences/' . $id);
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $countries = $this->getFromApi('GET', 'countries');

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);

        $absenceType = $this->getFromApi('GET', 'absence_types/' . $absence->absence_type_id);
        $absenceTypes = $this->getFromApi('GET', 'absence_types?city_id=' . $absenceType->city_id . '&company_id=' . $company->id);

        $cities = $this->getFromApi('GET', 'cities?company_id=' . $company->id . '&country_id=' . $absenceType->country_id);
        return response()->json([
            'view' => view('absence/edit', [
                'absence' => $absence,
                'countries' => $countries,
                'cities' => $cities,
                'users' => $users,
                'company' => $company,
                'absence_type' => $absenceType,
                'absenceTypes' => $absenceTypes,
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
            'from' => 'required',
            'to' => 'required',
            'absence_type_id' => 'required',
            'user_id' => 'required',
            'project_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'absences', $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.absence_store')]
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
            'from' => 'required',
            'to' => 'required',
            'absence_type_id' => 'required',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'absences/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.absence_store')]
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
        $res = $this->apiCall('DELETE', 'absences/' . $id);

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

        return redirect()->action('AbsenceController@index');
    }
}
