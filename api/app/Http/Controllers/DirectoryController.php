<?php

namespace App\Http\Controllers;

use App\Models\Directory;
use Illuminate\Http\Request;
use Transformers\DirectoryTransformer;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Permission;
use Transformers\PermissionTransformer;

/**
 * Modulo de permisos
 *
 * @Resource("Group Permission")
 */
class DirectoryController extends Controller {

	/**
	 * Obtener
	 *
	 * @Get("permissions")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={{
	 *   		"id": "int",
     *  		"name": "string",
     *     		"slug": "string"
	 *   	}})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Directory::query();

        if ($request->has('parent')) {
            $query->where('parent', $request->parent);
        }else{
            $query->where('parent', null);
        }


        $directories = $query->get();
  		return $this->response->collection($directories, new DirectoryTransformer);
  	}
  	/**
	 * Obtener
	 *
	 * @Get("permissions/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"slug": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$permission = Directory::findOrFail($id);

  		return $this->response->item($permission, new DirectoryTransformer);
  	}



}

?>