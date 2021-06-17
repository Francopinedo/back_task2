<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Department;
use App\Office;

class DepartmentTransformer extends TransformerAbstract
{

	protected $availableIncludes = [
        'office'
    ];

    public function transform(Department $department)
    {
        return [
			'id'        => $department->id,
			'title'     => $department->title,
			'office_id' => $department->office_id
        ];
    }

    public function includeOffice(Department $department)
    {
    	if (empty($department->office))
    	{
    		$office = new Office();
    	}
    	else{
    		$office = $department->office;
    	}

        return $this->item($office, new OfficeTransformer);
    }
}