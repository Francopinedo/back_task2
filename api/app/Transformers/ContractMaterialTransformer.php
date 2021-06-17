<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContractMaterial;

class ContractMaterialTransformer extends TransformerAbstract
{

    public function transform(ContractMaterial $contractMaterial)
    {
        return [
			'id'          => $contractMaterial->id,
			'cost'        => $contractMaterial->cost,
			'amount'        => $contractMaterial->amount,
			'currency_id' => $contractMaterial->currency_id,
			'contract_id' => $contractMaterial->contract_id,
			'detail' => $contractMaterial->detail,
			'frequency' => $contractMaterial->frequency,
			'material_id'  => $contractMaterial->material_id,
			'reimbursable'=> $contractMaterial->reimbursable
        ];
    }
}