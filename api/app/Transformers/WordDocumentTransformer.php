<?php

namespace Transformers;

use App\Models\WordDirectory;
use App\Models\WordDocument;
use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class WordDocumentTransformer extends TransformerAbstract
{

	public function transform(WordDocument $wordDocument)
    {
        return [
			'id'   => $wordDocument->id,
			'nombre' => $wordDocument->path,
			'path' => $wordDocument->path
        ];
    }
}