<?php

namespace Transformers;


use App\Models\Quotation;
use League\Fractal\TransformerAbstract;
use App\Models\Invoice;

class QuotationTransformer extends TransformerAbstract
{

    public function transform(Quotation $invoice)
    {
        return [
        	'id'             => $invoice->id,
			'project_id'     => $invoice->project_id,
			'number'         => $invoice->number,

			'concept'        => $invoice->concept,
			'date'        => $invoice->created_at,
			'from'           => $invoice->from,
			'to'             => $invoice->to,
			'contact_id'     => $invoice->contact_id,
			'currency_id'    => $invoice->currency_id,
			'due_date'       => $invoice->due_date,
			'total'          => $invoice->total,
			'bill_to'        => $invoice->bill_to,
			'remit_to'       => $invoice->remit_to,
			'emited'       => $invoice->emited,
			'comments'       => $invoice->comments,
        ];
    }
}