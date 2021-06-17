<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceDiscount;

class InvoiceDiscountTransformer extends TransformerAbstract
{

    public function transform(InvoiceDiscount $invoiceDiscount)
    {
        return [
			'id'          => $invoiceDiscount->id,
			'amount'      => $invoiceDiscount->amount,
			'currency_id' => $invoiceDiscount->currency_id,
			'invoice_id'  => $invoiceDiscount->invoice_id,
			'name'        => $invoiceDiscount->name,
			'currency_name'        => $invoiceDiscount->currency->code,
			'value'        => $invoiceDiscount->value,
			'percentage'        => $invoiceDiscount->percentage,
        ];
    }
}