<?php

namespace Transformers;

use App\CityTemplate;
use League\Fractal\TransformerAbstract;
use App\City;

class CityTemplateTransformer extends TransformerAbstract
{

    public function transform(CityTemplate $city)
    {
        return [
			'id'            => $city->id,
			'name'          => $city->name,
			'location_name' => $city->location_name,
			'country_id'    => $city->country_id,
			'timezone'      => $city->timezone
        ];
    }
}