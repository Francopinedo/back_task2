<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Task;

use DateTime;
use DateInterval;
use DatePeriod;

class TaskTransformer extends TransformerAbstract
{

    public function transform(Task $task)
    {
    	$start = strtotime($task->start_date);
    	$end = strtotime($task->due_date);

  //   	$begin = new DateTime( $task->start_date );
		// $finish = new DateTime( $task->due_date );


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
			'id'               => $task->id,
			'project_id'       => $task->project_id,
			'name'             => $task->description,
			'start_date'       => $task->start_date,
			'due_date'         =>$task->due_date,
			'start'            => $start * 1000,
			'end'              => $end * 1000,
			'duration'         => $task->duration,
			'requirement_id'   => $task->requirement_id,
			'startIsMilestone' => $task->start_is_milestone,
			'endIsMilestone'   => $task->end_is_milestone,
			'progress'         => $task->progress,
			'depends'          => $task->depends,
			'priority'         => $task->priority,
			'estimated_hours'  => $task->estimated_hours,
			'burned_hours'     => $task->burned_hours,
			'business_value'   => $task->business_value,
			'phase'            => $task->phase,
			'version'          => $task->version,
			'release'          => $task->release,
			'label'            => $task->label,
			'comments'         => $task->comments,
			'attachment'       => $task->attachment,
			'level'            => $task->level,
			'status'           => $task->status,
			'index'           => $task->index,

        ];
    }
}