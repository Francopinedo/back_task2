<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Discount;

class DiscountTransformer extends TransformerAbstract
{

    public function transform(Discount $discount)
    {
        return [
			'id'               => $discount->id,
			'detail'           => $discount->detail,
			'amount'           => $discount->amount,
			'currency_id'      => $discount->currency_id,
			'company_id'       => $discount->company_id,
			'percentage'       => $discount->percentage
        ];
    }
}