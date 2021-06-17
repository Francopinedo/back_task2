<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Country;
use Transformers\CountryTransformer;

/**
 * Modulo de paises
 *
 * @Resource("Group Country")
 */
class CountryController extends Controller {

  	/**
	 * Obtener paises
	 *
	 * @Get("countries")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"language_id": "int",
     *  		"currency_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
        $query = Country::select('*');

        if($request->has('name')){
            $query = $query->where('name',$request->name);
        }

        $countries = $query->get();

  		return $this->response->collection($countries, new CountryTransformer);
  	}

  	/**
	 * Crear pais
	 *
	 * @Post("users")
	 * @Request({
	 *      "name": "string",
	 *      "language_id": "int (opt)",
     *  	"currency_id": "int (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"language_id": "int",
     *  		"currency_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear el pais"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $country = Country::create($data);

        if ($country)
        {
        	return $this->response->item($country, new CountryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear el pais', 451);
    	}
  	}

  	/**
	 * Obtener paises
	 *
	 * @Get("countries/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID del pais", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"language_id": "int",
     *  		"currency_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$country = Country::findOrFail($id);

  		return $this->response->item($country, new CountryTransformer);
  	}

  	/**
	 * Editar pais
	 *
	 * @Patch("countries/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID del pais", default=null),
	 * })
	 * @Request({
	 *      "name": "string",
	 *      "language_id": "int (opt)",
     *  	"currency_id": "int (opt)"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"language_id": "int",
     *  		"currency_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe el pais"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar el pais"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$country = Country::find($id);

  		if ($country == NULL)
  		{
  			return $this->response->error('No existe el pais', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $country->update($data);

        if ($country)
        {
        	return $this->response->item($country, new CountryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar el pais', 451);
    	}
  	}

  	/**
     * Elimina un pais
     *
     * @Delete("countries/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID del pais.", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe el pais"}})
     * })
     */
  	public function destroy($id)
  	{
  		$country = Country::find($id);

        if ($country == NULL)
        {
        	return $this->response->error('No existe el pais', 450);
        }

        $country->delete();

        return $this->response->noContent();
  	}


    public function destroyAll()
    {
        $countries  = Country::all();

        foreach ($countries  as $country){
            try{
                Country::find($country->id)->delete();

            }catch (\Illuminate\Database\QueryException $e){

                //return $this->response->error('Error al eliminar', 450);
            }

        }


        return $this->response->noContent();
    }




    /**
	 * Obtener paises
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("countries/datatables")
	 */
  	public function datatables()
  	{
  		$countries = DB::table('countries')
                    ->select(
                    	'countries.id', 'countries.code', 'countries.name', 'countries.language_id', 'countries.currency_id',
                    	'languages.name AS language_name',
                    	'currencies.name AS currency_name')
                    ->leftJoin('languages', 'languages.id', '=', 'countries.language_id')
                    ->leftJoin('currencies', 'currencies.id', '=', 'countries.currency_id')
                    ->get();

  		return Datatables::of($countries)->make(true);
  	}

}

?>