<?php

namespace App\Http\Controllers;

use App\Department;
use DB;
use Illuminate\Http\Request;
use Transformers\DepartmentTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de Department
 *
 * @Resource("Group Department")
 */
class DepartmentController extends Controller
{

    /**
     * Obtener
     *
     * @Get("deparments{?include,company_id}")
     * @Parameters({
     *      @Parameter("company_id", type="integer", required=true, description="ID de una compañia", default=null),
     *      @Parameter("include", type="integer", required=true, description="Tablas relacionadas", default=null)
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string",
     *        "office_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = Department::select('departments.id', 'departments.title', 'departments.office_id')->with('office');

        if ($request->has('company_id')) {
            $query->join('offices', 'offices.id', '=', 'departments.office_id');
            $query->where('offices.company_id', $request->company_id);
        }
        if ($request->has('title')) {
            $query->where('departments.title', $request->title);
        }

        $departments = $query->get();

        return $this->response->collection($departments, new DepartmentTransformer);
    }

    /**
     * Crear department
     *
     * @Post("departments")
     * @Request({
     *      "title": "string",
     *      "office_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('title') || !$request->has('office_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $department = Department::create($data);

        if ($department) {
            return $this->response->item($department, new DepartmentTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener department
     *
     * @Get("departments/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    })
     * })
     */
    public function show($id)
    {
        $department = Department::findOrFail($id);

        return $this->response->item($department, new DepartmentTransformer);
    }

    /**
     * Editar template de office
     *
     * @Patch("departments/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *      "title": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);

        if ($department == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $department->update($data);

        if ($department) {
            return $this->response->item($department, new DepartmentTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina un template de office
     *
     * @Delete("departments/{id}")
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
        $department = Department::find($id);

        if ($department == NULL) {
            return $this->response->error('No existe', 450);
        }

        $department->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener offices
     *
     * Con formato listo para datatables con ajax
     * @Get("offices/datatables")
     */
    public function datatables(Request $request)
    {
        $query = Department::select(
            'departments.id',
            'departments.title',
            'departments.office_id',
            'offices.title AS office_title'
        );
        $query->leftJoin('offices', 'offices.id', '=', 'departments.office_id');

        if ($request->has('company_id')) {
            $query->where('offices.company_id', $request->company_id);
        }

        $offices = $query->get();

        return Datatables::of($offices)->make(true);
    }

}

?>