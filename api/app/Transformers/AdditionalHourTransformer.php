<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AdditionalHour;
use App\Models\User;

class AdditionalHourTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'user'
    ];

    public function transform(AdditionalHour $additionalHour)
    {
        return [
			'id'         => $additionalHour->id,
			'project_id' => $additionalHour->project_id,
			'comments'   => $additionalHour->comments,
			'date'       => $additionalHour->date,
			'hours'      => $additionalHour->hours,
			'user_id'    => $additionalHour->user_id,
            'currency_id'     => $additionalHour->currency_id,
            'project_role_id' => $additionalHour->project_role_id,
            'seniority_id'    => $additionalHour->seniority_id,
            'rate'            => $additionalHour->rate,
            'workplace'       => $additionalHour->workplace,
            'contract_id'     => $additionalHour->contract_id,
            'office_id'     => $additionalHour->office_id,
            'country_id'     => $additionalHour->country_id,
            'city_id'     => $additionalHour->city_id,
			'rate_id'    => $additionalHour->rate_id
        ];
    }

    public function includeUser(AdditionalHour $additionalHour)
    {
    	if (empty($additionalHour->user))
    	{
    		$user = new User();
    	}
    	else{
    		$user = $additionalHour->user;
    	}

        return $this->item($user, new UserTransformer);
    }
}