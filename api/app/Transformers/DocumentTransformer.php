<?php

namespace Transformers;

use App\Models\Directory;
use App\Models\Document;
use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class DocumentTransformer extends TransformerAbstract
{

	public function transform(Document $wordDocument)
    {
        return [
			'id'   => $wordDocument->id,
			'nombre' => $wordDocument->path,
			'path' => $wordDocument->path
        ];
    }
}