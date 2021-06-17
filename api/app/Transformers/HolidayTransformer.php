<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Holiday;

class HolidayTransformer extends TransformerAbstract
{

    public function transform(Holiday $holiday)
    {
        return [
			'id'          => $holiday->id,
			'date'        => $holiday->date,
			'description' => $holiday->description,
            'country_id'  => $holiday->country_id,
            'company_id'  => $holiday->company_id,
			'added_by'    => $holiday->added_by
        ];
    }
}