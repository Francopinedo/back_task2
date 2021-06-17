<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\CompanyRole;
use App\Models\Role;

class CompanyRoleTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'role'
    ];

    public function transform(CompanyRole $companyRole)
    {
        return [
			'id'         => $companyRole->id,
			'title'      => $companyRole->title,
			'company_id' => $companyRole->company_id
        ];
    }

    public function includeRole(CompanyRole $companyRole)
    {
    	if (empty($companyRole->role))
    	{
    		$role = new Role();
    	}
    	else{
    		$role = $companyRole->role;
    	}

        return $this->item($role, new RoleTransformer);
    }
}