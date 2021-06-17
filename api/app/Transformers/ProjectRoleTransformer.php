<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\ProjectRole;

class ProjectRoleTransformer extends TransformerAbstract
{

    public function transform(ProjectRole $projectRole)
    {
        return [
			'id'         => $projectRole->id,
			'title'      => $projectRole->title,
			'company_id' => $projectRole->company_id
        ];
    }
}