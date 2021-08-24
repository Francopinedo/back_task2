<?php

namespace App\Http\Controllers;

use DB;
use App\Currency;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Transformers\CurrencyTransformer;

/**
 * Modulo de monedas
 *
 * @Resource("Group Currency")
 */
class CurrencyController extends Controller {

  	/**
	 * Obtener monedas
	 *
	 * @Get("currencies")
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *  		"code": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
        $query = Currency::select('*');


        if($request->has('name')){
            $query = $query->where('name',$request->name);
        }
        if($request->has('code')){
            $query = $query->where('code',$request->code);
        }

        $currencies = $query->get();

  		return $this->response->collection($currencies, new CurrencyTransformer);
  	}

  	/**
	 * Crear pais
	 *
	 * @Post("currencies")
	 * @Request({
	 *      "name": "string",
	 *      "code": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear la moneda"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('code'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $currency = Currency::create($data);

        if ($currency)
        {
        	return $this->response->item($currency, new CurrencyTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear la moneda', 451);
    	}
  	}

  	/**
	 * Obtener monedas
	 *
	 * @Get("currencies/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID de la moneda", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$currency = Currency::findOrFail($id);

  		return $this->response->item($currency, new CurrencyTransformer);
  	}

  	/**
	 * Editar moneda
	 *
	 * @Patch("currencies/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID de la moneda", default=null),
	 * })
	 * @Request({
	 *      "name": "string",
	 *      "code": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"name": "string",
     *     		"code": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe la moneda"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar la moneda"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$currency = Currency::find($id);

  		if ($currency == NULL)
  		{
  			return $this->response->error('No existe la moneda', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $currency->update($data);

        if ($currency)
        {
        	return $this->response->item($currency, new CurrencyTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar la moneda', 451);
    	}
  	}

  	/**
     * Elimina una moneda
     *
     * @Delete("currencies/{id}")
     * @Parameters({
     *      @Parameter("id", type="integer", required=true, description="ID de la moneda.", default=null),
     * })
     * @Transaction({
     *   	@Response(204),
     *   	@Response(450, body={"error": {"message": "No existe la moneda"}})
     * })
     */
  	public function destroy($id)
  	{
  		$currency = Currency::find($id);

        if ($currency == NULL)
        {
        	return $this->response->error('No existe la moneda', 450);
        }

        $currency->delete();

        return $this->response->noContent();
  	}

    public function destroyAll()
    {
        $countries  = Currency::all();

        foreach ($countries  as $country){
            try{
                Currency::find($country->id)->delete();

            }catch (\Illuminate\Database\QueryException $e){

                //return $this->response->error('Error al eliminar', 450);
            }

        }


        return $this->response->noContent();
    }



    /**
	 * Obtener monedas
	 *
	 * Con formato listo para datatables con ajax
	 * @Get("currencies/datatables")
	 */
  	public function datatables()
  	{
  		$currencies = DB::table('currencies')
  			->select(
  				'currencies.id', 
  				'currencies.name', 
  				'currencies.code')
  			->get();

  		return Datatables::of($currencies)->make(true);
  	}

}

?>