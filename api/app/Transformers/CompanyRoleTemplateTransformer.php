<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\CompanyRoleTemplate;

class CompanyRoleTemplateTransformer extends TransformerAbstract
{

    public function transform(CompanyRoleTemplate $companyRoleTemplate)
    {
        return [
			'id'    => $companyRoleTemplate->id,
			'title' => $companyRoleTemplate->title
        ];
    }
}