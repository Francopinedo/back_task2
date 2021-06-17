<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectService;

class ProjectServiceTransformer extends TransformerAbstract
{

    public function transform(ProjectService $projectService)
    {
        return [
			'id'          => $projectService->id,
			'cost'        => $projectService->cost,
			'amount'        => $projectService->amount,
			'currency_id' => $projectService->currency_id,
			'project_id'  => $projectService->project_id,
			'detail'      => $projectService->detail,
			'service_id'      => $projectService->service_id,
			'reimbursable'      => $projectService->reimbursable,
			'frequency'      => $projectService->frequency,
        ];
    }
}