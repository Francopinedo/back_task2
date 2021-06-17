<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\DebitCredit;

class DebitCreditTransformer extends TransformerAbstract
{

    public function transform(DebitCredit $DebitCredit)
    {
        return [
        	'id'             => $DebitCredit->id,
	'company_id'             => $DebitCredit->company_id,
			'code' => $DebitCredit->code,
			'signs'        => $DebitCredit->signs,
			'currency_id'    => $DebitCredit->currency_id,
			'cost_currency_id'    => $DebitCredit->cost_currency_id,
			'quantity'          => $DebitCredit->quantity,
			'detail'        => $DebitCredit->detail,
			'amount'       => $DebitCredit->amount,
			'frequency'       => $DebitCredit->frequency,
			'cost'       => $DebitCredit->cost,
		
        ];
    }
}