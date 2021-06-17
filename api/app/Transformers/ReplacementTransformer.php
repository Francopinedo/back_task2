<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Replacement;

class ReplacementTransformer extends TransformerAbstract
{

    public function transform(Replacement $replacement)
    {
        return [
			'id'         => $replacement->id,
			'absence_id' => $replacement->absence_id,
			'user_id'    => $replacement->user_id,
			'from'       => $replacement->from,
			'to'         => $replacement->to,
			'ticket'     => $replacement->ticket,
			'comment'    => $replacement->comment
        ];
    }
}