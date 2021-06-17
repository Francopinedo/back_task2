<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Absence;
use Transformers\AbsenceTransformer;

/**
 * Modulo de Absence
 *
 * @Resource("Group Absence")
 */
class AbsenceController extends Controller  {

  	/**
	 * Obtener
	 *
	 * @Get("absences{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Absence::with('user');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$absences = $query->get();

  		return $this->response->collection($absences, new AbsenceTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("absences")
	 * @Request({
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('project_id') || !$request->has('user_id') || !$request->has('from'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $absence = Absence::create($data);

        if ($absence)
        {
        	return $this->response->item($absence, new AbsenceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("absences/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$absence = Absence::findOrFail($id);

  		return $this->response->item($absence, new AbsenceTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("absences/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"absence_type_id": "int",
     *  		"project_id": "int",
     *  		"comment": "string",
     *  		"from": "date",
     *  		"to": "date",
     *  		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$absence = Absence::find($id);

  		if ($absence == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $absence->update($data);

        if ($absence)
        {
        	return $this->response->item($absence, new AbsenceTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("absences/{id}")
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
  		$absence = Absence::find($id);

        if ($absence == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $absence->delete();

        return $this->response->noContent();
  	}


  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("absences/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('absences')
                    ->select(
                    	'absences.id',
                    	'absence_types.title AS absence_type_title',
                    	'absences.comment',
                    	'absences.from',
                    	'countries.name as country_name',
                    	'cities.name as city_name',
                    	'absences.to',
                        DB::raw('IFNULL(TIMESTAMPDIFF(DAY, absences.from,absences.to)+1,0) as days'),
                    	'users.name AS user_name')
                    ->join('absence_types', 'absence_types.id', '=', 'absences.absence_type_id')
                    ->join('countries', 'absence_types.country_id', '=', 'countries.id')
                    ->join('cities', 'absence_types.city_id', '=', 'cities.id')
                    ->join('users', 'users.id', '=', 'absences.user_id');

        if ($request->has('project_id'))
  		{
  			$query->where('absences.project_id', $request->project_id);
  		}

		$absences = $query->get();

  		return Datatables::of($absences)->make(true);
  	}

}

?>