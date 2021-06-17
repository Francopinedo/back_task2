<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContractResource;

class ContractResourceTransformer extends TransformerAbstract
{

    public function transform(ContractResource $contractResource)
    {
        return [
			'id'              => $contractResource->id,
			'project_role_id' => $contractResource->project_role_id,
			'seniority_id'    => $contractResource->seniority_id,
			'qty'             => $contractResource->qty,
			'rate_id'         => $contractResource->rate_id,
			'rate'            => $contractResource->rate,
			'currency_id'     => $contractResource->currency_id,
			'load'            => $contractResource->load,

			'workplace'       => $contractResource->workplace,
			'contract_id'     => $contractResource->contract_id,
			'office_id'     => $contractResource->office_id,
			'country_id'     => $contractResource->country_id,
			'city_id'     => $contractResource->city_id,
			'comments'        => $contractResource->comments
        ];
    }
}