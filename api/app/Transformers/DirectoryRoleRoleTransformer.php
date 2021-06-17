<?php

namespace Transformers;

use App\Models\DirectoryRole;
use League\Fractal\TransformerAbstract;
use App\Models\PermissionRole;
use App\Models\Permission;

class DirectoryRoleRoleTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'directory'
    ];

    public function transform(DirectoryRole $directoryRole)
    {
        return [
			'id'            => $directoryRole->id,
			'directory_id' => $directoryRole->directory_id,
			'read' => $directoryRole->read,
			'write' => $directoryRole->write,
			'role_id'       => $directoryRole->role_id
        ];
    }

    public function includeDirectory(DirectoryRole $directoryRole)
    {
    	if (empty($directoryRole->directory))
    	{
    		$directory = new Directory();
    	}
    	else
    	{
            $directory = $directoryRole->directory;
    	}

        return $this->item($directory, new DirectoryTransformer());
    }
}