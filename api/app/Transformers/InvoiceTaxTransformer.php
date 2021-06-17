<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceTax;

class InvoiceTaxTransformer extends TransformerAbstract
{

    public function transform(InvoiceTax $invoiceTax)
    {
        return [
			'id'          => $invoiceTax->id,
			'amount'      => $invoiceTax->amount,
			'percentage'      => $invoiceTax->percentage,
			'currency_id' => $invoiceTax->currency_id,
			'invoice_id'  => $invoiceTax->invoice_id,
			'name'        => $invoiceTax->name,
			'currency_name'        => $invoiceTax->currency->code,
			'value'        => $invoiceTax->value
        ];
    }
}