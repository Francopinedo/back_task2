<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectExpense;

class ProjectExpenseTransformer extends TransformerAbstract
{

    public function transform(ProjectExpense $projectExpense)
    {
        return [
			'id'          => $projectExpense->id,
			'cost'        => $projectExpense->cost,
			'amount'        => $projectExpense->amount,
			'currency_id' => $projectExpense->currency_id,
			'project_id'  => $projectExpense->project_id,
			'detail'      => $projectExpense->detail,
			'expense_id'      => $projectExpense->expense_id,
			'reimbursable'      => $projectExpense->reimbursable,
			'frequency'      => $projectExpense->frequency,
        ];
    }
}