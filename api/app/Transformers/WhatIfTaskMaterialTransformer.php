<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WhatIfTaskMaterial;

class WhatIfTaskMaterialTransformer extends TransformerAbstract
{

    public function transform(WhatIfTaskMaterial $WhatIfTaskMaterial)
    {
        return [
            'id'      => $WhatIfTaskMaterial->id,
            'whatif_task_id' => $WhatIfTaskMaterial->whatif_task_id,
            'detail'  => $WhatIfTaskMaterial->detail,
            'cost'  => $WhatIfTaskMaterial->cost,
            'amount'  => $WhatIfTaskMaterial->amount,
            'reimbursable'  => $WhatIfTaskMaterial->reimbursable,
            'quantity'  => $WhatIfTaskMaterial->quantity,
            'currency_id'  => $WhatIfTaskMaterial->currency_id,
        ];
    }
}