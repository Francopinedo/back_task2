<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Sprints;

class SprintsTransformer extends TransformerAbstract
{

    public function transform(Sprints $Sprints)
    {
        return [
			'id'              => $Sprints->id,
			'customer_id'         => $Sprints->customer_id,
			'project_id'     => $Sprints->project_id,
			'short_name'            => $Sprints->short_name,
'start_date'            => $Sprints->start_date,
'finish_date'            => $Sprints->finish_date,
			'long_name'     => $Sprints->long_name,
			'Duration'  => $Sprints->Duration,
			'version'  => $Sprints->version,
			'release'  => $Sprints->release,
			'milestone'          => $Sprints->milestone,
			'NumberOfChangesRequired'           => $Sprints->NumberOfChangesRequired,
			'NumberOfChangesResolved'          => $Sprints->NumberOfChangesResolved,
			'time_status' => $Sprints->time_status,
			'task_status'        => $Sprints->task_status,
			'active'  => $Sprints->active
			
			
			
        ];
    }
}
