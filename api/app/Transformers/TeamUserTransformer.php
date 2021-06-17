<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TeamUser;
use App\Models\User;

class TeamUserTransformer extends TransformerAbstract
{

    public function transform(TeamUser $teamUser)
    {
        return [
			'id'         => $teamUser->id,
			'project_id' => $teamUser->project_id,
			'user_id'    => $teamUser->user_id,
			'hours'    => $teamUser->hours,
			'load'    => $teamUser->load,
			'date_from'    => $teamUser->date_from,
			'date_to'    => $teamUser->date_to,
			'country_id'    => $teamUser->country_id,
			'city_id'    => $teamUser->city_id,
			'office_id'    => $teamUser->office_id,
			'workplace'    => $teamUser->workplace,
			'project_role_id'    => $teamUser->project_role_id,
			'seniority_id'    => $teamUser->seniority_id,
			'user_name'    => $teamUser->user->name
			
        ];
    }
}