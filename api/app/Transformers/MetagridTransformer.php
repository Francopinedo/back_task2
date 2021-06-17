<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Metagrid;

class MetagridTransformer extends TransformerAbstract
{

    public function transform(Metagrid $m)
    {
        return [
            'id'                    => $m->id,
            'name'                  => $m->name,
            'caption'               => $m->caption,
            'metadocument_id'       => $m->metadocument_id,
        ];
    }
}