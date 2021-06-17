<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\EmailTemplate;

class EmailTemplateTransformer extends TransformerAbstract
{

    public function transform(EmailTemplate $emailTemplate)
    {
        return [
			'id'                         => $emailTemplate->id,
			'title'                      => $emailTemplate->title,
			'subject'                    => $emailTemplate->subject,
			'body'                       => $emailTemplate->body,
			'email_category_template_id' => $emailTemplate->email_category_template_id
        ];
    }
}