<?php
	namespace App\Http\Controllers;

	use DB;
	use App\Models\Timezone;
	use Illuminate\Http\Request;
	use Yajra\Datatables\Datatables;
	use Transformers\TimezoneTransformer;

	/**
	 * Modulo de Auditlog
	 *
	 * @Resource("Group Auditlog")
	 */
	class TimezoneController extends Controller {

	  	/**
		 * Obtener
		 *
		 * @Get("Timezone")
		 * @Transaction({
		 *   	@Response(200, body={
		 *   		"id": "int",
		 * 			"timezone": 'string'
		 *   	})
		 * })
		 */
	  	public function index(Request $request)
	  	{
	  		$query = Timezone::select('timezones.*');

	  		$timezone = $query->get();

	  		return $this->response->collection($timezone, new TimezoneTransformer);
	  	}


	  	/**
		 * Obtener
		 *
		 * Con formato listo para datatables con ajax
		 * @Get("Timezones/datatables")
		 */
	  	public function datatables(Request $request)
	  	{
	  		$query = DB::table('timezones')
	  			->select(
					'timezones.id',
					'timezones.timezone');

			$Timezones = $query->get();

	  		return Datatables::of($Timezones)->make(true);
	  	}

	}

?>
