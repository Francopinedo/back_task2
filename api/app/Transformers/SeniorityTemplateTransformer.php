<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\SeniorityTemplate;

class SeniorityTemplateTransformer extends TransformerAbstract
{

    public function transform(SeniorityTemplate $seniorityTemplate)
    {
        return [
			'id'    => $seniorityTemplate->id,
			'title' => $seniorityTemplate->title
        ];
    }
}