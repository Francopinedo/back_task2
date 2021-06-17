<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Kpi;

class KpiTransformer extends TransformerAbstract
{

    public function transform(Kpi $kpi)
    {
        return [
			'id'          => $kpi->id,
			'company_id'  => $kpi->company_id,
			'category'    => $kpi->category,
			'description' => $kpi->description,
			'graphic_type' => $kpi->graphic_type,
			'type_of_result' => $kpi->type_of_result,
			'kpi' => $kpi->kpi,
			'nombre' => $kpi->nombre,
			'showkpi' => $kpi->showkpi,
			'showdashboard'=> $kpi->showdashboard,
			'query'       => $kpi->query
        ];
    }
}
