<?php

namespace App\Http\Controllers;

use App\Models\WhatIfTaskResource;
use DB;
use Illuminate\Http\Request;
use Transformers\WhatIfTaskResourceTransformer;
use Yajra\Datatables\Datatables;

/**
 * Modulo de WhatIfTaskResource
 *
 * @Resource("Group WhatIfTaskResource")
 */
class WhatIfTaskResourceController extends Controller
{

    /**
     * Obtener
     *
     * @Get("whatif_task_resources{?company_id}")
     * @Parameters({
     *      @Parameter("company_id", description="ID de la compañia", default=1),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function index(Request $request)
    {
        $query = WhatIfTaskResource::join('users','users.id','=','whatif_task_resources.user_id');


        if ($request->has('whatif_task_id')) {
            $query->where('whatif_task_id', $request->whatif_task_id);
        }

        $WhatIfTaskResources = $query->get(['whatif_task_resources.*', 'users.id as user_id', 'users.name']);

        return $this->response->collection($WhatIfTaskResources, new WhatIfTaskResourceTransformer);
    }

    /**
     * Crear
     *
     * @Post("whatif_task_resources")
     * @Request({
     *
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
     *   	@Response(451, body={"error": {"message": "Error al crear"}})
     * })
     */
    public function store(Request $request)
    {
        if (!$request->has('whatif_task_id')
            || !$request->has('user_id')
        ) {
            return $this->response->error('Faltan datos', 450);
        }

        $data = $request->all();

        $WhatIfTaskResource = WhatIfTaskResource::create($data);

        if ($WhatIfTaskResource) {
            return $this->response->item($WhatIfTaskResource, new WhatIfTaskResourceTransformer);
        } else {
            return $this->response->error('Error al crear', 451);
        }
    }

    /**
     * Obtener ciudad
     *
     * @Get("whatif_task_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    })
     * })
     */
    public function show($id)
    {
        $WhatIfTaskResource = WhatIfTaskResource::findOrFail($id);

        return $this->response->item($WhatIfTaskResource, new WhatIfTaskResourceTransformer);
    }

    /**
     * Editar
     *
     * @Patch("whatif_task_resources/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID", default=null),
     * })
     * @Request({
     *
     * })
     * @Transaction({
     *   	@Response(200, body={
     *        "id": "int"
     *    }),
     *   	@Response(450, body={"error": {"message": "No existe"}}),
     *   	@Response(451, body={"error": {"message": "Error al editar"}}),
     *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
     * })
     */
    public function update(Request $request, $id)
    {
        $WhatIfTaskResource = WhatIfTaskResource::find($id);

        if ($WhatIfTaskResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $data = $request->all();

        if (empty($data)) {
            return $this->response->error('No envio ningun parametro para actualizar', 452);
        }

        $WhatIfTaskResource->update($data);

        if ($WhatIfTaskResource) {
            return $this->response->item($WhatIfTaskResource, new WhatIfTaskResourceTransformer);
        } else {
            return $this->response->error('Error al editar', 451);
        }
    }

    /**
     * Elimina
     *
     * @Delete("whatif_task_resources/{id}")
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
        $WhatIfTaskResource = WhatIfTaskResource::find($id);

        if ($WhatIfTaskResource == NULL) {
            return $this->response->error('No existe', 450);
        }

        $WhatIfTaskResource->delete();

        return $this->response->noContent();
    }

    /**
     * Obtener
     *
     * Con formato listo para datatables con ajax
     * @Get("whatif_task_resources/datatables")
     */
    public function datatables(Request $request)
    {
        $query = DB::table('whatif_task_resources')
            ->select(
                'whatif_task_resources.id',
                'whatif_task_resources.whatif_task_id',
                'whatif_task_resources.user_id',
                'whatif_task_resources.rate',
                'whatif_task_resources.quantity',
                'whatif_task_resources.currency_id',
                'currencies.name as currency_name',
                'project_roles.title as project_role_title',
                'seniorities.title as seniority_name',
                'users.name AS user_name'
            )
            ->leftJoin('users', 'users.id', '=', 'whatif_task_resources.user_id')
            ->leftJoin('project_roles', 'project_roles.id', '=', 'whatif_task_resources.project_role_id');

        if ($request->has('whatif_task_id')) {
            $query->where('whatif_task_resources.whatif_task_id', $request->whatif_task_id);
        }
        $query->leftJoin('currencies', 'currencies.id', '=', 'whatif_task_resources.currency_id');
        $query->leftJoin('seniorities', 'seniorities.id', '=', 'whatif_task_resources.seniority_id');

        if ($request->has('project_id')) {
            $query->join('whatif_tasks', 'whatif_tasks.id', '=', 'whatif_task_resources.whatif_task_id');
            $query->where('whatif_tasks.project_id', $request->project_id);
        }

        $WhatIfTaskResources = $query->get();

        return Datatables::of($WhatIfTaskResources)->make(true);
    }

}

?>