<?php

namespace Transformers;

use App\Models\DirectoryRole;
use League\Fractal\TransformerAbstract;
use App\Models\Role;
use App\Models\PermissionRole;

class RoleTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'permissionRoles',
        'directoryRoles'
    ];

    public function transform(Role $role)
    {
        return [
			'id'              => $role->id,
			'name'            => $role->name,
			'company_role_id' => $role->company_role_id
        ];
    }

    public function includePermissionRoles(Role $role)
    {
    	if (empty($role->permissionRoles))
    	{
    		$permissionRoles = new PermissionRole();
    	}
    	else{
    		$permissionRoles = $role->permissionRoles;
    	}

        return $this->collection($permissionRoles, new PermissionRoleTransformer);
    }

    public function includeDirectoryRoles(Role $role)
    {
        if (empty($role->directoryRoles))
        {
            $directoryRoles = new DirectoryRole();
        }
        else{
            $directoryRoles = $role->directoryRoles;
        }

        return $this->collection($directoryRoles, new DirectoryRoleRoleTransformer());
    }
}