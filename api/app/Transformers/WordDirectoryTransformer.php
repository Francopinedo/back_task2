<?php

namespace Transformers;

use App\Models\WordDirectory;
use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class WordDirectoryTransformer extends TransformerAbstract
{

	public function transform(WordDirectory $wordDirectory)
    {
        return [
			'id'   => $wordDirectory->id,
			'nombre' => $wordDirectory->nombre,
			'path' => $wordDirectory->path,
			'parent' => $wordDirectory->parent,
        ];
    }
}