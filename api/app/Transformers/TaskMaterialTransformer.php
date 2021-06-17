<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TaskMaterial;

class TaskMaterialTransformer extends TransformerAbstract
{

    public function transform(TaskMaterial $TaskMaterial)
    {
        return [
            'id'      => $TaskMaterial->id,
            'task_id' => $TaskMaterial->task_id,
            'detail'  => $TaskMaterial->detail,
            'cost'  => $TaskMaterial->cost,
            'amount'  => $TaskMaterial->amount,
            'reimbursable'  => $TaskMaterial->reimbursable,
            'quantity'  => $TaskMaterial->quantity,
            'currency_id'  => $TaskMaterial->currency_id,
        ];
    }
}