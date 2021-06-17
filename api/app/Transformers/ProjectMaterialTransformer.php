<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectMaterial;

class ProjectMaterialTransformer extends TransformerAbstract
{

    public function transform(ProjectMaterial $projectMaterial)
    {
        return [
			'id'          => $projectMaterial->id,
			'cost'        => $projectMaterial->cost,
			'amount'        => $projectMaterial->amount,
			'currency_id' => $projectMaterial->currency_id,
			'project_id'  => $projectMaterial->project_id,
			'detail'      => $projectMaterial->detail,
			'material_id'      => $projectMaterial->material_id,
			'frequency'      => $projectMaterial->frequency,
			'reimbursable'      => $projectMaterial->reimbursable
        ];
    }
}