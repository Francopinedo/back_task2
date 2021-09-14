<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Metadocument;

class MetadocumentTransformer extends TransformerAbstract
{

    public function transform(Metadocument $m)
    {
        return [
			'id'              => $m->id,
			'name'            => $m->name,
            'language_id'     => $m->language_id,
            'doctype_id'      => $m->doctype_id,
            'industry_id'     => $m->industry_id,
            'code'            => $m->code,
            'version'         => $m->version,
            'link_logo_left'  => $m->link_logo_left,
            'link_logo_right' => $m->link_logo_right,
            'path_ref'        => $m->path_ref,
            'document_id'     => $m->document_id
        ];
    }
}