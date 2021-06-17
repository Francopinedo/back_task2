<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Email;
use App\EmailCategory;

class EmailCategoryTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'emails'
    ];

    public function transform(EmailCategory $emailCategory)
    {
        return [
			'id'    => $emailCategory->id,
			'title' => $emailCategory->title,
			'user_id' => $emailCategory->user_id
        ];
    }

    public function includeEmails(EmailCategory $emailCategory)
    {
    	if (empty($emailCategory->emails))
    	{
    		$emails = new Department();
    	}
    	else{
    		$emails = $emailCategory->emails;
    	}

        return $this->collection($emails, new EmailTransformer);
    }
}
