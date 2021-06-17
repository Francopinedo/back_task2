<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Favorite;
use Transformers\FavoriteTransformer;

/**
 * Modulo de favoritos
 *
 * @Resource("Group Favorites")
 */
class FavoriteController extends Controller {

  	/**
	 * Obtener favoritos
	 *
	 * @Get("favorites")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"url": "string",
     *  		"order": "int"
	 *   	})
	 * })
	 */
  	public function index()
  	{
  		$favorites = Favorite::all();

  		return $this->response->collection($favorites, new FavoriteTransformer);
  	}

  	/**
	 * Obtener favoritos
	 *
	 * @Get("favorites/user/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID del usuario", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string",
     *  		"url": "string",
     *  		"order": "int"
	 *   	})
	 * })
	 */
  	public function fromUser($user_id)
  	{
  		$favorites = Favorite::where('user_id', $user_id)->get();

  		return $this->response->collection($favorites, new FavoriteTransformer);
  	}

  	/**
	 * Checkear favorito
	 *
	 * @Get("favorites/check{?url,user_id}")
	 * @Parameters({
 	 *      @Parameter("url", description="url.", default=null),
 	 *      @Parameter("user_id", description="User ID", default=null)
 	 * })
	 * @Transaction({
	 *   	@Response(204),
	 *   	@Response(450, body={"error": {"message": "No existe el favorito"}})
	 * })
	 */
  	public function check(Request $request)
  	{
		$favorite = Favorite::where('url', urldecode($request->url))->where('user_id', $request->user_id)->first();
  		if ($favorite) {
  			return $this->response->noContent();
  		}
  		else
  		{
  			// return $this->response->error('No existe el favorito', 450);
  		}
  	}

  	/**
	 * Crear favorito
	 *
	 * @Post("favorites")
	 * @Request({
	 *      "title": "string",
	 *      "url": "string",
	 *      "order": "int",
	 *      "user_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *     		"title": "string",
     *     		"url": "string",
     *     		"order": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title') || !$request->has('order'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $favorite = Favorite::create($data);

        if ($favorite)
        {
        	return $this->response->item($favorite, new FavoriteTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener favorito
	 *
	 * @Get("favorites/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *     		"title": "string",
     *     		"url": "string",
     *     		"order": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$favorite = Favorite::findOrFail($id);

  		return $this->response->item($favorite, new FavoriteTransformer);
  	}

  	/**
	 * Editar favorito
	 *
	 * @Patch("favorites/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string",
	 *      "url": "string",
	 *      "order": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *     		"title": "string",
     *     		"url": "string",
     *     		"order": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$favorite = Favorite::find($id);

  		if ($favorite == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $favorite->update($data);

        if ($favorite)
        {
        	return $this->response->item($favorite, new FavoriteTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una favorito
     *
     * @Delete("favorites{?url,user_id}")
     * @Parameters({
     *      @Parameter("url", description="url.", default=null),
 	 *      @Parameter("user_id", description="User ID", default=null)
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
  	public function destroy(Request $request)
  	{
  		$favorite = Favorite::where('user_id', $request->user_id)->where('url', $request->url)->first();

        if ($favorite == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $favorite->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener favoritos
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("favorites/datatables")
	 */
  	public function datatables()
  	{
  		$favorites = DB::table('favorites')
                    ->select(
                    	'favorites.id', 'favorites.title', 'favorites.url', 'favorites.order')
                    ->get();

  		return Datatables::of($favorites)->make(true);
  	}

}

?>