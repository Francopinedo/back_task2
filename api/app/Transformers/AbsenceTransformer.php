<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Absence;
use App\Models\User;

class AbsenceTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'user'
    ];

    public function transform(Absence $absence)
    {
        return [
			'id'              => $absence->id,
			'absence_type_id' => $absence->absence_type_id,
			'project_id'      => $absence->project_id,
			'comment'         => $absence->comment,
			'from'            => $absence->from,
			'to'              => $absence->to,
			'user_id'         => $absence->user_id,
			'company_id'         => $absence->company_id
        ];
    }

    public function includeUser(Absence $absence)
    {
    	if (empty($absence->user))
    	{
    		$user = new PermissionRole();
    	}
    	else{
    		$user = $absence->user;
    	}

        return $this->item($user, new UserTransformer);
    }
}