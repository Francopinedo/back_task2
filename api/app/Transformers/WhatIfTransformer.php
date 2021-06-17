<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WhatIf;

class WhatIfTransformer extends TransformerAbstract
{

    public function transform(WhatIf $WhatIf)
    {
        return [
            'id'      => $WhatIf->id,
           'project_id' => $WhatIf->project_id,
        'comment' => $WhatIf->comment,
        'user_id' => $WhatIf->user_id,
        ];
    }
}