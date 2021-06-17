<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AbsenceType;

class AbsenceTypeTransformer extends TransformerAbstract
{

    public function transform(AbsenceType $absenceType)
    {
        return [
			'id'         => $absenceType->id,
			'country_id' => $absenceType->country_id,
			'city_id' => $absenceType->city_id,
			'company_id' => $absenceType->company_id,
			'title'      => $absenceType->title,
			'days'       => $absenceType->days
        ];
    }
}