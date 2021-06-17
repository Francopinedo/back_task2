<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Agenda;

class AgendaTransformer extends TransformerAbstract
{

    public function transform(Agenda $agenda)
    {
        return [
			'id'             => $agenda->id,
			'company_id'     => $agenda->company_id,
			'project_id'     => $agenda->project_id,
			'knowledge_area' => $agenda->knowledge_area,
			'item_number'    => $agenda->item_number,
			'description'    => $agenda->description,
			'start'          => $agenda->start,
			'status'         => $agenda->status,
			'due'            => $agenda->due,
			'creator_id'     => $agenda->creator_id,
			'owner_id'       => $agenda->owner_id,
			'detail'         => $agenda->detail,
			'priority'         => $agenda->priority
        ];
    }
}