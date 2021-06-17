<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Models\Absence;
use App\Models\Project;
use App\Models\Replacement;
use DB;
use Illuminate\Http\Request;
use Transformers\ReplacementTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Replacement
 *
 * @Resource("Group Replacement")
 */
class ReplacementController extends Controller
{

    /**
     * Obtener
     *
     * @Get("replacements{?project_id}")
     * @Parameters({
     *      @Parameter("project_id", description="ID del proyecto", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = Replacement::join('absences', 'absences.id', '=', 'replacements.absence_id');

        if ($request->has('project_id')) {
            $query->where('absences.project_id', $request->project_id);
        }

        $replacements = $query->get();

        return $this->response->collection($replacements, new ReplacementTransformer);
    }

    /**
     * Crear
     *
     * @Post("replacements")
     * @Request({
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('absence_id') || !$request->has('user_id') || !$request->has('from')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $absence = Absence::find($data['absence_id']);
        $project = Project::find($data['project_id']);


        $customer = Customer::find($project->customer_id);

        $requestSend = array('project' => $data['project_id'], 'customer' => $project->customer_id, 'period_to' => $data['to'], 'period_from' =>
            $data['from'], 'user_id' => $data['user_id'], 'company' => $customer->company_id);
        $requestSend = new \Illuminate\Http\Request($requestSend);

        $workingHoursFromApiReplacement = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

        $workingHoursFromApiReplacement = $workingHoursFromApiReplacement->getData();
        $workingHoursFromApiReplacement = $workingHoursFromApiReplacement->data;

        $requestSend = array('project' => $request->project_id, 'customer' => $project->customer_id, 'period_to' => $request->to, 'period_from' =>
            $request->from, 'user_id' => $absence->user_id, 'company' => $customer->company_id);
        $requestSend = new \Illuminate\Http\Request($requestSend);

        $workingHoursFromApiAbsent = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

        $workingHoursFromApiAbsent = $workingHoursFromApiAbsent->getData();
        $workingHoursFromApiAbsent = $workingHoursFromApiAbsent->data;

        $hoursabsence = $workingHoursFromApiAbsent->hours_asigned;
        $hoursavailablereempla = $workingHoursFromApiReplacement->efective_capacity;
        //return $this->response->error('El reemplazo excede las horas disponible '.$workingHoursFromApiReplacement->hours_available, 451);
        if ($hoursavailablereempla >= $hoursabsence && $hoursavailablereempla > 0) {
            $replacement = Replacement::create($data);

            if ($replacement) {
                return $this->response->item($replacement, new ReplacementTransformer);
            } else {
                return $this->response->error('Error al crear', 451);
            }
        } else {
            return $this->response->error('El reemplazo excede las horas disponible ', 451);

        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("replacements/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     *    })
     * })
     */
    public function show($id)
    {
        $replacement = Replacement::findOrFail($id);

        return $this->response->item($replacement, new ReplacementTransformer);
    }

    /**
     * Editar
     *
     * @Patch("replacements/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "absence_id": "int",
     *        "user_id": "int",
     *        "from": "date",
     *        "to": "date",
     *        "ticket": "string"
     *        "comment": "string",
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $replacement = Replacement::find($id);

        if ($replacement == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $absence = Absence::find($data['absence_id']);
        $project = Project::find($data['project_id']);


        $customer = Customer::find($project->customer_id);

        $requestSend = array('project' => $data['project_id'], 'customer' => $project->customer_id, 'period_to' => $data['to'], 'period_from' =>
            $data['from'], 'user_id' => $data['user_id'], 'company' => $customer->company_id);
        $requestSend = new \Illuminate\Http\Request($requestSend);

        $workingHoursFromApiReplacement = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

        $workingHoursFromApiReplacement = $workingHoursFromApiReplacement->getData();
        $workingHoursFromApiReplacement = $workingHoursFromApiReplacement->data;

        $requestSend = array('project' => $request->project_id, 'customer' => $project->customer_id, 'period_to' => $request->to, 'period_from' =>
            $request->from, 'user_id' => $absence->user_id, 'company' => $customer->company_id);
        $requestSend = new \Illuminate\Http\Request($requestSend);

        $workingHoursFromApiAbsent = app('App\Http\Controllers\WorkingHourController')->calculated($requestSend);

        $workingHoursFromApiAbsent = $workingHoursFromApiAbsent->getData();
        $workingHoursFromApiAbsent = $workingHoursFromApiAbsent->data;

        $hoursabsence = $workingHoursFromApiAbsent->hours_asigned;
        $hoursavailablereempla = $workingHoursFromApiReplacement->efective_capacity;


        if ($hoursavailablereempla >= $hoursabsence && $hoursavailablereempla > 0) {
            $replacement->update($data);

            if ($replacement) {
                return $this->response->item($replacement, new ReplacementTransformer);
            } else {
                return $this->response->error('Error al editar', 451);
            }
        } else {
            return $this->response->error('El reemplazo excede las horas disponible ', 451);

        }
    }

    /**
     * Elimina
     *
     * @Delete("replacements/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
    public function destroy($id)
    {
        $replacement = Replacement::find($id);

        if ($replacement == NULL) {
            return $this->response->error('No existe', 450);
        }

        $replacement->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("replacements/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('replacements')
            ->select(
                'replacements.id',
                'replacements.absence_id',
                'users.name AS user_name',
                'replacement_user.name AS replacement_user_name',
                'replacements.from',
                'replacements.to',
                'replacements.ticket',
                'replacements.comment',
                DB::raw('CONCAT(absence_types.title, ", ", absences.from) AS absence_data'))
            // ->selectRaw('CONCAT(absence_types.title, ' ', absences.from) as absence_data')
            ->join('absences', 'absences.id', '=', 'replacements.absence_id')
            ->join('absence_types', 'absences.absence_type_id', '=', 'absence_types.id')
            ->join('users', 'users.id', '=', 'absences.user_id')
            ->join('users as replacement_user', 'replacement_user.id', '=', 'replacements.user_id');

        if ($request->has('project_id')) {
            $query->where('absences.project_id', $request->project_id);
        }

        $replacements = $query->get();

        return Datatables::of($replacements)->make(true);
    }

}

?>