<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Ticket;

class TicketTransformer extends TransformerAbstract
{

    public function transform(Ticket $ticket)
    {
        return [
			'id'              => $ticket->id,
			'task_id'         => $ticket->task_id,
			'description'     => $ticket->description,
			'type'            => $ticket->type,
			'assignee_id'     => $ticket->assignee_id,
			'status'          => $ticket->status,
			'group'           => $ticket->group,
			'last_updater_id' => $ticket->last_updater_id,
			'due_date'        => $ticket->due_date,
			'requester_name'  => $ticket->requester_name,
			'requester_email' => $ticket->requester_email,
			'requester_type'  => $ticket->requester_type,
			'priority'  => $ticket->priority,
			'severity'  => $ticket->severity,
			'probability'  => $ticket->probability,
			'impact'  => $ticket->impact,
			'milestone' => $ticket->milestone,
			'estimated_hours'  => $ticket->estimated_hours,
			'burned_hours'  => $ticket->burned_hours,
			'story_points'  => $ticket->story_points,
			'approval_date'  => $ticket->approval_date,
			'approver_name'  => $ticket->approver_name,
			'acceptance_criteria'  => $ticket->acceptance_criteria,
			'testing_criteria'  => $ticket->testing_criteria,
			'done_criteria'  => $ticket->done_criteria,
			'label'  => $ticket->label,
			'comment'  => $ticket->comment,
			'owner_id'  => $ticket->owner_id,
			'contingency_plan'  => $ticket->contingency_plan,
			'sprint_id'  => $ticket->sprint_id
        ];
    }
}
