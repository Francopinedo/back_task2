<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Service;

class ServiceTransformer extends TransformerAbstract
{

    public function transform(Service $service)
    {
        return [
			'id'               => $service->id,
			'detail'           => $service->detail,
			'amount'           => $service->amount,
			'currency_id'      => $service->currency_id,
			'reimbursable'     => $service->reimbursable,
			'cost'             => $service->cost,
			'cost_currency_id' => $service->cost_currency_id,
			'company_id'       => $service->company_id
        ];
    }
}