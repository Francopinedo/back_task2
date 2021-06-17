<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Office;
use App\Department;

class OfficeTransformer extends TransformerAbstract
{
	protected $availableIncludes = [
        'departments'
    ];

    public function transform(Office $office)
    {
        return [
			'id'           => $office->id,
			'title'        => $office->title,
			'company_id'   => $office->company_id,
			'city_id'   => $office->city_id,
			'workinghours_from'   => $office->workinghours_from,
			'workinghours_to'   => $office->workinghours_to,
			'hours_by_day' => $office->hours_by_day,
'effective_workinghours' => $office->effective_workinghours
        ];
    }

    public function includeDepartments(Office $office)
    {
    	if (empty($office->departments))
    	{
    		$departments = new Department();
    	}
    	else{
    		$departments = $office->departments;
    	}

        return $this->collection($departments, new DepartmentTransformer);
    }
}
