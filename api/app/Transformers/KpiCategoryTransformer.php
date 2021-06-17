<?php

namespace Transformers;

use App\Models\KpiCategory;
use League\Fractal\TransformerAbstract;
use App\Models\Kpi;

class KpiCategoryTransformer extends TransformerAbstract
{

    public function transform(KpiCategory $kpi)
    {
        return [
			'id'          => $kpi->id,
			'company_id'  => $kpi->company_id,
			'name'  => $kpi->name,
			'roles'  => empty($kpi->roles)?array():json_decode($kpi->roles),

        ];
    }
}