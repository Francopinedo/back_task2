<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Settings;
use Transformers\SettingsTransformer;

/**
 * Modulo de Settings
 *
 * @Resource("Group Settings")
 */
class SettingsController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("Settings")
	 
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"plugins_enabled": "int",
     *  		"workflows_enabled": "int",
     *  		"payments_enabled": "int",
     *  		"wiki_enabled": "int",
     *      "set": "int",
     *  		"mail_server_protocol": "string",
     *  		"mail_server_encryption": "string",
     *  		"mail_server_hosts": "string",
     *  		"mail_server_ports": "int",
     *  		"mail_server_user": "string",
     *  		"mail_server_pass": "string",
     *  		"mail_server_from_email": "string",
     *  		"chat_server_enable": "int",
     *  		"chat_server_url": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Settings::select('*');


  		$Settings = $query->get();

  		return $this->response->collection($Settings, new SettingsTransformer);
  	}

 
  	/**
	 * Editar
	 *
	 * @Patch("Settings")
	
	 * @Request({
  	 *   		"plugins_enabled": "int",
     *  		"workflows_enabled": "int",
     *  		"payments_enabled": "int",
     *  		"wiki_enabled": "int",
     *      "set": "int",
     *  		"mail_server_protocol": "string",
     *  		"mail_server_encryption": "string",
     *  		"mail_server_hosts": "string",
     *  		"mail_server_ports": "int",
     *  		"mail_server_user": "string",
     *  		"mail_server_pass": "string",
     *  		"mail_server_from_email": "string",
     *  		"chat_server_enable": "int",
     *  		"chat_server_url": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"plugins_enabled": "int",
     *  		"workflows_enabled": "int",
     *  		"payments_enabled": "int",
     *  		"wiki_enabled": "int",
     *      "set": "int"
     *  		"mail_server_protocol": "string",
     *  		"mail_server_encryption": "string",
     *  		"mail_server_hosts": "string",
     *  		"mail_server_ports": "int",
     *  		"mail_server_user": "string",
     *  		"mail_server_pass": "string",
     *  		"mail_server_from_email": "string",
     *  		"chat_server_enable": "int",
     *  		"chat_server_url": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$Settings =  Settings::find($id);

  		if ($Settings == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $Settings->update($data);

        if ($Settings)
        {
        	return $this->response->item($Settings, new SettingsTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}


  

}

?>
