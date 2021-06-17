<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskService;

class TaskServiceTransformer extends TransformerAbstract
{

    public function transform(TaskService $taskService)
    {
        return [
			'id'      => $taskService->id,
			'task_id' => $taskService->task_id,
			'detail'  => $taskService->detail,
			'cost'  => $taskService->cost,
			'amount'  => $taskService->amount,
			'reimbursable'  => $taskService->reimbursable,
			'quantity'  => $taskService->quantity,
			'currency_id'  => $taskService->currency_id,
        ];
    }
}