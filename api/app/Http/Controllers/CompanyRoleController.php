<?php

namespace App\Http\Controllers;

use App\CompanyRoleTemplate;
use App\Models\CompanyRole;
use App\Models\Role;
use DB;
use Illuminate\Http\Request;
use Transformers\CompanyRoleTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de CompanyRole
 *
 * @Resource("Group CompanyRole")
 */
class CompanyRoleController extends Controller
{

    /**
     * Obtener company_roles
     *
     * @Get("company_roles{?company_id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID de una compañia", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = CompanyRole::select('company_roles.id', 'company_roles.title', 'company_roles.company_id');

        if ($request->has('company_id')) {
            $query->where('company_roles.company_id', $request->company_id);
        }
        if ($request->has('role_id')) {
            $query->where('company_roles.company_id', $request->company_id);
        }
        
         if ($request->has('title')) {
            $query->whereRaw('lower(`title`) LIKE ?', $request->title);
        }

        $company_roles = $query->get();

        return $this->response->collection($company_roles, new CompanyRoleTransformer);
    }

    /**
     * Crear company role
     *
     * @Post("company_roles")
     * @Request({
     *      "title": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('title')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $companyRole = CompanyRole::create($data);

        if ($companyRole) {
            // creo tambien un rol en la tabla Roles
            Role::create(['name' => $companyRole->title, 'slug' => $companyRole->id, 'company_role_id' => $companyRole->id]);
            return $this->response->item($companyRole, new CompanyRoleTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener una company role
     *
     * @Get("company_roles/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    })
     * })
     */
    public function show($id)
    {
        $companyRole = CompanyRole::findOrFail($id);

        return $this->response->item($companyRole, new CompanyRoleTransformer);
    }

    /**
     * Editar una company role
     *
     * @Patch("company_roles/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *      "title": "string"
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int",
     *        "title": "string"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $companyRole = CompanyRole::find($id);

        if ($companyRole == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $companyRole->update($data);

        if ($companyRole) {
            return $this->response->item($companyRole, new CompanyRoleTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina una company role
     *
     * @Delete("company_roles/{id}")
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
        $companyRole = CompanyRole::find($id);

        if ($companyRole == NULL) {
            return $this->response->error('No existe', 450);
        }

        $companyRole->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener company_roles
     *
     * Con formato listo para datatables con ajax
     * @Get("company_roles/datatables")
     */
    public function datatables(Request $request)
    {
        $query = CompanyRole::select('company_roles.id', 'company_roles.title', 'company_roles.company_id');

        if ($request->has('company_id')) {
            $query->where('company_roles.company_id', $request->company_id);
        }

        $company_roles = $query->get();

        return Datatables::of($company_roles)->make(true);
    }


    public function reload(Request $request)
    {
        if (!$request->has('company_id')) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        // obtengo los holidays base
        $templates = CompanyRoleTemplate::all();

        // elimino los holidays para este compañia
        CompanyRole::where('company_id', $data['company_id'])->delete();

        // creo los nuevos holidays
        foreach ($templates as $holidayTemplate) {
            CompanyRole::create(
                [
                    // 'date'        => $holidayTemplate->date,
                    'title' => $holidayTemplate->title,
                    //'country_id'  => $holidayTemplate->country_id,
                    'company_id' => $data['company_id'],
                    //'added_by'    => 'reload'
                ]
            );
        }

        return $this->response->noContent();
    }


     public function import()
    {

        return response()->json([
            'view' => view('company_role/import')->render()
        ]);
    }

  public function do_import(Request $request)
    {

        $array = array();
        try {
            $validator =Validator::make($request->all(), [

                'file' => 'required'
            ]);

            $file = $request->file('file');

            $array = procces_import($file);

             $company = $this->getFromApi('GET', 'companies/fromUser/' . Auth::id());
            $city =array();
            $company =array();
            $country =array();
            $item = array();

            foreach ($array as $value) {

                if (isset($value[0])) {
                   

                     
                        $item['roles'] = $value[0];
                        $item['company_id'] = $company->id;

                        //$item['added_by'] = Auth::id();
                      $res =  $this->apiCall('POST', 'company_roles', $item);

    if (!empty(json_decode($res->getBody()->__toString(), TRUE)['error']))
        {
            $jsonRes = json_decode($res->getBody()->__toString(), TRUE)['error'];
             return response()->json(array('success' => false, 'message' => 'Error with format file, some rows not import'));
        }
                }
             }
        } catch (Exception $exception) {
          return response()->json(array('success' => false, 'message' => 'Error with format file'));
       }
         session()->flash('message', __('general.added'));
            session()->flash('alert-class', 'success');
        return response()->json(array('success' => true));
    }

}

?>