<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model {

	protected $table = 'tickets';
	public $timestamps = true;
	protected $fillable = array(
							'task_id',
							'description',
							'type',
							'assignee_id',
							'status',
							'group',
							'last_updater_id',
							'due_date',
							'requester_name',
							'requester_email',
							'requester_type',
							'priority',
							'severity',
							'probability',
							'impact',
							'milestone',
							'estimated_hours',
							'burned_hours',
							'story_points',
							'approval_date',
							'approver_name',
							'testing_criteria',
							'done_criteria',
							'acceptance_criteria',
							'label',
							'comment',
							'owner_id',
							'contingency_plan',
							'sprint_id'
						);

	public function User()
	{
		return $this->belongsTo('App\User', 'assignee_id');
	}

	public function Sprint()
	{
		return $this->belongsTo('App\Sprints');
	}


}
