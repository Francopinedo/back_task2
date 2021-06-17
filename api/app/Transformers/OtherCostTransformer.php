<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\OtherCost;

class OtherCostTransformer extends TransformerAbstract
{

    public function transform(OtherCost $otherCost)
    {
        return [
			'id'          => $otherCost->id,
			'detail'      => $otherCost->detail,
			'value'       => $otherCost->value,
			'currency_id' => $otherCost->currency_id,
			'from'        => $otherCost->from,
			'to'          => $otherCost->to,
			'company_id'  => $otherCost->company_id
        ];
    }
}