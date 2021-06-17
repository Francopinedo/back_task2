<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\CapacityPlanning;

class CapacityPlanningTransformer extends TransformerAbstract
{

    public function transform(CapacityPlanning $CapacityPlanning)
    {
        return [
			'user_id'            => $city->user_id,
			'id'            => $city->id,
			'name'          => $city->name,
			'project_id' => $city->project_id,
			'working_hours'    => $city->working_hours,
			'absents_hours'    => $city->absents_hours,
			'replacements_hours'      => $city->replacements_hours,
			'holidays_hours'    => $city->holidays_hours,
			'hours_available'    => $city->hours_available,
			'hours_asigned'      => $city->hours_asigned,
			'efective_capacity' => $city->efective_capacity,
        ];
    }
}