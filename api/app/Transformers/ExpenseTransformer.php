<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Expense;

class ExpenseTransformer extends TransformerAbstract
{

    public function transform(Expense $expense)
    {
        return [
			'id'               => $expense->id,
			'detail'           => $expense->detail,
			'amount'           => $expense->amount,
			'currency_id'      => $expense->currency_id,
			'reimbursable'     => $expense->reimbursable,
			'cost'             => $expense->cost,
			'cost_currency_id' => $expense->cost_currency_id,
			'company_id'       => $expense->company_id
        ];
    }
}