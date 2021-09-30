<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Country;

class CountryTransformer extends TransformerAbstract
{

    public function transform(Country $country)
    {
        return [
			'id'                => $country->id,
			'name'              => $country->name,
			'language_id'       => $country->language_id,
			'code'       => $country->code,
			'currency_id'       => $country->currency_id,
			'mask_phone' => $country->mask_phone,
        ];
    }
}