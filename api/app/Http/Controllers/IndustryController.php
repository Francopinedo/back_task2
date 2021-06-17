<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Industry;
use Transformers\IndustryTransformer;

/**
 * Modulo de industrias
 *
 * @Resource("Group Industry")
 */
class IndustryController extends Controller {

  	/**
	 * Obtener industrias
	 *
	 * @Get("industries")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Industry::query();
        if($request->has('name')){
            $query->where('name',$request->name);
        }
        $industries = $query->get();
  		return $this->response->collection($industries, new IndustryTransformer);
  	}

  	/**
	 * Crear industria
	 *
	 * @Post("industries")
	 * @Request({
	 *      "name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $industry = Industry::create($data);

        if ($industry)
        {
        	return $this->response->item($industry, new IndustryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener industria
	 *
	 * @Get("industries/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$industry = Industry::findOrFail($id);

  		return $this->response->item($industry, new IndustryTransformer);
  	}

  	/**
	 * Editar industria
	 *
	 * @Patch("industries/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$industry = Industry::find($id);

  		if ($industry == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $industry->update($data);

        if ($industry)
        {
        	return $this->response->item($industry, new IndustryTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una industria
     *
     * @Delete("industries/{id}")
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
  		$industry = Industry::find($id);

        if ($industry == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $industry->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener ciudades
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("industries/datatables")
	 */
  	public function datatables()
  	{
  		$industries = DB::table('industries')
                    ->select(
                    	'industries.id', 'industries.name')
                    ->get();

  		return Datatables::of($industries)->make(true);
  	}

}

?>