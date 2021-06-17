<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Engagement;
use Transformers\EngagementTransformer;

/**
 * Modulo de Engagement
 *
 * @Resource("Group Engagement")
 */
class EngagementController extends Controller {

  	/**
	 * Obtener paises
	 *
	 * @Get("engagements")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$engagements = Engagement::all();

  		return $this->response->collection($engagements, new EngagementTransformer);
  	}

  	/**
	 * Crear pais
	 *
	 * @Post("users")
	 * @Request({
	 *      "name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
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

        $engagement = Engagement::create($data);

        if ($engagement)
        {
        	return $this->response->item($engagement, new EngagementTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear el pais', 451);
    	}
  	}

  	/**
	 * Obtener paises
	 *
	 * @Get("engagements/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID del pais", default=null),
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
  		$engagement = Engagement::findOrFail($id);

  		return $this->response->item($engagement, new EngagementTransformer);
  	}

  	/**
	 * Editar pais
	 *
	 * @Patch("engagements/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID del pais", default=null),
	 * })
	 * @Request({
	 *      "name": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe el pais"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar el pais"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$engagement = Engagement::find($id);

  		if ($engagement == NULL)
  		{
  			return $this->response->error('No existe el pais', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $engagement->update($data);

        if ($engagement)
        {
        	return $this->response->item($engagement, new EngagementTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar el pais', 451);
    	}
  	}

  	/**
     * Elimina un pais
     *
     * @Delete("engagements/{id}")
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
  		$engagement = Engagement::find($id);

        if ($engagement == NULL)
        {
        	return $this->response->error('No existe el pais', 450);
        }

        $engagement->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener paises
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("engagements/datatables")
	 */
  	public function datatables()
  	{
  		$engagements = DB::table('engagements')
                    ->select(
                    	'engagements.id', 'engagements.name')
                    ->get();

  		return Datatables::of($engagements)->make(true);
  	}

}

?>