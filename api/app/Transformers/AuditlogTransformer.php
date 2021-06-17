<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Auditlog;

class AuditlogTransformer extends TransformerAbstract
{

    public function transform(Auditlog $Auditlog)
    {
        return [
			'id'             => $Auditlog->id,
			'customer_id'     => $Auditlog->customer_id,
			'project_id'     => $Auditlog->project_id,
			'date_action' => $Auditlog->date_action,
			'process_name'    => $Auditlog->process_name,
			'action_name'    => $Auditlog->action_name,
			'user_id'          => $Auditlog->user_id,
			'user_name'          => $Auditlog->user_name,
			'user_comment'         => $Auditlog->user_comment,
			'reason'            => $Auditlog->reason,
			'business_rule'     => $Auditlog->business_rule,
			'role'       => $Auditlog->role,
			'action'       => $Auditlog->action,
			'table_name'       => $Auditlog->table_name,
			'field'         => $Auditlog->field
        ];
    }
}
