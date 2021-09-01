<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class WhatIfController extends Controller
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

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);

        return view('whatif/index', [
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
        $WhatIf = $this->getFromApi('GET', 'whatif/' . $id);
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $countries = $this->getFromApi('GET', 'countries');

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);

     return response()->json([
            'view' => view('whatif/edit', [
                'whatif' => $WhatIf,
                'users' => $users,
                'company' => $company,
                'project_id'=>session('project_id')
            ])->render()
        ]);
    }

    public function create(Request $request)
    {
  
     return response()->json([
            'view' => view('whatif/create',['project_id'=>session('project_id')])->render()
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
            'comment' => 'required',
            'user_id' => 'required',
            'project_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('POST', 'whatif', $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
          //  var_dump($jsonRes);
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.whatif_store')]
            )->validate();
        } else {

           // session()->flash('message', __('general.added'));
           // session()->flash('alert-class', 'success');
        }
           $r=json_decode($res->getBody()->__toString(), TRUE);

       // return response()->json(['id'=>$r['data']['id']]);
    return response()->json();
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
    	$validator =Validator::make($request->all(), [
            'comment' => 'required',
            'user_id' => 'required',
            'project_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $res = $this->apiCall('PATCH', 'whatif/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.whatif_store')]
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
        $res = $this->apiCall('DELETE', 'whatif/' . $id);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            session()->flash('message', __('api_errors.delete'));
            session()->flash('alert-class', 'danger');
//var_dump(json_decode($res->getBody()->__toString(), TRUE)['error']);
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.delete')]
            )->validate();

        } else {
            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('WhatIfController@index');
    }
}
