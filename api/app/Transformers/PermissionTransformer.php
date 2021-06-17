<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Permission;

class PermissionTransformer extends TransformerAbstract
{

	public function transform(Permission $permission)
    {
        return [
			'id'   => $permission->id,
			'name' => $permission->name,
			'slug' => $permission->slug
        ];
    }
}