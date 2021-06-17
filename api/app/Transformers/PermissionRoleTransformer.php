<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\PermissionRole;
use App\Models\Permission;

class PermissionRoleTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'permission'
    ];

    public function transform(PermissionRole $permissionRole)
    {
        return [
			'id'            => $permissionRole->id,
			'permission_id' => $permissionRole->permission_id,
			'role_id'       => $permissionRole->role_id
        ];
    }

    public function includePermission(PermissionRole $permissionRole)
    {
    	if (empty($permissionRole->permission))
    	{
    		$permission = new Permission();
    	}
    	else
    	{
    		$permission = $permissionRole->permission;
    	}

        return $this->item($permission, new PermissionTransformer);
    }
}