<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\City;

class CityTransformer extends TransformerAbstract
{

    public function transform(City $city)
    {
        return [
			'id'            => $city->id,
			'name'          => $city->name,
			'location_name' => $city->location_name,
			'country_id'    => $city->country_id,
			'company_id'    => $city->company_id,
			'timezone'      => $city->timezone
        ];
    }
}