<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContractService;

class ContractServiceTransformer extends TransformerAbstract
{

    public function transform(ContractService $contractService)
    {
        return [
			'id'          => $contractService->id,
			'cost'        => $contractService->cost,
			'amount'        => $contractService->amount,
			'frequency'        => $contractService->frequency,
			'currency_id' => $contractService->currency_id,
			'contract_id' => $contractService->contract_id,
			'detail'      => $contractService->detail,
			'service_id'  => $contractService->service_id,
			'reimbursable'=> $contractService->reimbursable
        ];
    }
}