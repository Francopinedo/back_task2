<?php

namespace Transformers;

use App\Models\QuotationMaterial;
use League\Fractal\TransformerAbstract;
use App\Models\InvoiceMaterial;

class QuotationMaterialTransformer extends TransformerAbstract
{

    public function transform(QuotationMaterial $invoiceMaterial)
    {
        return [
			'id'          => $invoiceMaterial->id,
			'cost'        => $invoiceMaterial->cost,
			'amount'        => $invoiceMaterial->amount,
			'amount_grouped'        => $invoiceMaterial->amount_grouped ,
			'currency_id' => $invoiceMaterial->currency_id,
			'quotation_id'  => $invoiceMaterial->quotation_id,
			'detail'      => $invoiceMaterial->detail,
			'file'        => $invoiceMaterial->file,
			'currency_name'        => $invoiceMaterial->currency->code,
			'value'        => $invoiceMaterial->value
        ];
    }
}