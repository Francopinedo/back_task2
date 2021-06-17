<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Metagrid;
use App\MetavariableKind;
use Transformers\MetagridTransformer;

/**
 * Módulo de Metadocumentos
 *
 * 
 */
class MetagridsController extends Controller {

  	public function index($lang=NULL,$file=NULL)
  	{
        $query = Metagrid::select('metagrids.*');

		if ($file != NULL && $lang != NULL)
		{
			$query->join('metadocuments','metadocuments.id','=','metagrids.metadocument_id')
				->join('languages','languages.id','=','metadocuments.language_id')
				->where('metadocuments.path_ref','=',$file)
				->where('languages.code','=',$lang);
		}
		else if ($lang != NULL)
		{
			$query->join('metadocuments','metadocuments.id','=','metagrids.metadocument_id')
				->join('languages','languages.id','=','metadocuments.language_id')
				->where('languages.code','=',$lang);
		}
		else if ($file != NULL)
		{
			$query->join('metadocuments','metadocuments.id','=','metagrids.metadocument_id')
				->where('metadocuments.path_ref','=',$file);
		}
		$query->whereNull('metadocuments.deleted_at');
  		$metagrids = $query->get();

  		return $this->response->collection($metagrids, new MetagridTransformer);
	}

    public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('metadocument_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();
        $metagrid = Metagrid::create($data);

        if ($metagrid)
        {
        	return $this->response->item($metagrid, new MetagridTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}
    
    public function datatables(Request $request)
  	{ 
		$metagrids = Metagrid::join('metadocuments','metadocuments.id','=','metagrids.metadocument_id')
				->whereNull('metadocuments.deleted_at')
				->get(['metagrids.*','metadocuments.name as metadocument_name']);

  		return Datatables::of($metagrids)->make(true);
	}
	
	public function show($id)
  	{
  		$metagrid = Metagrid::findOrFail($id);
  		return $this->response->item($metagrid, new MetagridTransformer);
	}

	public function update(Request $request, $id)
  	{
  		$metagrid = Metagrid::find($id);

  		if ($metagrid == NULL || empty($metagrid))
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (count($data) == 0)
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $metagrid->update($data);

        if ($metagrid)
        {
        	return $this->response->item($metagrid, new MetagridTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}
	  
	public function destroy($id)
  	{
  		$metagrid = Metagrid::find($id);

        if ($metagrid == NULL || empty($metagrid))
        {
        	return $this->response->error('No existe', 450);
        }

        $metagrid->delete();

        return $this->response->noContent();
	}
}