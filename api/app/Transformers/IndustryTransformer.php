<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Industry;

class IndustryTransformer extends TransformerAbstract
{

    public function transform(Industry $industry)
    {
        return [
			'id'            => $industry->id,
			'name'          => $industry->name
        ];
    }
}