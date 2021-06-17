<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Stakeholder;

class StakeholderTransformer extends TransformerAbstract
{

    public function transform(Stakeholder $stakeholder)
    {
        return [
			'id'          => $stakeholder->id,
			'influence'   => $stakeholder->influence,
			'impacted'    => $stakeholder->impacted,
			'impact'      => $stakeholder->impact,
			'expectations'=> $stakeholder->expectations,
			'contact_id'  => $stakeholder->contact_id
        ];
    }
}