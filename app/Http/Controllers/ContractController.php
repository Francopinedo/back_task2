<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class ContractController extends Controller
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

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');
        $currencies = $this->getFromApi('GET', 'currencies');

        return view('contract/index', [
            'customers' => $customers,
            'engagements' => $engagements,
            'currencies' => $currencies,
            'company' => $company
        ]);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $contract = $this->getFromApi('GET', 'contracts/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $contract->customer_id);
        $currencies = $this->getFromApi('GET', 'currencies');
        return response()->json([
            'view' => view('contract/edit', [
                'contract' => $contract,
                'customers' => $customers,
                'engagements' => $engagements,
                'company' => $company,
                'currencies' => $currencies,
                'projects' => $projects
            ])->render()
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [
            'customer_id' => 'required',
            'currency_id' => 'required',
            'sow_number' => 'required',
            'date' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required',
            'engagement_id' => 'required'
        ]);

        $data = $request->all();


        $contracts = $this->apiCall('GET', 'contracts/?project_id=' . $data['project_id']);
        $contracts = json_decode($contracts->getBody()->__toString(), TRUE);
        $contracts= $contracts['data'];

        if (sizeof($contracts) > 0 && $data['amendment_number'] == '') {
            Validator::make($data,
                ['amendment_number' => 'required'])->validate();
            return response()->json();
        }


        if (sizeof($contracts) == 0 && $data['amendment_number'] != '') {
            Validator::make($data,
                ['amendment_number' => 'max:0|nullable'])->validate();

            return response()->json();
        }



        $res = $this->apiCall('POST', 'contracts', $data);
        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            var_dump($jsonRes);
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.contract_store')]
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
        $this->validate($request, [
            'customer_id' => 'required',
            'sow_number' => 'required',
            'currency_id' => 'required',
            'date' => 'required',
            'start_date' => 'required',
            'finish_date' => 'required',
        ]);

        $data = $request->all();


        $contracts = $this->apiCall('GET', 'contracts/?project_id=' . $data['project_id']);
        $contracts = json_decode($contracts->getBody()->__toString(), TRUE);
        $contracts= $contracts['data'];

        if (sizeof($contracts) > 0 && $data['amendment_number'] == '') {

            $validar = true;
            foreach ($contracts as $contract){
                if($contract['project_id']==$data['project_id']){
                    $validar= false;
                }
            }
            if($validar){
                Validator::make($data,
                    ['amendment_number' => 'required'])->validate();
                return response()->json();
            }

        }


        if (sizeof($contracts) == 0 && $data['amendment_number'] != '') {
            Validator::make($data,
                ['amendment_number' => 'max:0|nullable'])->validate();

            return response()->json();
        }


        $res = $this->apiCall('PATCH', 'contracts/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.contract_store')]
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
        $res = $this->apiCall('DELETE', 'contracts/' . $id);

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

        return redirect()->action('ContractController@index');
    }

    // public function select(Request $request)
    // {
    // 	session(['project_id' => $request->id]);
    // 	session(['project_name' => $request->name]);

    // 	return response()->json();
    // }
}
