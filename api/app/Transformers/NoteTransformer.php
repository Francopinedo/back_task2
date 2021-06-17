<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Note;

class NoteTransformer extends TransformerAbstract
{

    public function transform(Note $office)
    {
        return [
			'id'          => $office->id,
			'title'       => $office->title,
			'description' => $office->description,
			'user_id' => $office->user_id,
			'color'       => $office->color,
			'project_id'  => $office->project_id,
			'created_at'  => $office->created_at,
			'updated_at'  => $office->updated_at
        ];
    }
}
