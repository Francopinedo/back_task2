<?php

namespace Transformers;

use App\Models\TaskExpense;
use League\Fractal\TransformerAbstract;


class TaskExpenseTransformer extends TransformerAbstract
{

    public function transform(TaskExpense $taskExpense)
    {
        return [
			'id'      => $taskExpense->id,
			'task_id' => $taskExpense->task_id,
			'detail'  => $taskExpense->detail,
			'cost'  => $taskExpense->cost,
			'amount'  => $taskExpense->amount,
			'reimbursable'  => $taskExpense->reimbursable,
			'quantity'  => $taskExpense->quantity,
			'currency_id'  => $taskExpense->currency_id,
        ];
    }
}