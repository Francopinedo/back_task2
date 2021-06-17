<?php

namespace App\Http\Controllers;

use App\Models\AbsenceType;
use App\Models\AbsenceTypeTemplate;
use Illuminate\Http\Request;
use Transformers\AbsenceTypeTemplateTransformer;
use Yajra\Datatables\Datatables;
use DB;


/**
 * Modulo de tipos de ausencias
 *
 * @Resource("Group AbsenceType")
 */
class AbsenceTypeTemplateController extends Controller {

  	/**
	 * Obtener tipo de ausencias
	 *
	 * @Get("absence_types")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"country_id": "int",
     *  		"title": "string",
     *  		"days": "int"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$absence_types = AbsenceTypeTemplate::all();

  		return $this->response->collection($absence_types, new AbsenceTypeTemplateTransformer);
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
	 *   		"id": "int",
     *     		"country_id": "int",
     *     		"title": "string",
     *     		"days": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('country_id') || !$request->has('title') || !$request->has('days'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $absenceType = AbsenceTypeTemplate::create($data);

        if ($absenceType)
        {
        	return $this->response->item($absenceType, new AbsenceTypeTemplateTransformer);
        }
        else
    	{
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
	 *   		"id": "int",
     *     		"country_id": "int",
     *     		"title": "string",
     *     		"days": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$absenceType = AbsenceTypeTemplate::findOrFail($id);

  		return $this->response->item($absenceType, new AbsenceTypeTemplateTransformer());
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
	 *   		"id": "int",
     *     		"country_id": "int",
     *     		"title": "string",
     *     		"days": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$absenceType = AbsenceTypeTemplate::find($id);

  		if ($absenceType == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $absenceType->update($data);

        if ($absenceType)
        {
        	return $this->response->item($absenceType, new AbsenceTypeTemplateTransformer);
        }
        else
    	{
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
  		$absenceType = AbsenceTypeTemplate::find($id);

        if ($absenceType == NULL)
        {
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
  	public function datatables()
  	{
  		$absenceTypes = DB::table('absence_types_template as absence_types')
                    ->select(
                    	'absence_types.id', 'absence_types.country_id', 'absence_types.title', 'absence_types.days',
                    	'countries.name AS country_name', 'cities.name as city_name')
                    ->join('countries', 'countries.id', '=', 'absence_types.country_id')
                    ->leftJoin('cities', 'cities.id', '=', 'absence_types.city_id')
                    ->get();

  		return Datatables::of($absenceTypes)->make(true);
  	}





}

?>