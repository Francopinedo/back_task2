<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ActivityHistory;

class ActivityHistoryTransformer extends TransformerAbstract
{

    public function transform(ActivityHistory $activityHistory)
    {
        return [
			'id'          => $activityHistory->id,
			'agenda_id'   => $activityHistory->agenda_id,
			'date'        => $activityHistory->date,
			'description' => $activityHistory->description,
			'follower_id' => $activityHistory->follower_id,
			'due'         => $activityHistory->due
        ];
    }
}