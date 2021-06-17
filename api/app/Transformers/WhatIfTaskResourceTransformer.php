<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WhatIfTaskResource;

class WhatIfTaskResourceTransformer extends TransformerAbstract
{

    public function transform(WhatIfTaskResource $WhatIfTaskResource)
    {
        return [
			'id'      => $WhatIfTaskResource->id,
			'whatif_task_id' => $WhatIfTaskResource->whatif_task_id,
			'user_id' => $WhatIfTaskResource->user_id,
			'rate' => $WhatIfTaskResource->rate,
			'quantity' => $WhatIfTaskResource->quantity,
			'currency_id' => $WhatIfTaskResource->currency_id,
			'project_role_id' => $WhatIfTaskResource->project_role_id,
			'seniority_id' => $WhatIfTaskResource->seniority_id,
			'name' => $WhatIfTaskResource->name,
        ];
    }
}