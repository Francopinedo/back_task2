<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\City;
use Transformers\CityTransformer;

/**
 * Modulo de role_users
 *
 * @Resource("Group RoleUsers")
 */
class RoleUsersController extends Controller {

  	/**
	 * Editar
	 *
	 * @Patch("role_users/fromUser/{user_id}")
	 * @Parameters({
	 *      @Parameter("user_id", type="integer", required=true, description="ID de usuario", default=null),
	 * })
	 * @Request({
	 *      "role_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"role_id": "int",
     *     		"user_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $user_id)
  	{
  		$roleUser = RoleUser::where('user_id', $user_id)->first();

  		if ($roleUser == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $roleUser->update($data);

        if ($roleUser)
        {
        	return $this->response->item($roleUser, new RoleUserTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}


}

?>