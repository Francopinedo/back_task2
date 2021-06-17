<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\TicketHistory;

class TicketHistoryTransformer extends TransformerAbstract
{

    public function transform(TicketHistory $ticketHistory)
    {
        return [
			'id'                   => $ticketHistory->id,
			'ticket_id'            => $ticketHistory->ticket_id,
			'date'                 => $ticketHistory->date,
			'owner_id'             => $ticketHistory->owner_id,
			'internal_or_external' => $ticketHistory->internal_or_external,
			'comment'              => $ticketHistory->comment
        ];
    }
}