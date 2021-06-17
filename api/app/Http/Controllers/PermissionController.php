<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Permission;
use Transformers\PermissionTransformer;

/**
 * Modulo de permisos
 *
 * @Resource("Group Permission")
 */
class PermissionController extends Controller {

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
  	public function index()
  	{
  		$permissions = Permission::all();

  		return $this->response->collection($permissions, new PermissionTransformer);
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
  		$permission = Permission::findOrFail($id);

  		return $this->response->item($permission, new PermissionTransformer);
  	}

}

?>