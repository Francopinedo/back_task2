<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Metavariable;
use App\MetavariableKind;
use Transformers\MetavariableTransformer;
use Transformers\MetavariableKindTransformer;

/**
 * Módulo de Metadocumentos
 *
 * 
 */
class MetavariablesController extends Controller {

  	public function index($lang=NULL,$file=NULL)
  	{
		$query = Metavariable::select('metavariables.*','metavariable_kinds.name_en as metavariable_kind_name')
			->join('metadocuments','metadocuments.id','=','metavariables.metadocument_id')
			->join('metavariable_kinds','metavariable_kinds.id','=','metavariables.metavariable_kind_id');
		if ($file != NULL && $lang != NULL)
		{
			$query->join('languages','languages.id','=','metadocuments.language_id')
				->where('metadocuments.path_ref','=',$file)
				->where('languages.code','=',$lang);
		}
		else if ($lang != NULL)
		{
			$query->join('languages','languages.id','=','metadocuments.language_id')
				->where('languages.code','=',$lang);
		}
		else if ($file != NULL)
		{
			$query->where('metadocuments.path_ref','=',$file);
		}

		$query->whereNull('metadocuments.deleted_at');
		
  		$metavariables = $query->get();

  		return $this->response->collection($metavariables, new MetavariableTransformer);
	}

    public function store(Request $request)
  	{
  		if (!$request->has('name') || !$request->has('metadocument_id') || !$request->has('metavariable_kind_id'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();
        $metavariable = Metavariable::create($data);

        if ($metavariable)
        {
        	return $this->response->item($metavariable, new MetavariableTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}
    
    public function datatables(Request $request)
  	{ 
		$metavariables = Metavariable::join('metadocuments','metadocuments.id','=','metavariables.metadocument_id')
			->join('metavariable_kinds','metavariable_kinds.id','=','metavariables.metavariable_kind_id')
			->whereNull('metadocuments.deleted_at')
			->get(['metavariables.*','metavariable_kinds.name_en as metavariable_kind_name','metadocuments.name as metadocument_name']);

  		return Datatables::of($metavariables)->make(true);
	}
	
	public function show($id)
  	{
  		$metavariable = Metavariable::findOrFail($id);
  		return $this->response->item($metavariable, new MetavariableTransformer);
	}

	public function update(Request $request, $id)
  	{
  		$metavariable = Metavariable::find($id);

  		if ($metavariable == NULL || empty($metavariable))
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (count($data) == 0)
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $metavariable->update($data);

        if ($metavariable)
        {
        	return $this->response->item($metavariable, new MetavariableTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}
	  
	public function destroy($id)
  	{
  		$metavariable = Metavariable::find($id);

        if ($metavariable == NULL || empty($metavariable))
        {
        	return $this->response->error('No existe', 450);
        }

        $metavariable->delete();

        return $this->response->noContent();
	}
	  
	public function getMetavariableKinds()
  	{
        $query = MetavariableKind::select('*');
  		$metavariableKinds = $query->get();

  		return $this->response->collection($metavariableKinds, new MetavariableKindTransformer);
    }
}