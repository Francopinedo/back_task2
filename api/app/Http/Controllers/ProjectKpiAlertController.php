<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\ProjectKpiAlert;
use Transformers\ProjectKpiAlertTransformer;
use App\Models\Kpi;

/**
 * Modulo de ProjectKpiAlert
 *
 * @Resource("Group ProjectKpiAlert")
 */
class ProjectKpiAlertController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("project_kpi_alerts{?project_id}")
	 * @Parameters({
 	 *      @Parameter("project_id", description="ID del proyecto", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = ProjectKpiAlert::with('project');

  		if ($request->has('project_id'))
  		{
  			$query->where('project_id', $request->project_id);
  		}

  		$projectKpiAlerts = $query->get();

  		return $this->response->collection($projectKpiAlerts, new ProjectKpiAlertTransformer);
  	}

  	/**
	 * Crear
	 *
	 * @Post("project_kpi_alerts")
	 * @Request({
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('kpi_id') ||
  			!$request->has('project_id') ||
  			!$request->has('red_alert') ||
  			!$request->has('yellow_alert') ||
  			!$request->has('green_alert'))
    	{
    		return $this->response->error('Faltan datos', 452);
    	}

    	$data = $request->all();

        $projectKpiAlert = ProjectKpiAlert::create($data);

        if ($projectKpiAlert)
        {
        	return $this->response->item($projectKpiAlert, new ProjectKpiAlertTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("project_kpi_alerts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$projectKpiAlert = ProjectKpiAlert::findOrFail($id);

  		return $this->response->item($projectKpiAlert, new ProjectKpiAlertTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("project_kpi_alerts/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"kpi_id": "int",
     *  		"project_id": "int",
     *  		"red_alert": "float",
     *  		"yellow_alert": "float",
     *  		"red_alert": "float"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$projectKpiAlert = ProjectKpiAlert::find($id);

  		if ($projectKpiAlert == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $projectKpiAlert->update($data);

        if ($projectKpiAlert)
        {
        	return $this->response->item($projectKpiAlert, new ProjectKpiAlertTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("project_kpi_alerts/{id}")
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
  		$projectKpiAlert = ProjectKpiAlert::find($id);

        if ($projectKpiAlert == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $projectKpiAlert->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("project_kpi_alerts/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('project_kpi_alerts')
                    ->select(
                    	'project_kpi_alerts.id',
                    	'project_kpi_alerts.kpi_id',
                    	'project_kpi_alerts.project_id',
                    	'project_kpi_alerts.red_alert',
                    	'project_kpi_alerts.yellow_alert',
						'project_kpi_alerts.green_alert',
						'project_kpi_alerts.percent_red_alert',
                    	'project_kpi_alerts.percent_yellow_alert',
                    	'project_kpi_alerts.percent_green_alert',
                    	'kpis.description AS kpi_description'
                    );

        $query->leftJoin('kpis', 'kpis.id', '=', 'project_kpi_alerts.kpi_id');

        if ($request->has('project_id'))
  		{
        	$query->leftJoin('projects', 'projects.id', '=', 'project_kpi_alerts.project_id');
  			$query->where('project_kpi_alerts.project_id', $request->project_id);
  		}

		  $projectKpiAlerts = $query->get();

  		return Datatables::of($projectKpiAlerts)->make(true);
	  }


	  public function alerts_per_kpi($kpi,$kpisCant=array(),$opt=1)
	  {



	  }

}

?>