<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Email;

class EmailTransformer extends TransformerAbstract
{

    public function transform(Email $email)
    {
        return [
			'id'                         => $email->id,
			'title'                      => $email->title,
			'subject'                    => $email->subject,
			'body'                       => $email->body,
			'email_category_id' => $email->email_category_id,
			'user_id' => $email->user_id
        ];
    }
}
