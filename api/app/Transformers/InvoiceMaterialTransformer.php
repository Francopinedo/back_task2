<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceMaterial;

class InvoiceMaterialTransformer extends TransformerAbstract
{

    public function transform(InvoiceMaterial $invoiceMaterial)
    {
        return [
			'id'          => $invoiceMaterial->id,
			'cost'        => $invoiceMaterial->cost,
			'amount'        => $invoiceMaterial->amount,
			'currency_id' => $invoiceMaterial->currency_id,
			'invoice_id'  => $invoiceMaterial->invoice_id,
			'detail'      => $invoiceMaterial->detail,
			'file'        => $invoiceMaterial->file,
			'currency_name'        => $invoiceMaterial->currency->code,
			'value'        => $invoiceMaterial->value
        ];
    }
}