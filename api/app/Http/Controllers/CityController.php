<?php

namespace App\Http\Controllers;

use App\City;
use App\CityTemplate;
use DB;
use Illuminate\Http\Request;
use Mockery\Exception;
use Transformers\CityTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de ciudades
 *
 * @Resource("Group Cities")
 */
class CityController extends Controller
{

    /**
     * Obtener ciudades
     *
     * @Get("cities")
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "name": "string",
     *        "location_name": "string",
     *        "country_id": "int",
     *        "timezone": "string"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = City::select('*');

        if ($request->has('country_id')) {
            $query = $query->where('country_id', $request->country_id);
        }

        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('name')) {
            $query->where('name', $request->name);
        }

        
        $cities = $query->get();
        return $this->response->collection($cities, new CityTransformer);
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
     *        "id": "int",
     *        "name": "string",
     *            "location_name": "string",
     *            "country_id": "int",
     *            "timezone": "string (opt)"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('name') || !$request->has('location_name') || !$request->has('country_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $city = City::create($data);

        if ($city) {
            return $this->response->item($city, new CityTransformer);
        } else {
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
     *        "id": "int",
     *        "name": "string",
     *            "location_name": "string",
     *            "country_id": "int",
     *            "timezone": "string"
     *    })
     * })
     */
    public function show($id)
    {
        $city = City::findOrFail($id);

        return $this->response->item($city, new CityTransformer);
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
     *        "id": "int",
     *        "name": "string",
     *            "location_name": "string",
     *            "country_id": "int",
     *            "timezone": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $city = City::find($id);

        if ($city == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $city->update($data);

        if ($city) {
            return $this->response->item($city, new CityTransformer);
        } else {
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
        $city = City::find($id);

        if ($city == NULL) {
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
    public function datatables(Request $request)
    {
        $query = DB::table('cities')
            ->select(
                'cities.id', 'cities.name', 'cities.location_name', 'cities.country_id', 'cities.timezone',
                'countries.name AS country_name')
            ->join('countries', 'countries.id', '=', 'cities.country_id');


        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        $cities = $query->get();
        return Datatables::of($cities)->make(true);
    }


    public function reload(Request $request)
    {


        if (!$request->has('company_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();


        // obtengo los holidays base
        $templates = CityTemplate::all();

        try {
            // elimino los cities para este compañia
            City::where('company_id', $data['company_id'])->where('added_by', 'reload')->delete();
        } catch (\Illuminate\Database\QueryException $e) {

        }
        // creo los nuevos holidays
        foreach ($templates as $template) {
           $exist =  City::where('name','=',$template->name)->get()->first();
           if(!is_object($exist)) {
               City::create(
                   [
                       'name' => $template->name,
                       'location_name' => $template->location_name,
                       'country_id' => $template->country_id,
                       'timezone' => $template->timezone,
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
