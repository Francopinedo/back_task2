<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Currency;

class CurrencyTransformer extends TransformerAbstract
{

    public function transform(Currency $currency)
    {
        return [
			'id'   => $currency->id,
			'name' => $currency->name,
			'code' => $currency->code
        ];
    }
}