<?php

namespace Transformers;

use App\Models\AbsenceTypeTemplate;
use League\Fractal\TransformerAbstract;


class AbsenceTypeTemplateTransformer extends TransformerAbstract
{

    public function transform(AbsenceTypeTemplate $absenceType)
    {
        return [
			'id'         => $absenceType->id,
			'country_id' => $absenceType->country_id,
			'city_id' => $absenceType->city_id,
			'title'      => $absenceType->title,
			'days'       => $absenceType->days
        ];
    }
}