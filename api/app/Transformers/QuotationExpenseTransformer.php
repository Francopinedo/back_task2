<?php

namespace Transformers;

use App\Models\QuotationExpense;
use League\Fractal\TransformerAbstract;
use App\Models\InvoiceExpense;

class QuotationExpenseTransformer extends TransformerAbstract
{

    public function transform(QuotationExpense $invoiceExpense)
    {
        return [
			'id'           => $invoiceExpense->id,
			'cost'         => $invoiceExpense->cost,
			'amount'         => $invoiceExpense->amount,
			'currency_id'  => $invoiceExpense->currency_id,
			'quotation_id'   => $invoiceExpense->quotation_id,
			'detail'       => $invoiceExpense->detail,
			'file'         => $invoiceExpense->file,
			'currency_name'         => $invoiceExpense->currency->code,
			'value'         => $invoiceExpense->value,
        ];
    }
}