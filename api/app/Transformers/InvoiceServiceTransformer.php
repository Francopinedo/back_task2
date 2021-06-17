<?php

namespace Transformers;

use App\Models\QuotationService;
use League\Fractal\TransformerAbstract;
use App\Models\InvoiceService;

class InvoiceServiceTransformer extends TransformerAbstract
{

    public function transform(InvoiceService $invoiceService)
    {
        return [
			'id'           => $invoiceService->id,
			'cost'         => $invoiceService->cost,
			'amount'         => $invoiceService->amount,
			'currency_id'  => $invoiceService->currency_id,
			'quotation_id'   => $invoiceService->quotation_id,
			'detail'       => $invoiceService->detail,
			'file'         => $invoiceService->file,
			'currency_name'         => $invoiceService->currency->code,
			'value'         => $invoiceService->value,
        ];
    }
}