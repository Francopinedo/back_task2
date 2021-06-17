<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\MetavariableKind;

class MetavariableKindTransformer extends TransformerAbstract
{

    public function transform(MetavariableKind $m)
    {
        return [
			'id'       => $m->id,
			'name_es'  => $m->name_es,
            'name_en'  => $m->name_en,
        ];
    }
}