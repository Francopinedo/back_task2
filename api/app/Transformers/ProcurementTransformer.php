<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Procurement;

class ProcurementTransformer extends TransformerAbstract
{

    public function transform(Procurement $procurement)
    {
        return [
			'id'                 => $procurement->id,
			'project_id'         => $procurement->project_id,
			'type'               => $procurement->type,
			'date'               => $procurement->date,
			'description'        => $procurement->description,
			'RFPID'              => $procurement->RFPID,
			'ContractID'         => $procurement->ContractID,
			'specifications'     => $procurement->specifications,
			'approver_name'      => $procurement->approver_name,
			'responsable_id'        => $procurement->responsable_id,
			'due_date'           => $procurement->due_date,
			'cost'               => $procurement->cost,
			'cost_currency_id'      => $procurement->cost_currency_id,
			'quality_required'   => $procurement->quality_required,
			'contract_status'    => $procurement->contract_status,
			'provider_id'        => $procurement->provider_id,
			'provider_feedback'  => $procurement->provider_feedback,
			'delivery'           => $procurement->delivery,
			'quality'            => $procurement->quality,
			'overallscore'       => $procurement->overallscore,
			'requirement_status' => $procurement->requirement_status,
			'delivered_date'     => $procurement->delivered_date,
        ];
    }
}