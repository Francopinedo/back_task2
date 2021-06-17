<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Contact;

class ContactTransformer extends TransformerAbstract
{

    public function transform(Contact $contact)
    {
        return [
			'id'          => $contact->id,
			'company_id'  => $contact->company_id,
			'project_id'  => $contact->project_id,
			'name'        => $contact->name,
			'company'     => $contact->company,
			'department'  => $contact->department,
			'country_id'  => $contact->country_id,
			'city_id'     => $contact->city_id,
			'industry_id' => $contact->industry_id,
			'email'       => $contact->email,
			'phone'       => $contact->phone,
			'comments'    => $contact->comments,
'user_id'    => $contact->user_id
        ];
    }
}
