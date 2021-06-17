<?php

namespace App\Http\Controllers;

use App\Models\AdditionalHour;
use DB;
use Illuminate\Http\Request;
use Transformers\AdditionalHourTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de AdditionalHour
 *
 * @Resource("Group AdditionalHour")
 */
class AdditionalHourController extends Controller
{

    /**
     * Obtener
     *
     * @Get("additional_hours{?project_id}")
     * @Parameters({
     *      @Parameter("project_id", description="ID del proyecto", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = AdditionalHour::with('user');

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->has('date')) {
            $query->where('date', $request->date);
        }
        $additionaHours = $query->get();

        return $this->response->collection($additionaHours, new AdditionalHourTransformer);
    }

 public function get_sum_hours($user_id)
    {
        //$query = DB::table('team_users')->where('user_id',$user_id)->sum('load');
    $query = \DB::select(\DB::raw('select sum(additional_hours.hours) as additional from additional_hours where additional_hours.user_id = '.$user_id.' group by additional_hours.user_id '));
 $query2 = \DB::select(\DB::raw('select sum(team_users.hours) as hours from team_users where team_users.user_id = '.$user_id.' group by team_users.user_id '));
 $additional=0;
 $hours=0;
if(!empty($query))
{
    $additional=$query[0]->additional;
}
if(!empty($query2))
{
    $hours=$query2[0]->hours;
}

        return $additional + $hours;
    }
    /**
     * Crear
     *
     * @Post("additional_hours")
     * @Request({
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('project_id') || !$request->has('user_id') || !$request->has('date') || !$request->has('hours')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $additionaHour = AdditionalHour::create($data);

        if ($additionaHour) {
            return $this->response->item($additionaHour, new AdditionalHourTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("additional_hours/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $additionaHour = AdditionalHour::findOrFail($id);

        return $this->response->item($additionaHour, new AdditionalHourTransformer);
    }

    /**
     * Editar
     *
     * @Patch("additional_hours/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "project_id": "int",
     *        "comments": "string",
     *        "date": "date",
     *        "hours": "int",
     *        "user_id": "int",
     *        "rate_id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $additionaHour = AdditionalHour::find($id);

        if ($additionaHour == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $additionaHour->update($data);

        if ($additionaHour) {
            return $this->response->item($additionaHour, new AdditionalHourTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("additional_hours/{id}")
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
        $additionaHour = AdditionalHour::find($id);

        if ($additionaHour == NULL) {
            return $this->response->error('No existe', 450);
        }

        $additionaHour->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("additional_hours/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('additional_hours')
            ->select(
                'additional_hours.id',
                'users.name AS user_name',
                'additional_hours.project_id',
                'additional_hours.user_id',
                'additional_hours.comments',
                'additional_hours.date',
                'additional_hours.hours',
                'additional_hours.rate_id',
                'additional_hours.project_role_id',
                'additional_hours.seniority_id',
                'additional_hours.rate',
                'additional_hours.currency_id',
                'additional_hours.workplace',
                'additional_hours.country_id',
                'additional_hours.city_id',
                'additional_hours.office_id',
                'additional_hours.rate',
                'offices.title as office_name',
                'countries.name as country_name',
                'cities.name as city_name',
                'currencies.name as currency_title',
                'project_roles.title AS project_role_title',
                'seniorities.title AS seniority_title',
                'rates.title AS rate_title'
            )
            ->join('users', 'users.id', '=', 'additional_hours.user_id')
            ->leftJoin('currencies', 'currencies.id', '=', 'additional_hours.currency_id')
            ->leftJoin('project_roles', 'project_roles.id', '=', 'additional_hours.project_role_id')
            ->leftJoin('seniorities', 'seniorities.id', '=', 'additional_hours.seniority_id')
            ->leftJoin('countries', 'countries.id', '=', 'additional_hours.country_id')
            ->leftJoin('offices', 'offices.id', '=', 'additional_hours.office_id')
            ->leftJoin('cities', 'cities.id', '=', 'additional_hours.city_id')
            ->leftJoin('rates', 'rates.id', '=', 'additional_hours.rate_id');

        if ($request->has('project_id')) {
            $query->where('additional_hours.project_id', $request->project_id);
        }

        $additionaHours = $query->get();

        return Datatables::of($additionaHours)->make(true);
    }

}

?>