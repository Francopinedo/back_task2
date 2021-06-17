<?php

namespace App\Http\Controllers;

use App\Models\DashboardCategory;
use Illuminate\Http\Request;
use Transformers\DashboardCategoryTransformer;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Dashboard;
use Transformers\DashboardTransformer;

/**
 * Modulo de Dashboards
 *
 * @Resource("Group Dashboard")
 */
class DashboardCategoryController extends Controller {

  	/**
	 * Obtener Dashboards
	 *
	 * @Get("Dashboards{?include, company_id}")
	 * @Parameters({
 	 *      @Parameter("include", description="Tablas relacionadas", default=1),
 	 *      @Parameter("company_id", description="ID de la compañia padre", default=null),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = DashboardCategory::query();


  		$query->where('company_id', $request->company_id);

if($request->has('withdashboard'))
{
	
	$iddashboard=DB::select(\DB::raw('select category from dashboard where showdashboard=1 group by category'));
$idsD=array();
	foreach($iddashboard as $id)
	{
		
			array_push($idsD,$id->category);
	}
//	return $idsD;

	$query->whereIn('id',$idsD);

}

$Dashboards = $query->get();
//return $Dashboards;
  		return $this->response->collection($Dashboards, new DashboardCategoryTransformer());
  	}


  	/**
	 * Crear Cost
	 *
	 * @Post("Dashboards")
	 * @Request({
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('company_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();
        $data['roles'] = json_encode($data['roles']);

        $Dashboard = DashboardCategory::create($data);

        if ($Dashboard)
        {
        	return $this->response->item($Dashboard, new DashboardCategoryTransformer());
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener cost
	 *
	 * @Get("Dashboards/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$Dashboard = DashboardCategory::findOrFail($id);

  		return $this->response->item($Dashboard, new DashboardCategoryTransformer());
  	}

  	/**
	 * Editar cost
	 *
	 * @Patch("Dashboards/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"company_id": "int",
     *  		"category": "varchar",
     *  		"description": "varchar",
     *  		"query": "varchar"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$Dashboard = DashboardCategory::find($id);

  		if ($Dashboard == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();
        $data['roles'] = json_encode($data['roles']);
  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $Dashboard->update($data);

        if ($Dashboard)
        {
        	return $this->response->item($Dashboard, new DashboardCategoryTransformer());
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una cost
     *
     * @Delete("Dashboards/{id}")
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
  		$Dashboard = DashboardCategory::find($id);

        if ($Dashboard == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $Dashboard->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener Dashboards
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("Dashboards/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$companyId = ($request->has('company_id')) ? $request->company_id : null;

  		$query = DB::table('Dashboards_category')
                    ->select(
                    	'Dashboards_category.id',
                    	'Dashboards_category.name',
                    	'Dashboards_category.company_id');

        if (!empty($companyId))
        {
        	$query->where('Dashboards_category.company_id', $companyId);
        }

        $Dashboards = $query->get();

  		return Datatables::of($Dashboards)->make(true);
  	}

}

?>