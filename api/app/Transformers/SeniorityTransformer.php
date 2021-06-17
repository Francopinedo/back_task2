<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Seniority;

class SeniorityTransformer extends TransformerAbstract
{

    public function transform(Seniority $seniority)
    {
        return [
			'id'         => $seniority->id,
			'title'      => $seniority->title,
			'company_id' => $seniority->company_id
        ];
    }
}