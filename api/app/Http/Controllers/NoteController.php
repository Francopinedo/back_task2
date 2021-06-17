<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;

use App\Models\Note;
use Transformers\NoteTransformer;

/**
 * Modulo de Note
 *
 * @Resource("Group Note")
 */
class NoteController extends Controller {

  	/**
	 * Obtener
	 *
	 * @Get("notes{?project_id}")
	 * @Parameters({
	 *      @Parameter("project_id", type="integer", required=true, description="ID de un proyecto", default=null)
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function index(Request $request)
  	{
  		$query = Note::select('notes.id', 'notes.title', 'notes.description','notes.user_id', 'notes.color', 'notes.project_id', 'notes.created_at', 'notes.updated_at');

  		if ($request->has('user_id'))
  		{
  			$query->where('notes.user_id', $request->user_id);
  		}

  		$notes = $query->get();

  		return $this->response->collection($notes, new NoteTransformer);
  	}

  	/**
	 * Crear template de industria
	 *
	 * @Post("notes")
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "Faltan datos"}}),
	 *   	@Response(451, body={"error": {"message": "Error al crear"}})
	 * })
	 */
  	public function store(Request $request)
  	{
  		if (!$request->has('title'))
    	{
    		return $this->response->error('Faltan datos', 450);
    	}

    	$data = $request->all();

        $note = Note::create($data);

        if ($note)
        {
        	return $this->response->item($note, new NoteTransformer);
        }
        else
    	{
    		return $this->response->error('Error al crear', 451);
    	}
  	}

  	/**
	 * Obtener
	 *
	 * @Get("notes/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	})
	 * })
	 */
  	public function show($id)
  	{
  		$note = Note::findOrFail($id);

  		return $this->response->item($note, new NoteTransformer);
  	}

  	/**
	 * Editar
	 *
	 * @Patch("notes/{id}")
	 * @Parameters({
	 *      @Parameter("id", type="integer", required=true, description="ID", default=null),
	 * })
	 * @Request({
	 *      "title": "string"
	 * })
	 * @Transaction({
	 *   	@Response(200, body={
	 *   		"id": "int",
     *  		"title": "string"
	 *   	}),
	 *   	@Response(450, body={"error": {"message": "No existe"}}),
	 *   	@Response(451, body={"error": {"message": "Error al editar"}}),
	 *   	@Response(452, body={"error": {"message": "No envio ningun parametro para actualizar"}})
	 * })
	 */
  	public function update(Request $request, $id)
  	{
  		$note = Note::find($id);

  		if ($note == NULL)
  		{
  			return $this->response->error('No existe', 450);
  		}

  		$data = $request->all();

  		if (empty($data))
    	{
    		return $this->response->error('No envio ningun parametro para actualizar', 452);
    	}

        $note->update($data);

        if ($note)
        {
        	return $this->response->item($note, new NoteTransformer);
        }
        else
    	{
    		return $this->response->error('Error al editar', 451);
    	}
  	}

  	/**
     * Elimina un template de office
     *
     * @Delete("notes/{id}")
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
  		$note = Note::find($id);

        if ($note == NULL)
        {
        	return $this->response->error('No existe', 450);
        }

        $note->delete();

        return $this->response->noContent();
  	}

}

?>
