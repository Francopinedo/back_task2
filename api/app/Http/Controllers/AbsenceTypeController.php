<?php

namespace App\Http\Controllers;

use App\Models\AbsenceType;
use App\Models\AbsenceTypeTemplate;
use DB;
use Illuminate\Http\Request;
use Transformers\AbsenceTypeTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de tipos de ausencias
 *
 * @Resource("Group AbsenceType")
 */
class AbsenceTypeController extends Controller
{

    /**
     * Obtener tipo de ausencias
     *
     * @Get("absence_types")
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "country_id": "int",
     *        "title": "string",
     *        "days": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = AbsenceType::select('*');

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        $absence_types = $query->get();
        return $this->response->collection($absence_types, new AbsenceTypeTransformer);
    }

    /**
     * Crear Tipo de ausencia
     *
     * @Post("absence_types")
     * @Request({
     *      "country_id": "int",
     *      "title": "string",
     *      "days": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *            "country_id": "int",
     *            "title": "string",
     *            "days": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('country_id') || !$request->has('title') || !$request->has('days')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $absenceType = AbsenceType::create($data);

        if ($absenceType) {
            return $this->response->item($absenceType, new AbsenceTypeTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener tipo de ausencia
     *
     * @Get("absence_types/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *            "country_id": "int",
     *            "title": "string",
     *            "days": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $absenceType = AbsenceType::findOrFail($id);

        return $this->response->item($absenceType, new AbsenceTypeTransformer);
    }

    /**
     * Editar tipo de ausencia
     *
     * @Patch("absence_types/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *      "name": "string",
     *      "country_id": "int",
     *      "title": "string",
     *      "days": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *            "country_id": "int",
     *            "title": "string",
     *            "days": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $absenceType = AbsenceType::find($id);

        if ($absenceType == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $absenceType->update($data);

        if ($absenceType) {
            return $this->response->item($absenceType, new AbsenceTypeTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina una tipo de ausencia
     *
     * @Delete("absence_types/{id}")
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
        $absenceType = AbsenceType::find($id);

        if ($absenceType == NULL) {
            return $this->response->error('No existe', 450);
        }

        $absenceType->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener tipo de ausencias
     *
     * Con formato listo para datatables con ajax
     * @Get("absence_types/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('absence_types')
            ->select(
                'absence_types.id', 'absence_types.country_id', 'absence_types.title', 'absence_types.days',
                'countries.name AS country_name', 'cities.name as city_name')
            ->join('countries', 'countries.id', '=', 'absence_types.country_id')
            ->leftJoin('cities', 'cities.id', '=', 'absence_types.city_id');

        if ($request->has('company_id')) {
            $query->where('absence_types.company_id', $request->company_id);
        }
        $absenceTypes = $query->get();

        return Datatables::of($absenceTypes)->make(true);
    }


    public function reload(Request $request)
    {

          if (!$request->has('company_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        // obtengo los holidays base
        $templates = AbsenceTypeTemplate::all();

        try {
            // elimino los holidays para este compañia
            AbsenceType::where('company_id', $data['company_id'])->where('added_by', 'reload')->delete();
        } catch (\Illuminate\Database\QueryException $e) {

        }
        // creo los nuevos holidays
        foreach ($templates as $template) {
            $exist = AbsenceType::where('title', '=', $template->title)->
            where('country_id', '=', $template->country_id)->
            where('city_id', '=', $template->city_id)->get()->first();

            if (!is_object($exist)) {


                AbsenceType::create(
                    [
                        'country_id' => $template->country_id,
                        'city_id' => $template->city_id,
                        'title' => $template->title,
                        'days' => $template->days,
                        'company_id' => $data['company_id'],
                        'added_by' => 'reload'
                    ]
                );
            }
        }

        return $this->response->noContent();
    }


}

?>