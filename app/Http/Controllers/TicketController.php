<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','systemaudit']);
    }

    /**
     * Muestra listado
     */
    public function index($task_id)
    {
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'task_resources?task_id=' . $task_id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id=' . $company->id);
        $task = $this->getFromApi('GET', 'tasks/' . $task_id);
        $users2 = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        return view('ticket/index', [
            'users' => $users,
            'users2' => $users2,
            'contacts' => $contacts,
            'task' => $task,
        ]);
    }

   
    public function indexsprints($sprints_id)
    {


        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users= $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id=' . $company->id);
        $sprint = $this->getFromApi('GET', 'sprints/' . $sprints_id);
        $users2 = $this->getFromApi('GET', 'users?company_id=' . $company->id);

 return view('ticket/index_sprint', [
            'users' => $users,
            'users2' => $users2,
            'contacts' => $contacts,
            'sprint' => $sprint,
        ]);
    }

    /**
     * Crear nuevo
     */
    public function store(Request $request)
    {
         $b_hours = $request->estimated_hours;
        // validacion del formulario
        $validator =Validator::make($request->all(), [

            'description' => 'required',
            'owner_id' => 'required',
            'estimated_hours' => 'required|numeric|min:0',
           // 'burned_hours' => 'numeric|min:0|max:' . $b_hours,
            'task_id' => 'required'
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $task = $this->getFromApi('GET', 'tasks/' . $data['task_id']);
        $current_resources = $this->getFromApi('GET', 'tickets?task_id=' . $data['task_id']);
        $hours = $request->estimated_hours;

           if ($request->burned_hours<0 || $request->burned_hours > $request->estimated_hours) {
            //echo $hours;

            return response()->json(array('estimated_hours' => array('The burned hours may not be greater than ' . $request->estimated_hours)), 422);
        } else {
            $res = $this->apiCall('POST', 'tickets', $data);

            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {
                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.ticket_store')]
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
        $ticket = $this->getFromApi('GET', 'tickets/' . $id);

        $project = $this->getFromApi('GET', 'projects/' . session('project_id'));
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'task_resources?task_id=' . $ticket->task_id);
        $users2 = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id=' . $company->id);
        return response()->json([
            'view' => view('ticket/edit', [
                'ticket' => $ticket,
                'contacts' => $contacts,
                'project' => $project,
                'users' => $users,
                'users2' => $users2
            ])->render()
        ]);
    }

    public function files($id)
    {
        $ticket = $this->getFromApi('GET', 'tickets/' . $id);

        $project = $this->getFromApi('GET', 'projects/' . session('project_id'));
        $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
        $users = $this->getFromApi('GET', 'users?company_id=' . $company->id);
        $contacts = $this->getFromApi('GET', 'contacts?company_id=' . $company->id);

        $documentos = Storage::disk('repository')->files('tickets/' . $project->customer_id . "/" . $project->id . "/" . $ticket->id);

        return response()->json([
            'view' => view('ticket/files', [
                'ticket' => $ticket,
                'documentos' => $documentos,
                'project' => $project,
                'contacts' => $contacts,
                'users' => $users,

            ])->render()
        ]);
    }

    public
    function download(Request $request)
    {


        $destinationPath = "app/public/repository/" . $request->file;
        // echo $destinationPath;
        if ($exists = Storage::disk('repository')->exists($request->file)) {

            return response()->download(storage_path($destinationPath));
        } else {
            //  echo 'archivo no existe';
        }

    }

    public function uploadFile(Request $request)
    {
        try {
            $files = $request->file('document');
            $customer = $request->customer;
            $project = $request->project;


            $validator =Validator::make($request->all(), [

                'document' => 'required'
            ]);
            
            $destinationPath = "app/public/repository/tickets/" . $customer . "/" . $project . "/" . $request->id;

            foreach ($files as $file) {
                // echo $file->getClientOriginalName();
                $file->move(storage_path($destinationPath), $file->getClientOriginalName());
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
        $b_hours = ($request->estimated_hours);
        // validacion del formulario
       // var_dump($b_hours);
        $validator =Validator::make($request->all(), [

            'description' => 'required',
            'estimated_hours' => 'required|numeric|min:0',
          //  'burned_hours' => 'numeric|min:0|max:' . $b_hours,
        ]);

        if ($validator->fails()) {
    return response()->json($validator->errors(), 422);
  } $data = $request->all();

        $task = $this->getFromApi('GET', 'tasks/' . $data['task_id']);
        $current_resources = $this->getFromApi('GET', 'tickets?task_id=' . $data['task_id']);
        $hours = $request->estimated_hours;



        if ($request->burned_hours<0 || $request->burned_hours > $request->estimated_hours) {
            //echo $hours;

return response()->json(array('estimated_hours' => array('The burned hours may not be greater than ' . $request->estimated_hours)), 422);
        } else {
            $res = $this->apiCall('PATCH', 'tickets/' . $data['id'], $data);
            // validacion de la respuesta del api
            if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error'])) {


                $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
                  var_dump($jsonRes);
                Validator::make($jsonRes,
                    ['status_code' => [Rule::in(['201', '200'])]],
                    ['in' => __('api_errors.ticket_store')]
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
        $ticket = $this->getFromApi('GET', 'tickets/' . $id);
        $res = $this->apiCall('DELETE', 'tickets/' . $id);

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
            return redirect('tasks/' . $ticket->task_id . '/tickets');
        } else {
            return redirect()->action('TaskController@index');
        }
    }

    /**
     * Muestra detalle del registro
     * @param  int $id ID
     */
    public function show($id)
    {
        $res = $this->apiCall('GET', 'tickets/' . $id);
        $company = json_decode($res->getBody()->__toString())->data;

        return response()->json([
            'view' => view('ticket/show', ['company' => $company])->render(),
        ]);
    }
}
