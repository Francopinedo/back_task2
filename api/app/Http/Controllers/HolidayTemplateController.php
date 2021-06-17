<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\HolidayTemplate;
use Transformers\HolidayTemplateTransformer;

/**
 * Modulo de feriados
 *
 * @Resource("Group HolidayTemplate")
 */
class HolidayTemplateController extends Controller {

  	/**
	 * Obtener idiomas
	 *
	 * @Get("holidays_templates")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"date": "date",
     *  		"description": "string",
     *  		"country_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = HolidayTemplate::select('*');

  		if ($request->has('country_id'))
  		{
  			$query->where('country_id', $request->country_id);
  		}


        if($request->has('name')){
            $query = $query->where('name',$request->name);
        }



        $holidays = $query->get();

  		return $this->response->collection($holidays, new HolidayTemplateTransformer);
  	}

  	/**
	 * Crear feriado
	 *
	 * @Post("holidays_templates")
	 * @Request({
	 *      "name": "string",
	 *      "code": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"date": "date",
     *     		"description": "string",
     *     		"country_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('date') || !$request->has('description') || !$request->has('country_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $holiday = HolidayTemplate::create($data);

        if ($holiday)
        {
        	return $this->response->item($holiday, new HolidayTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener feriado
	 *
	 * @Get("holidays_templates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"date": "date",
     *     		"description": "description",
     *     		"country_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$holiday = HolidayTemplate::findOrFail($id);

  		return $this->response->item($holiday, new HolidayTemplateTransformer);
  	}

  	/**
	 * Editar feriado
	 *
	 * @Patch("holidays_templates/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "date": "date",
	 *      "description": "string",
	 *      "country_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"date": "date",
     *     		"description": "string",
     *     		"country_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$holiday = HolidayTemplate::find($id);

  		if ($holiday == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $holiday->update($data);

        if ($holiday)
        {
        	return $this->response->item($holiday, new HolidayTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un feriado
     *
     * @Delete("holidays_templates/{id}")
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
  		$holiday = HolidayTemplate::find($id);

        if ($holiday == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $holiday->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener feriados
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("holidays_templates/datatables")
	 */
  	public function datatables()
  	{
  		$holidays_templates = DB::table('holidays_templates')
                    ->select(
                    	'holidays_templates.id', 'holidays_templates.date', 'holidays_templates.description', 'holidays_templates.country_id',
                    	'countries.name AS country_name')
                    ->join('countries', 'countries.id', '=', 'holidays_templates.country_id')
                    ->get();

  		return Datatables::of($holidays_templates)->make(true);
  	}


    public function destroyAll()
    {
        $holidays  = HolidayTemplate::all();

        foreach ($holidays  as $country){
            try{
                HolidayTemplate::find($country->id)->delete();

            }catch (\Illuminate\Database\QueryException $e){

                //return $this->response->error('Error al eliminar', 450);
            }

        }


        return $this->response->noContent();
    }



}

?>