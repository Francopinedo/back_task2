<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\HolidayTemplate;

class HolidayTemplateTransformer extends TransformerAbstract
{

    public function transform(HolidayTemplate $holidayTemplate)
    {
        return [
			'id'          => $holidayTemplate->id,
			'date'        => $holidayTemplate->date,
			'description' => $holidayTemplate->description,
			'country_id'  => $holidayTemplate->country_id
        ];
    }
}