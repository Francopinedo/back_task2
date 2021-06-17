<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Material;
use Transformers\MaterialTransformer;

/**
 * Modulo de Materials
 *
 * @Resource("Group Materials")
 */
class MaterialController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("materials{?company_id}")
	 * @Parameters({
 	 *      @Parameter("company_id", description="ID de la compañia", default=1),
 	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Material::with('company');

  		if ($request->has('company_id'))
  		{
  			$query->where('company_id', $request->company_id);
  		}
 if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        
  		$materials = $query->get();

  		return $this->response->collection($materials, new MaterialTransformer);
  	}


  public function index_export(Request $request)
    {
    $query = DB::table('materials')
                    ->select(
                      'materials.reimbursable', 'materials.detail',
                      'materials.amount', 'materials.cost',
                      'currencies.name AS currency_name',
                      DB::raw('"Material" as `Type`'))
                    ->join('currencies', 'currencies.id', '=', 'materials.currency_id');

        if ($request->has('company_id'))
      {
        $query->where('materials.company_id', $request->company_id);
      }
 if ($request->has('detail')) {
            $query->whereRaw('lower(`detail`) LIKE ?', $request->detail);
        }
        
    $materials = $query->get();
    return response()->json(array('data' => $materials));
    }

  	/**
	 * Crear
	 *
	 * @Post("materials")
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('company_id') || !$request->has('detail') || !$request->has('amount'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $material = Material::create($data);

        if ($material)
        {
        	return $this->response->item($material, new MaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener ciudad
	 *
	 * @Get("materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$material = Material::findOrFail($id);

  		return $this->response->item($material, new MaterialTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("materials/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"period_from": "date",
     *  		"period_to": "date",
     *  		"from": "date",
     *  		"to": "date",
     *  		"reimbursable": "int",
     *  		"responsable": "int",
     *  		"detail": "string",
     *  		"ticket_number": "string",
     *  		"ticket_image": "string",
     *  		"amount": "float",
     *  		"currency_id": "int",
     *  		"provider_id": "int",
     *  		"company_id": "int
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$material = Material::find($id);

  		if ($material == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $material->update($data);

        if ($material)
        {
        	return $this->response->item($material, new MaterialTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina
     *
     * @Delete("materials/{id}")
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
  		$material = Material::find($id);

        if ($material == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $material->delete();

        return $this->response->noContent();
  	}

  	/**
	 * Obtener
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("materials/datatables")
	 */
  	public function datatables(Request $request)
  	{
  		$query = DB::table('materials')
                    ->select(
                    	'materials.id', 'materials.reimbursable', 'materials.detail',
                    	'materials.amount', 'materials.cost',
                    	'materials.cost_currency_id', 'materials.currency_id',
                    	'materials.company_id',
                    	'currencies.name AS currency_name')
                    ->join('currencies', 'currencies.id', '=', 'materials.currency_id');

        if ($request->has('company_id'))
  		{
  			$query->where('materials.company_id', $request->company_id);
  		}

		$materials = $query->get();
  		return Datatables::of($materials)->make(true);
  	}

}

?>