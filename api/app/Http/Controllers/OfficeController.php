<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Office;
use Transformers\OfficeTransformer;

/**
 * Modulo de Office
 *
 * @Resource("Group Office")
 */
class OfficeController extends Controller {

  	/**
	 * Obtener offices
	 *
	 * @Get("offices{?include,company_id}")
	 * @Parameters({
	 *      @Parameter("company_id", type="integer", required=true, description="ID de una compañia", default=null),
	 *      @Parameter("include", type="integer", required=true, description="Tablas relacionadas", default=null)
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Office::select('offices.id', 'offices.title', 'offices.company_id','offices.hours_by_day','offices.effective_workinghours')->with('departments');

  		if ($request->has('company_id'))
  		{
  			$query->where('offices.company_id', $request->company_id);
  		}

        if ($request->has('city_id'))
        {
            $query->where('offices.city_id', $request->city_id);
        }

        if ($request->has('title')) {
            $query->whereRaw('lower(`title`) LIKE ?', $request->title);
        }
        

  		$offices = $query->get();

  		return $this->response->collection($offices, new OfficeTransformer);
  	}

  	/**
	 * Crear template de industria
	 *
	 * @Post("offices")
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $office = Office::create($data);

        if ($office)
        {
        	return $this->response->item($office, new OfficeTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener template de office
	 *
	 * @Get("offices/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$office = Office::findOrFail($id);

  		return $this->response->item($office, new OfficeTransformer);
  	}

  	/**
	 * Editar template de office
	 *
	 * @Patch("offices/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$office = Office::find($id);

  		if ($office == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $office->update($data);

        if ($office)
        {
        	return $this->response->item($office, new OfficeTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template de office
     *
     * @Delete("offices/{id}")
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
  		$office = Office::find($id);

        if ($office == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $office->delete();

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
  		$query = Office::select(
  			'offices.id',
  			'offices.title',
  			'offices.company_id',
  			'offices.workinghours_from',
  			'offices.workinghours_to',
  			'offices.hours_by_day',
			'offices.effective_workinghours',
  			'cities.name AS city_name'
  		);
  		$query->leftJoin('cities', 'cities.id', '=', 'offices.city_id');

  		if ($request->has('company_id'))
  		{
  			$query->where('offices.company_id', $request->company_id);
  		}

  		$offices = $query->get();

  		return Datatables::of($offices)->make(true);
  	}

}

?>
