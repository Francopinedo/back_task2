<?php

namespace App\Http\Controllers;

use App\Models\DirectoryRole;
use Illuminate\Http\Request;
use Transformers\DirectoryRoleRoleTransformer;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\PermissionRole;
use Transformers\PermissionRoleTransformer;

/**
 * Modulo de permisos_roles
 *
 * @Resource("Group PermissionRole")
 */
class DirectoryRoleController extends Controller {

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
  		$directoryRole = DirectoryRole::findOrFail($id);

  		return $this->response->item($directoryRole, new DirectoryRoleRoleTransformer());
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



        $directoryRole = DirectoryRole::where('directory_id', $request->permission_id)
            ->where('role_id', $request->role_id)->first();

        $data = $request->all();
        $datoinsert = array('directory_id'=>$request->permission_id, 'role_id'=>$request->role_id);

        if($request->type=='write'){
            $datoinsert['write']=true;
        }else{
            $datoinsert['read']=true;
        }


        if ($directoryRole == NULL)
        {

            $directoryRole = DirectoryRole::create($datoinsert);
        }else{

            $directoryRole->update($datoinsert);
        }


        if ($directoryRole)
        {
        	return $this->response->item($directoryRole, new DirectoryRoleRoleTransformer());
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
  	public function destroy($permission_id, $role_id, $type)
  	{
  		$permissionRole = DirectoryRole::where('directory_id', $permission_id)
            ->where('role_id', $role_id)->first();

        if ($permissionRole == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $datoinsert = array('directory_id'=>$permissionRole->directory_id, 'role_id'=>$permissionRole->role_id);

        if($type=='write'){
            $datoinsert['write']=false;
        }else{
            $datoinsert['read']=false;
        }

        $permissionRole->update($datoinsert);

        return $this->response->noContent();
  	}

}

?>