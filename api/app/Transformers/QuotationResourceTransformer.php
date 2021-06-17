<?php

namespace Transformers;

use App\Models\QuotationResource;
use League\Fractal\TransformerAbstract;


class QuotationResourceTransformer extends TransformerAbstract
{

    public function transform(QuotationResource $quotationResource)
    {

        //var_dump($invouiceResource);
        return [
			'id'              => $quotationResource->id,
			'quotation_id'      => $quotationResource->quotation_id,
			'user_name'      => $quotationResource->user->name,
			'user_id'         => $quotationResource->user_id,
			'currency_id'     => $quotationResource->currency_id,
			'project_role_id' => $quotationResource->project_role_id,
			'seniority_id'    => $quotationResource->seniority_id,
			'project_role'    => $quotationResource->projectrole->title,
			'seniority'    => $quotationResource->seniority->title,
			'workplace'       => $quotationResource->workplace,
			'load'            => $quotationResource->load,
			'rate'            => $quotationResource->rate,
			'rate_id'            => $quotationResource->rate_id,
			'hours'           => $quotationResource->hours,
			'type'            => $quotationResource->type,
			'comments'        => $quotationResource->comments,
			'office_id'        => $quotationResource->office_id,
			'country_id'        => $quotationResource->country_id,
			'city_id'        => $quotationResource->city_id,
			'task_id'        => $quotationResource->task_id,
			'currency_name'        => $quotationResource->currency->code,
			'value'        => $quotationResource->value,
        ];
    }
}