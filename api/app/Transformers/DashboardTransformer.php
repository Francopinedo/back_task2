<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Dashboard;

class DashboardTransformer extends TransformerAbstract
{

    public function transform(Dashboard $Dashboard)
    {
        return [
			'id'          => $Dashboard->id,
			'company_id'  => $Dashboard->company_id,
			'category'    => $Dashboard->category,
			'description' => $Dashboard->description,
			'graphic_type' => $Dashboard->graphic_type,
			'type_of_result' => $Dashboard->type_of_result,
			'kpi' => $Dashboard->kpi,
			'nombre' => $Dashboard->nombre,
			'showDashboard' => $Dashboard->showDashboard,
			'showdashboard'=> $Dashboard->showdashboard,
			'query'       => $Dashboard->query
        ];
    }
}
