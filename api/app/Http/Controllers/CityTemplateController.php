<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\CityTemplate;
use Transformers\CityTemplateTransformer;

/**
 * Modulo de ciudades
 *
 * @Resource("Group Cities")
 */
class CityTemplateController extends Controller {

  	/**
	 * Obtener ciudades
	 *
	 * @Get("cities")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"location_name": "string",
     *  		"country_id": "int",
     *  		"timezone": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = CityTemplate::select('*');

  		if($request->has('country_id')){
            $query = $query->where('country_id',$request->country_id);
        }

        if($request->has('name')){
            $query = $query->where('name',$request->name);
        }
        $cities = $query->get();
  		return $this->response->collection($cities, new CityTemplateTransformer);
  	}

  	/**
	 * Crear ciudad
	 *
	 * @Post("cities")
	 * @Request({
	 *      "name": "string",
	 *      "location_name": "string",
	 *      "country_id": "int",
	 *      "timezone": "string (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"location_name": "string",
     *     		"country_id": "int",
     *     		"timezone": "string (opt)"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('location_name') || !$request->has('country_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $city = CityTemplate::create($data);

        if ($city)
        {
        	return $this->response->item($city, new CityTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("cities/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"location_name": "string",
     *     		"country_id": "int",
     *     		"timezone": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$city = CityTemplate::findOrFail($id);

  		return $this->response->item($city, new CityTemplateTransformer);
  	}

  	/**
	 * Editar ciudad
	 *
	 * @Patch("cities/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "name": "string",
	 *      "location_name": "string",
	 *      "country_id": "int",
	 *      "timezone": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"location_name": "string",
     *     		"country_id": "int",
     *     		"timezone": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$city = CityTemplate::find($id);

  		if ($city == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $city->update($data);

        if ($city)
        {
        	return $this->response->item($city, new CityTemplateTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una ciudad
     *
     * @Delete("cities/{id}")
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
  		$city = CityTemplate::find($id);

        if ($city == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $city->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("cities/datatables")
	 */
  	public function datatables()
  	{
  		$cities = DB::table('cities_template')
                    ->select(
                    	'cities_template.id', 'cities_template.name', 'cities_template.location_name',
                            'cities_template.country_id', 'cities_template.timezone',
                    	'countries.name AS country_name')
                    ->join('countries', 'countries.id', '=', 'cities_template.country_id')
                    ->get();

  		return Datatables::of($cities)->make(true);
  	}


    public function destroyAll()
    {
        $countries  = CityTemplate::all();

        foreach ($countries  as $country){
            try{
                CityTemplate::find($country->id)->delete();

            }catch (\Illuminate\Database\QueryException $e){

                //return $this->response->error('Error al eliminar', 450);
            }

        }


        return $this->response->noContent();
    }


}

?>