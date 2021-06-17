<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceDebitCredit;

class InvoiceDebitCreditTransformer extends TransformerAbstract
{

    public function transform(InvoiceDebitCredit $InvoiceDebitCredit)
    {
        return [
			'id'          => $InvoiceDebitCredit->id,
			'cost'        => $InvoiceDebitCredit->cost,
			'amount'        => $InvoiceDebitCredit->amount,
			'currency_id' => $InvoiceDebitCredit->currency_id,
			'invoice_id'  => $InvoiceDebitCredit->invoice_id,
			'detail'      => $InvoiceDebitCredit->detail,
			'file'        => $InvoiceDebitCredit->file,
			'currency_name'        => $InvoiceDebitCredit->currency->code,
			'value'        => $InvoiceDebitCredit->value,
			'signs'        => $InvoiceDebitCredit->signs
        ];
    }
}