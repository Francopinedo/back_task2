<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Requirement;

class RequirementTransformer extends TransformerAbstract
{

    public function transform(Requirement $requirement)
    {
        return [
			'id'              => $requirement->id,
			'project_id'      => $requirement->project_id,
			'description'     => $requirement->description,
			'type'            => $requirement->type,
			'request_date'    => $requirement->request_date,
			'status_comment'  => $requirement->status_comment,
			'due_date'        => $requirement->due_date,
			'owner_id'        => $requirement->owner_id,
			'priority'        => $requirement->priority,
			'business_value'  => $requirement->business_value,
			'requester_name'  => $requirement->requester_name,
			'requester_email' => $requirement->requester_email,
			'requester_type'  => $requirement->requester_type,
			'approval_date'   => $requirement->approval_date,
			'approver_name'   => $requirement->approver_name,
			'comment'         => $requirement->comment
        ];
    }
}