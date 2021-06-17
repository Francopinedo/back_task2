<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WhatIfTask;

use DateTime;
use DateInterval;
use DatePeriod;

class WhatIfTaskTransformer extends TransformerAbstract
{

    public function transform(WhatIfTask $WhatIfTask)
    {
    	$start = strtotime($WhatIfTask->start_date);
    	$end = strtotime($WhatIfTask->due_date);

  //   	$begin = new DateTime( $WhatIfTask->start_date );
		// $finish = new DateTime( $WhatIfTask->due_date );


		// $interval = DateInterval::createFromDateString('1 day');
		// $period = new DatePeriod($begin, $interval, $end);
		// $duration = round( ($end - $start) / 86400) - 1;

		// foreach ( $period as $dt )
		// {
		// 	if ($dt->format('N') == 6 || $dt->format('N') == 7)
		// 	{
		// 		print_r($dt);
		// 		// $duration = $duration - 1;
		// 	}
		// }
		// dd(1);

        return [

			'id'               => $WhatIfTask->id,
			'whatif_id'               => $WhatIfTask->whatif_id,
			'project_id'       => $WhatIfTask->project_id,
			'name'             => $WhatIfTask->description,
			'start_date'       => $WhatIfTask->start_date,
			'due_date'         =>$WhatIfTask->due_date,
			'start'            => $start * 1000,
			'end'              => $end * 1000,
			'duration'         => $WhatIfTask->duration,
			'requirement_id'   => $WhatIfTask->requirement_id,
			'startIsMilestone' => $WhatIfTask->start_is_milestone,
			'endIsMilestone'   => $WhatIfTask->end_is_milestone,
			'progress'         => $WhatIfTask->progress,
			'depends'          => $WhatIfTask->depends,
			'priority'         => $WhatIfTask->priority,
			'estimated_hours'  => $WhatIfTask->estimated_hours,
			'burned_hours'     => $WhatIfTask->burned_hours,
			'business_value'   => $WhatIfTask->business_value,
			'phase'            => $WhatIfTask->phase,
			'version'          => $WhatIfTask->version,
			'release'          => $WhatIfTask->release,
			'label'            => $WhatIfTask->label,
			'comments'         => $WhatIfTask->comments,
			'attachment'       => $WhatIfTask->attachment,
			'level'            => $WhatIfTask->level,
			'status'           => $WhatIfTask->status,
			'index'           => $WhatIfTask->index,

        ];
    }
}