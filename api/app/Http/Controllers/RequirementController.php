<?php

namespace App\Http\Controllers;

use App\Models\Requirement;
use DB;
use Illuminate\Http\Request;
use Transformers\RequirementTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Requirement
 *
 * @Resource("Group Requirement")
 */
class RequirementController extends Controller
{

    /**
     * Obtener
     *
     * @Get("requirements{?include}")
     * @Parameters({
     *      @Parameter("include", description="Tablas relacionadas", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = Requirement::select('requirements.*');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        $requirements = $query->get();

        return $this->response->collection($requirements, new RequirementTransformer);
    }

    /**
     * Crear compania
     *
     * @Post("requirements")
     * @Request({
     *        "description": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('description')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $requirement = Requirement::create($data);

        if ($requirement) {
            return $this->response->item($requirement, new RequirementTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener compania
     *
     * @Get("requirements/{id}{?include}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     *      @Parameter("include", type="string", required=false, description="datos relacionados", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $requirement = Requirement::findOrFail($id);

        return $this->response->item($requirement, new RequirementTransformer);
    }

    /**
     * Editar compania
     *
     * @Patch("requirements/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "description": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $requirement = Requirement::find($id);

        if ($requirement == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $requirement->update($data);

        if ($requirement) {
            return $this->response->item($requirement, new RequirementTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina una compania
     *
     * @Delete("requirements/{id}")
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
        $requirement = Requirement::find($id);

        if ($requirement == NULL) {
            return $this->response->error('No existe', 450);
        }

        $requirement->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener companias
     *
     * Con formato listo para datatables con ajax
     * @Get("requirements/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('requirements')
            ->select(
                'requirements.id',
                'requirements.project_id',
                'requirements.description',
                'requirements.type',
                'requirements.request_date',
                'requirements.status_comment',
                'requirements.due_date',
                'requirements.owner_id',
                'requirements.priority',
                'requirements.business_value',
                'requirements.requester_name',
                'requirements.requester_email',
                'requirements.requester_type',
                'requirements.approval_date',
                'requirements.approver_name',
                'requirements.comment',
                'users.name AS owner_name'
            );

        $query->leftJoin('users', 'users.id', '=', 'requirements.owner_id');

        if ($request->has('project_id')) {
            $query->where('requirements.project_id', $request->project_id);
        }

        if ($request->has('view_type_project') && $request->view_type_project==0) {
            $query->where('requirements.type', '=','product');

        }

        $requirements = $query->get();

        return Datatables::of($requirements)->make(true);
    }

}

?>