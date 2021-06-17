<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use Transformers\RoleTransformer;

/**
 * Modulo de roles
 *
 * @Resource("Group Roles")
 */
class RolesController extends Controller {

  	/**
	 * Obtener roles
	 *
	 * @Get("roles")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"company_role_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Role::select('*');

        if ($request->has('name')) {
            $query->where('name', $request->name);
        }
         $roles = $query->get();

  		return $this->response->collection($roles, new RoleTransformer);
  	}

  	public function create()
  	{

  	}

  	public function store(Request $request)
  	{
      
  	}

  	/**
	 * Obtener
	 *
	 * @Get("roles/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *    		"id": "int",
     *  		"name": "string",
     *  		"company_role_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$role = Role::findOrFail($id);

  		return $this->response->item($role, new RoleTransformer);
  	}

  	public function edit()
  	{

  	}


  	public function update(Request $request, $id)
  	{

  	}


  	public function destroy($id)
  	{

  	}

}

?>