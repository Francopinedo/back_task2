<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WhatIfTaskService;

class WhatIfTaskServiceTransformer extends TransformerAbstract
{

    public function transform(WhatIfTaskService $WhatIfTaskService)
    {
        return [
			'id'      => $WhatIfTaskService->id,
			'whatif_task_id' => $WhatIfTaskService->whatif_task_id,
			'detail'  => $WhatIfTaskService->detail,
			'cost'  => $WhatIfTaskService->cost,
			'amount'  => $WhatIfTaskService->amount,
			'reimbursable'  => $WhatIfTaskService->reimbursable,
			'quantity'  => $WhatIfTaskService->quantity,
			'currency_id'  => $WhatIfTaskService->currency_id,
        ];
    }
}