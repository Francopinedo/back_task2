<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Material;

class MaterialTransformer extends TransformerAbstract
{

    public function transform(Material $material)
    {
        return [
			'id'               => $material->id,
			'detail'           => $material->detail,
			'amount'           => $material->amount,
			'currency_id'      => $material->currency_id,
			'reimbursable'     => $material->reimbursable,
			'cost'             => $material->cost,
			'cost_currency_id' => $material->cost_currency_id,
			'company_id'       => $material->company_id
        ];
    }
}