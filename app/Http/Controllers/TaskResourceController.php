<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;

class TaskResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Form para crear
     * @param  int $id ID
     */
    public function create($task_id)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users/?company_id=' . $company->id);
        $roles = $this->getFromApi('GET', 'project_roles?company_id=' . $company->id);
        $task = $this->getFromApi('GET', 'tasks/' . $task_id);

        // $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id=' . $company->id);
        // $rates = $this->getFromApi('GET', 'rates?company_id='.$company->id);

        $currencies = $this->getFromApi('GET', 'currencies');
        // $contract = $this->getFromApi('GET', 'contracts/'.$contract_id);

        return response()->json([
            'view' => view('task_resource/create', [
                'users' => $users,
                'task' => $task,
                'roles' => $roles,
                'currencies' => $currencies,
                // 'contract'     => $contract,
                // 'projectRoles' => $projectRoles,
                'seniorities' => $seniorities,
                // 'rates'        => $rates,
                'company' => $company
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
            'task_id' => 'required',
            'project_role_id' => 'required',
            'seniority_id' => 'required',
            'rate' => 'required',
            'currency_id' => 'required',
            // 'workplace'       => 'required',
            'quantity' => 'required|numeric|max:' . $request->task_estimated_hours,
            // 'load'            => 'required'
        ]);

        $data = $request->all();

        $current_resources = $this->getFromApi('GET', 'task_resources?task_id=' . $data['task_id']);

        $hours = $request->quantity;
        //var_dump($current_resources);
        foreach ($current_resources as $resouce) {

            $hours = $hours + $resouce->quantity;
        }

        //echo $request->task_estimated_hours;

        if ($hours > $request->task_estimated_hours) {
            //echo $hours;

            return response()->json(array('quantity' => array('The sum of hours may not be greater than ' . $request->task_estimated_hours)), 422);
        } else {
            $res = $this->apiCall('POST', 'task_resources', $data);

            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.item_store')]
                )->validate();
            } else {
                session()->flash('message', __('general.added'));
                session()->flash('alert-class', 'success');
            }
        }

        return response()->json();
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);

        // $projectRoles = $this->getFromApi('GET', 'project_roles?company_id='.$company->id);
        $seniorities = $this->getFromApi('GET', 'seniorities?company_id=' . $company->id);
        // $rates = $this->getFromApi('GET', 'rates?company_id='.$company->id);
        $roles = $this->getFromApi('GET', 'project_roles?company_id=' . $company->id);
        $taskResource = $this->getFromApi('GET', 'task_resources/' . $id);
        $currencies = $this->getFromApi('GET', 'currencies');
        // var_dump($taskResource);
        $task = $this->getFromApi('GET', 'tasks/' . $taskResource->task_id);
        return response()->json([
            'view' => view('task_resource/edit', [
                'taskResource' => $taskResource,
                'users' => $users,
                'roles' => $roles,
                'users' => $users,
                'task' => $task,
                'currencies' => $currencies,
                // 'projectRoles'     => $projectRoles,
                'seniorities' => $seniorities,
                // 'rates'            => $rates,
                'company' => $company,
            ])->render()
        ]);
    }

    /**
     * Actualizo
     */
    public function update(Request $request)
    {
        // validacion del formulario
        $this->validate($request, [

            'project_role_id' => 'required',
            'seniority_id' => 'required',
            'rate' => 'required',
            'currency_id' => 'required',
            // 'workplace'       => 'required',
            'quantity' => 'required|numeric|max:' . $request->task_estimated_hours,
            // 'load'            => 'required'
        ]);

        $data = $request->all();


        $current_resources = $this->getFromApi('GET', 'task_resources?task_id=' . $data['task_id']);

        $hours = $request->quantity;
        //var_dump($current_resources);
        foreach ($current_resources as $resouce) {


            if ($resouce->id != $request->id) {
                $hours = $hours + $resouce->quantity;
            }
        }

        //echo $request->task_estimated_hours;

        if ($hours > $request->task_estimated_hours) {
            //echo $hours;

            return response()->json(array('quantity' => array('The sum of hours may not be greater than ' . $request->task_estimated_hours)), 422);
        } else {


            $res = $this->apiCall('PATCH', 'task_resources/' . $data['id'], $data);

            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.item_store')]
                )->validate();
            } else {
                session()->flash('message', __('general.updated'));
                session()->flash('alert-class', 'success');
            }
        }
        return response()->json();
    }

    /**
     * Elimina
     * @param  int $id ID
     */
    public function delete($id)
    {
        $taskResource = $this->getFromApi('GET', 'task_resources/' . $id);
        $res = $this->apiCall('DELETE', 'task_resources/' . $id);

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

        if (!isset($jsonRes)) {
            return redirect('tasks/' . $taskResource->task_id . '/rows');
        } else {
            return redirect()->action('TaskController@index');
        }
    }
}
