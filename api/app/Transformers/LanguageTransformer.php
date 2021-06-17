<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Language;

class LanguageTransformer extends TransformerAbstract
{

    public function transform(Language $language)
    {
        return [
			'id'   => $language->id,
			'name' => $language->name,
			'code' => $language->code
        ];
    }
}