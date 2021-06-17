<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectKpiAlert;

class ProjectKpiAlertTransformer extends TransformerAbstract
{

    public function transform(ProjectKpiAlert $projectKpiAlert)
    {
        return [
			'id'           => $projectKpiAlert->id,
			'kpi_id'       => $projectKpiAlert->kpi_id,
			'project_id'   => $projectKpiAlert->project_id,
			'red_alert'    => $projectKpiAlert->red_alert,
			'yellow_alert' => $projectKpiAlert->yellow_alert,
			'green_alert'  => $projectKpiAlert->green_alert
        ];
    }
}