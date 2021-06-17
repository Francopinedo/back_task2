<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\PermissionRole;
use Transformers\PermissionRoleTransformer;

/**
 * Modulo de permisos_roles
 *
 * @Resource("Group PermissionRole")
 */
class PermissionRoleController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("permission_roles/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"permission_id": "int",
     *     		"role_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$permissionRole = PermissionRole::findOrFail($id);

  		return $this->response->item($permissionRole, new PermissionRoleTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("permission_roles")
	 * @Request({
     *  		"permission_id": "int",
     *     		"role_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"permission_id": "int",
     *     		"role_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('permission_id') || !$request->has('role_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $permissionRole = PermissionRole::create($data);

        if ($permissionRole)
        {
        	return $this->response->item($permissionRole, new PermissionRoleTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("permission_roles/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe"}})
     * })
     */
  	public function destroy($permission_id, $role_id)
  	{
  		$permissionRole = PermissionRole::where('permission_id', $permission_id)->where('role_id', $role_id)->first();

        if ($permissionRole == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $permissionRole->delete();

        return $this->response->noContent();
  	}

}

?>