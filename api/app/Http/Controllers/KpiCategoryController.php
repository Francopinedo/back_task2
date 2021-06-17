<?php

namespace App\Http\Controllers;

use App\Models\KpiCategory;
use Illuminate\Http\Request;
use Transformers\KpiCategoryTransformer;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Kpi;
use Transformers\KpiTransformer;

/**
 * Modulo de Kpis
 *
 * @Resource("Group Kpi")
 */
class KpiCategoryController extends Controller {

  	/**
	 * Obtener kpis
	 *
	 * @Get("kpis{?include, company_id}")
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
  		$query = KpiCategory::query();


  		$query->where('company_id', $request->company_id);

  		$kpis = $query->get();

  		return $this->response->collection($kpis, new KpiCategoryTransformer());
  	}


  	/**
	 * Crear Cost
	 *
	 * @Post("kpis")
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

        $kpi = KpiCategory::create($data);

        if ($kpi)
        {
        	return $this->response->item($kpi, new KpiCategoryTransformer());
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener cost
	 *
	 * @Get("kpis/{id}")
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
  		$kpi = KpiCategory::findOrFail($id);

  		return $this->response->item($kpi, new KpiCategoryTransformer());
  	}

  	/**
	 * Editar cost
	 *
	 * @Patch("kpis/{id}")
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
  		$kpi = KpiCategory::find($id);

  		if ($kpi == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();
        $data['roles'] = json_encode($data['roles']);
  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $kpi->update($data);

        if ($kpi)
        {
        	return $this->response->item($kpi, new KpiCategoryTransformer());
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina una cost
     *
     * @Delete("kpis/{id}")
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
  		$kpi = KpiCategory::find($id);

        if ($kpi == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $kpi->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener kpis
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("kpis/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$companyId = ($request->has('company_id')) ? $request->company_id : null;

  		$query = DB::table('kpis_category')
                    ->select(
                    	'kpis_category.id',
                    	'kpis_category.name',
                    	'kpis_category.company_id');

        if (!empty($companyId))
        {
        	$query->where('kpis_category.company_id', $companyId);
        }

        $kpis = $query->get();

  		return Datatables::of($kpis)->make(true);
  	}

}

?>