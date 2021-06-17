<?php

namespace Transformers;

use App\Models\Directory;
use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class DirectoryTransformer extends TransformerAbstract
{

	public function transform(Directory $wordDirectory)
    {
        return [
			'id'   => $wordDirectory->id,
			'nombre' => $wordDirectory->nombre,
			'path' => $wordDirectory->path,
			'parent' => $wordDirectory->parent,
        ];
    }
}