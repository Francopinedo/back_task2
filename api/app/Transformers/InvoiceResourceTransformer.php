<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\InvoiceResource;

class InvoiceResourceTransformer extends TransformerAbstract
{

    public function transform(InvoiceResource $invouiceResource)
    {

        //var_dump($invouiceResource);
        return [
			'id'              => $invouiceResource->id,
			'invoice_id'      => $invouiceResource->invoice_id,
			'user_name'      => $invouiceResource->user->name,
			'user_id'         => $invouiceResource->user_id,
			'currency_id'     => $invouiceResource->currency_id,
			'project_role_id' => $invouiceResource->project_role_id,
			'seniority_id'    => $invouiceResource->seniority_id,
			'project_role'    => $invouiceResource->projectrole->title,
			'seniority'    => $invouiceResource->seniority->title,
			'workplace'       => $invouiceResource->workplace,
			'load'            => $invouiceResource->load,
			'rate'            => $invouiceResource->rate,
			'rate_id'            => $invouiceResource->rate_id,
			'hours'           => $invouiceResource->hours,
			'type'            => $invouiceResource->type,
			'comments'        => $invouiceResource->comments,
			'office_id'        => $invouiceResource->office_id,
			'country_id'        => $invouiceResource->country_id,
			'city_id'        => $invouiceResource->city_id,
			'currency_name'        => $invouiceResource->currency->code,
			'value'        => $invouiceResource->value,
        ];
    }
}