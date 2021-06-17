<?php

namespace Transformers;

use App\Models\DashboardCategory;
use League\Fractal\TransformerAbstract;
use App\Models\Dashboard;

class DashboardCategoryTransformer extends TransformerAbstract
{

    public function transform(DashboardCategory $Dashboard)
    {
        return [
			'id'          => $Dashboard->id,
			'company_id'  => $Dashboard->company_id,
			'name'  => $Dashboard->name,
			'roles'  => empty($Dashboard->roles)?array():json_decode($Dashboard->roles),

        ];
    }
}