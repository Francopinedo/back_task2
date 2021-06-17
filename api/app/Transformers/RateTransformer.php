<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Rate;

class RateTransformer extends TransformerAbstract
{

    public function transform(Rate $rate)
    {
        return [
			'id'              => $rate->id,
			'country_id'      => $rate->country_id,
			'city_id'         => $rate->city_id,
			'project_role_id' => $rate->project_role_id,
			'seniority_id'    => $rate->seniority_id,
			'title'           => $rate->title,
			'value'           => $rate->value,
			'currency_id'     => $rate->currency_id,
			'workplace'       => $rate->workplace,
			'company_id'      => $rate->company_id,
			'office_id'      => $rate->office_id,
        ];
    }
}