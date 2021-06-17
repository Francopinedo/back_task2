<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskResource;

class TaskResourceTransformer extends TransformerAbstract
{

    public function transform(TaskResource $taskResource)
    {
        return [
			'id'      => $taskResource->id,
			'task_id' => $taskResource->task_id,
			'user_id' => $taskResource->user_id,
			'rate' => $taskResource->rate,
			'quantity' => $taskResource->quantity,
			'currency_id' => $taskResource->currency_id,
			'project_role_id' => $taskResource->project_role_id,
			'seniority_id' => $taskResource->seniority_id,
			'name' => $taskResource->name,
        ];
    }
}