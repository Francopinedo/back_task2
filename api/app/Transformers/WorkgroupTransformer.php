<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Workgroup;

class WorkgroupTransformer extends TransformerAbstract
{

    public function transform(Workgroup $workgroup)
    {
        return [
			'id'         => $workgroup->id,
			'title'      => $workgroup->title,
			'company_id' => $workgroup->company_id,
            'chatchannel' => $workgroup->Chatroom
        ];
    }
}