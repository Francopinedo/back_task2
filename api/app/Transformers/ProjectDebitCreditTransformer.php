<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProjectDebitCredit;

class ProjectDebitCreditTransformer extends TransformerAbstract
{

    public function transform(ProjectDebitCredit $DebitCredit)
    {
        return [
        	'id'             => $DebitCredit->id,
			'project_id'     => $DebitCredit->project_id,
			'date'         => $DebitCredit->date,
			'code' => $DebitCredit->code,
			'signs'        => $DebitCredit->signs,
			'currency_id'    => $DebitCredit->currency_id,
			'due_date'       => $DebitCredit->due_date,
			'quantity'          => $DebitCredit->quantity,
			'detail'        => $DebitCredit->detail,
			'amount'       => $DebitCredit->amount,
			'frequency'       => $DebitCredit->frequency,
			'cost'       => $DebitCredit->cost,
		
        ];
    }
}