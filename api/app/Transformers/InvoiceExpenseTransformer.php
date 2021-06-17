<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceExpense;

class InvoiceExpenseTransformer extends TransformerAbstract
{

    public function transform(InvoiceExpense $invoiceExpense)
    {
        return [
			'id'           => $invoiceExpense->id,
			'cost'         => $invoiceExpense->cost,
			'amount'         => $invoiceExpense->amount,
			'currency_id'  => $invoiceExpense->currency_id,
			'invoice_id'   => $invoiceExpense->invoice_id,
			'detail'       => $invoiceExpense->detail,
			'file'         => $invoiceExpense->file,
			'currency_name'         => $invoiceExpense->currency->code,
			'value'         => $invoiceExpense->value,
        ];
    }
}