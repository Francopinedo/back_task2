<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Engagement;

class EngagementTransformer extends TransformerAbstract
{

    public function transform(Engagement $engagement)
    {
        return [
			'id'                => $engagement->id,
			'name'              => $engagement->name
        ];
    }
}