<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Contract;

class ContractTransformer extends TransformerAbstract
{

    public function transform(Contract $contract)
    {
        return [
			'id'                  => $contract->id,
			'customer_id'         => $contract->customer_id,
			'project_id'          => $contract->project_id,
			'type_project'		  => $contract->type_project,
			'sow_number'          => $contract->sow_number,
			'amendment_number'    => $contract->amendment_number,
			'date'                => $contract->date,
			'start_date'          => $contract->start_date,
			'finish_date'         => $contract->finish_date,
			'currency_id'         => $contract->currency_id,
			'engagement_id'       => $contract->engagement_id,
			'service_description' => $contract->service_description,
			'workinghours_from'   => $contract->workinghours_from,
			'workinghours_to'     => $contract->workinghours_to
        ];
    }
}