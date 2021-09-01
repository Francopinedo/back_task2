<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Holiday;
use App\HolidayTemplate;
use Transformers\HolidayTransformer;

/**
 * Modulo de feriados
 *
 * @Resource("Group Holiday")
 */
class HolidayController extends Controller {

  	/**
	 * Obtener idiomas
	 *
	 * @Get("holidays")
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
  		$query = Holiday::select('*');

  		if ($request->has('country_id'))
  		{
  			$query->where('country_id', $request->country_id);
  		}

        if ($request->has('company_id'))
        {
            $query->where('company_id', $request->company_id);
        }

  		$holidays = $query->get();

  		return $this->response->collection($holidays, new HolidayTransformer);
  	}

  	/**
	 * Crear feriado
	 *
	 * @Post("holidays")
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

        $holiday = Holiday::create($data);

        if ($holiday)
        {
        	return $this->response->item($holiday, new HolidayTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener feriado
	 *
	 * @Get("holidays/{id}")
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
  		$holiday = Holiday::findOrFail($id);

  		return $this->response->item($holiday, new HolidayTransformer);
  	}

  	/**
	 * Editar feriado
	 *
	 * @Patch("holidays/{id}")
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
  		$holiday = Holiday::find($id);

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
        	return $this->response->item($holiday, new HolidayTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un feriado
     *
     * @Delete("holidays/{id}")
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
  		$holiday = Holiday::find($id);

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
	 * @Get("holidays/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('holidays')
                    ->select(
                    	'holidays.id', 'holidays.date', 'holidays.description', 'holidays.country_id',
                    	'countries.name AS country_name', 'holidays.added_by')
                    ->join('countries', 'countries.id', '=', 'holidays.country_id');

        if ($request->has('company_id'))
        {
            $query->where('company_id', $request->company_id);
        }

        $holidays = $query->get();

  		return Datatables::of($holidays)->make(true);
  	}

    /**
     * Crear feriado basados en los templates
     *
     * @Post("holidays/reload")
     * @Request({
     *      "company_id": "string"
     * })
     * @Transaction({
     *      @Response(200, body={
     *          "id": "int",
     *          "date": "date",
     *          "description": "string",
     *          "country_id": "int",
     *          "company_id": "int",
     *          "added_by": "string"
     *      }),
     *      @Response(450, body={"error": {"message": "Faltan datos"}}),
     *      @Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function reload(Request $request)
    {

        if (!$request->has('company_id'))
        {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        // obtengo los holidays base
        $holidayTemplates = HolidayTemplate::all();

        // elimino los holidays para este compañia
        Holiday::where('company_id', $data['company_id'])->where('added_by', 'reload')->delete();

        // creo los nuevos holidays
        foreach ($holidayTemplates as $holidayTemplate)
        {
            Holiday::create(
                [
                    'date'        => $holidayTemplate->date,
                    'description' => $holidayTemplate->description,
                    'country_id'  => $holidayTemplate->country_id,
                    'company_id'  => $data['company_id'],
                    'added_by'    => 'reload'
                ]
            );
        }

        return $this->response->noContent();
    }

}

?>