<?php

namespace Transformers;

use App\Models\WhatIfTaskExpense;
use League\Fractal\TransformerAbstract;


class WhatIfTaskExpenseTransformer extends TransformerAbstract
{

    public function transform(WhatIfTaskExpense $WhatIfTaskExpense)
    {
        return [
			'id'      => $WhatIfTaskExpense->id,
			'whatif_task_id' => $WhatIfTaskExpense->whatif_task_id,
			'detail'  => $WhatIfTaskExpense->detail,
			'cost'  => $WhatIfTaskExpense->cost,
			'amount'  => $WhatIfTaskExpense->amount,
			'reimbursable'  => $WhatIfTaskExpense->reimbursable,
			'quantity'  => $WhatIfTaskExpense->quantity,
			'currency_id'  => $WhatIfTaskExpense->currency_id,
        ];
    }
}