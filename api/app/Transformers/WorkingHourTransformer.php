<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WorkingHour;
use App\Models\User;

class WorkingHourTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'user'
    ];

    public function transform(WorkingHour $workingHour)
    {
        return [
			'id'         => $workingHour->id,
			'project_id' => $workingHour->project_id,
			'sprint_id' => $workingHour->sprint_id,
			'date'       => $workingHour->date,
			'hours'      => $workingHour->hours,
			'user_id'    => $workingHour->user_id
        ];
    }

    public function includeUser(AdditionalHour $workingHour)
    {
    	if (empty($workingHour->user))
    	{
    		$user = new User();
    	}
    	else{
    		$user = $workingHour->user;
    	}

        return $this->item($user, new UserTransformer);
    }
}
