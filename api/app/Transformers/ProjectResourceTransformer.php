<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectResource;

class ProjectResourceTransformer extends TransformerAbstract
{

    public function transform(ProjectResource $projectResource)
    {
        return [
			'id'              => $projectResource->id,
			'project_role_id' => $projectResource->project_role_id,
			'seniority_id'    => $projectResource->seniority_id,
			'rate_id'         => $projectResource->rate_id,
			'rate'            => $projectResource->rate,
			'currency_id'     => $projectResource->currency_id,
			'load'            => $projectResource->load,
			'workplace'       => $projectResource->workplace,
			'project_id'      => $projectResource->project_id,
			'comments'        => $projectResource->comments,
			'user_id'         => $projectResource->user_id,
			'type'         => $projectResource->type,
			'office_id'         => $projectResource->office_id,
			'country_id'         => $projectResource->country_id,
			'office_id'         => $projectResource->office_id,
			'city_id'         => $projectResource->city_id,

        ];
    }
}