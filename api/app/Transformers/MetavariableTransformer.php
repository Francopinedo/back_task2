<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Metavariable;

class MetavariableTransformer extends TransformerAbstract
{

    public function transform(Metavariable $m)
    {
        return [
			'id'                    => $m->id,
           'metavariable_kind_id'  => $m->metavariable_kind_id,
            'metavariable_kind_name'=> $m->metavariable_kind_name,
            'metadocument_name'     => $m->metadocument_name,
            'name'                  => $m->name,
            'caption'               => $m->caption,
            'dependencies'          => $m->dependencies,
            'metadocument_id'       => $m->metadocument_id,
                         'width'                 => $m->width,
        ];
    }
}