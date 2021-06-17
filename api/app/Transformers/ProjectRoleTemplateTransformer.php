<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\ProjectRoleTemplate;

class ProjectRoleTemplateTransformer extends TransformerAbstract
{

    public function transform(ProjectRoleTemplate $projectRoleTemplate)
    {
        return [
			'id'    => $projectRoleTemplate->id,
			'title'  => $projectRoleTemplate->title
        ];
    }
}