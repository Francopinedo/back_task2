<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContractExpense;

class ContractExpenseTransformer extends TransformerAbstract
{

    public function transform(ContractExpense $contractExpense)
    {
        return [
			'id'          => $contractExpense->id,
			'cost'        => $contractExpense->cost,
			'amount'        => $contractExpense->amount,
			'currency_id' => $contractExpense->currency_id,
			'contract_id' => $contractExpense->contract_id,
			'detail' => $contractExpense->detail,
			'expense_id'  => $contractExpense->expense_id,
			'reimbursable'=> $contractExpense->reimbursable,
			'frequency'=> $contractExpense->frequency,
        ];
    }
}