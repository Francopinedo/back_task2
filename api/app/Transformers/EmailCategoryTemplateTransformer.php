<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\EmailCategoryTemplate;

class EmailCategoryTemplateTransformer extends TransformerAbstract
{

    public function transform(EmailCategoryTemplate $emailCategoryTemplate)
    {
        return [
			'id'    => $emailCategoryTemplate->id,
			'title' => $emailCategoryTemplate->title
        ];
    }
}