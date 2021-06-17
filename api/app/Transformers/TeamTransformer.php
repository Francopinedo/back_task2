<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Team;

class TeamTransformer extends TransformerAbstract
{

    public function transform(Team $team)
    {
        return [
			'id'         => $team->id,
			'project_id' => $team->project_id,
			'name'       => $team->name
        ];
    }
}