<?php

namespace App\Http\Controllers;

use DB;
use App\Language;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Transformers\LanguageTransformer;

/**
 * Modulo de idiomas
 *
 * @Resource("Group Language")
 */
class LanguageController extends Controller {

  	/**
	 * Obtener idiomas
	 *
	 * @Get("languages"")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"code": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Language::select('*');


        if($request->has('name')){
            $query = $query->where('name',$request->name);
        }

        $languages = $query->get();

  		return $this->response->collection($languages, new LanguageTransformer);
  	}

  	/**
	 * Crear idioma
	 *
	 * @Post("languages"")
	 * @Request({
	 *      "name": "string",
	 *      "code": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('code'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $language = Language::create($data);

        if ($language)
        {
        	return $this->response->item($language, new LanguageTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener idioma
	 *
	 * @Get("languages"/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$language = Language::findOrFail($id);

  		return $this->response->item($language, new LanguageTransformer);
  	}

  	/**
	 * Editar pais
	 *
	 * @Patch("languages"/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "name": "string",
	 *      "code": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$language = Language::find($id);

  		if ($language == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $language->update($data);

        if ($language)
        {
        	return $this->response->item($language, new LanguageTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un pais
     *
     * @Delete("languages"/{id}")
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
  		$language = Language::find($id);

        if ($language == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $language->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener paises
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("languages"/datatables")
	 */
  	public function datatables()
  	{
  		$languages = DB::table('languages')
  			->select(
  				'languages.id', 
  				'languages.name', 
  				'languages.code')
  			->get();

  		return Datatables::of($languages)->make(true);
  	}


    public function destroyAll()
    {
        $countries  = Language::all();

        foreach ($countries  as $country){
            try{
                Language::find($country->id)->delete();

            }catch (\Illuminate\Database\QueryException $e){

                //return $this->response->error('Error al eliminar', 450);
            }

        }


        return $this->response->noContent();
    }

}

?>