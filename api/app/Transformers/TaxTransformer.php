<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Tax;

class TaxTransformer extends TransformerAbstract
{

    public function transform(Tax $tax)
    {
        return [
			'id'          => $tax->id,
			'detail'      => $tax->detail,
			'country_id'  => $tax->country_id,
			'percentage'  => $tax->percentage,
			'value'       => $tax->value,
			'company_id'  => $tax->company_id,
			'currency_id' => $tax->currency_id
        ];
    }
}