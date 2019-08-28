<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Validator;

class ProjectController extends Controller
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
        $data['company'] = $company;

        $data['customers'] = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        // $data['contracts'] = $this->getFromApi('GET', 'contracts?company_id='.$company->id);
        $data['departments'] = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        $data['users'] = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $data['project_managers'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
        $data['technical_directors'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Technical Director');
        $data['delivery_managers'] = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Delivery Manager');
        $data['engagements'] = $this->getFromApi('GET', 'engagements');
        return view('project/index', $data);
    }

    /**
     * Form para editar
     * @param  int $id ID
     */
    public function edit($id)
    {
        $project = $this->getFromApi('GET', 'projects/' . $id);

        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());

        $customers = $this->getFromApi('GET', 'customers?company_id=' . $company->id);
        // $contracts = $this->getFromApi('GET', 'contracts?company_id='.$company->id);
        $departments = $this->getFromApi('GET', 'departments?company_id=' . $company->id . '&include=office');
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $engagements = $this->getFromApi('GET', 'engagements');

        $project_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Project Manager');
        $technical_directors = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Technical Director');
        $delivery_managers = $this->getFromApi('GET', 'users?company_id=' . $company->id . '&role_name=Delivery Manager');

        return response()->json([
            'view' => view('project/edit', [
                'project' => $project,
                'technical_directors' => $technical_directors,
                'delivery_managers' => $delivery_managers,
                'project_managers' => $project_managers,
                'project' => $project,
                'engagements' => $engagements,
                'customers' => $customers,
                // 'contracts' => $contracts,
                'departments' => $departments,
                'users' => $users,
                'company' => $company,
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
            'name' => 'required',
            'hours_by_day' => 'required',
            // 'sow_number'                    => 'required',
            // 'identificator'                 => 'required',
            // 'engagement'                    => 'required',
            // 'estimated_revenue'             => 'required|numeric|min:0',
            // 'estimated_cost'                => 'required|numeric|min:0',
            // 'estimated_margin'              => 'required|numeric',
            // 'target_margin'                 => 'required|numeric',
            'customer_id' => 'required',
            'start' => 'required',
            'finish' => 'required',
            // 'status'                        => 'required',
            // 'financial_deviation_threshold' => 'required|numeric',
            // 'time_deviation_threshold'      => 'required|numeric',
            // 'department_id'                 => 'required',
            'project_manager_id' => 'required',
            'technical_director_id' => 'required',
            'delivery_manager_id' => 'required',
        ]);

        $data = $request->all();

        $res = $this->apiCall('POST', 'projects', $data);


        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
            //var_dump($jsonRes);
            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_store')]
            )->validate();
        } else {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);


            $this->rawDirectory( $request, $jsonRes['data']['id']);

            //var_dump($final_directories);


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
            'name' => 'required',
            'hours_by_day' => 'required',
            // 'sow_number'                    => 'required',
            // 'identificator'                 => 'required',
            // 'engagement'                    => 'required',
            // 'estimated_revenue'             => 'required|numeric|min:0',
            // 'estimated_cost'                => 'required|numeric|min:0',
            // 'estimated_margin'              => 'required|numeric',
            // 'target_margin'                 => 'required|numeric',
            'customer_id' => 'required',
            // 'status'                        => 'required',
            // 'financial_deviation_threshold' => 'required|numeric',
            // 'time_deviation_threshold'      => 'required|numeric',
            // 'department_id'                 => 'required',
            'project_manager_id' => 'required',
            'technical_director_id' => 'required',
            'delivery_manager_id' => 'required',
        ]);

        $data = $request->all();

        $res = $this->apiCall('PATCH', 'projects/' . $data['id'], $data);

        // validacion de la respuesta del api
        if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];

            Validator::make($jsonRes,
                ['status_code' => [Rule::in(['201', '200'])]],
                ['in' => __('api_errors.project_store')]
            )->validate();
        } else {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE);

            $this->rawDirectory( $request, $data['id']);


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
        $project = $this->getFromApi('GET', 'projects/' . $id);
        $res = $this->apiCall('DELETE', 'projects/' . $id);

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

            $path = storage_path() . '/app/public/repository/' . $project->customer_id . '/' . $id;
            File::deleteDirectory($path);

            session()->flash('message', __('general.deleted'));
            session()->flash('alert-class', 'success');
        }

        return redirect()->action('ProjectController@index');
    }

    public function forProjectSelection($customer_id)
    {
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $customer_id . '&user_id=' . Auth::id());

        return response()->json([
            'view' => view('project/forProjectSelection', ['projects' => $projects])->render()
        ]);
    }

    public function select(Request $request)
    {
        session(['project_id' => $request->id]);
        session(['project_name' => $request->name]);

        return response()->json();
    }

    public function forContracts($customer_id)
    {
        $projects = $this->getFromApi('GET', 'projects?customer_id=' . $customer_id);
        return response()->json($projects);
        /*return response()->json([
            'view' => view('project/forContracts', ['projects' => $projects] )->render()
        ]);*/
    }


    private function rawDirectory($request, $projectid)
    {

        $path = storage_path() . '/app/public/repository/' . $request->customer_id . '/' . $projectid;
        File::makeDirectory($path, $mode = 0777, true, true);


        $directories = $this->getFromApi('GET', 'directories');

        foreach ($directories as $directory) {

            $path = storage_path() . '/app/public/repository/' . $request->customer_id . '/' . $projectid . '/' . $directory->path;
            File::makeDirectory($path, $mode = 0777, true, true);


            $folders = $this->getFromApi('GET', 'directories?parent=' . $directory->id);

            foreach ($folders as $folder) {

                $path = storage_path() . '/app/public/repository/' . $request->customer_id . '/' .$projectid . '/'
                    . $directory->path . '/' . $folder->path;

                File::makeDirectory($path, $mode = 0777, true, true);

                $subfolders = $this->getFromApi('GET', 'directories?parent=' . $folder->id);

                foreach ($subfolders as $subfolder) {
                    $path = storage_path() . '/app/public/repository/' . $request->customer_id . '/' . $projectid . '/'
                        . $directory->path . '/' . $folder->path . '/' . $subfolder->path;
                    File::makeDirectory($path, $mode = 0777, true, true);
                }

            }

        }

    }
}
