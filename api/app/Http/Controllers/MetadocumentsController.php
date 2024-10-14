<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Metadocument;
use Transformers\MetadocumentTransformer;

/**
 * Módulo de Metadocumentos
 *
 * 
 */
class MetadocumentsController extends Controller {

  	public function index(Request $request)
  	{
        $query = Metadocument::select('*');
    /*
  		if ($request->has('country_id'))
  		{
  			$query->where('country_id', $request->country_id);
  		}

        if ($request->has('company_id'))
        {
            $query->where('company_id', $request->company_id);
        }
    */
  		$metadocu = $query->get();

  		return $this->response->collection($metadocu, new MetadocumentTransformer);
    }

    public function store(Request $request)
  	{
        if (!$request->has('name') || !$request->has('language_id') || !$request->has('doctype_id') || !$request->has('industry_id') || !$request->has('version'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();
        
        $metadocu = Metadocument::create($data);

        if ($metadocu)
        {
        	return $this->response->item($metadocu, new MetadocumentTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}
    
    public function datatables(Request $request)
  	{ 
        $metadocuments = Metadocument::join('doctypes', 'doctypes.id', '=', 'metadocuments.doctype_id')
            ->join('languages', 'languages.id', '=', 'metadocuments.language_id')
            ->join('industries', 'industries.id', '=', 'metadocuments.industry_id')
            ->get(['metadocuments.*', 'doctypes.type_desc as doctype_name', 'languages.name as language_name', 'industries.name as industry_name']);

  		return Datatables::of($metadocuments)->make(true);
	}
	
	public function show($id)
  	{
  		$metadocument = Metadocument::findOrFail($id);
  		return $this->response->item($metadocument, new MetadocumentTransformer);
	}

	public function update(Request $request, $id)
  	{
  		$metadocument = Metadocument::find($id);

  		if ($metadocument == NULL || empty($metadocument))
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $metadocument->update($data);

        if ($metadocument)
        {
        	return $this->response->item($metadocument, new MetadocumentTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}
	  
	public function destroy($id)
  	{
  		$metadocument = Metadocument::find($id);

        if ($metadocument == NULL || empty($metadocument))
        {
        	return $this->response->error('No existe', 450);
        }

        $metadocument->delete();

        return $this->response->noContent();
  	}
}