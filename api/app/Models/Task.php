<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	protected $table = 'tasks';
	public $timestamps = true;
	protected $fillable = array(
		'project_id',
		'description',
		'requirement_id',
		'start_date',
		'due_date',
		'start_is_milestone',
		'end_is_milestone',
		'progress',
		'depends',
		'priority',
		'estimated_hours',
		'burned_hours',
		'business_value',
		'phase',
		'version',
		'release',
		'label',
		'comments',
		'attachment',
		'level',
		'duration',
		'index',
		'status',
		'hours_by_day'
	);

public function TaskExpense()
	{
		return $this->hasMany('App\Models\TaskExpense','task_id','id');
	}
public function TaskService()
	{
		return $this->hasMany('App\Models\TaskService','task_id','id');
	}
public function TaskMaterial()
	{
		return $this->hasMany('App\Models\TaskMaterial','task_id','id');
	}
	public function TaskResource()
	{
		return $this->hasMany('App\Models\TaskResource','task_id','id');
	}

	public function Tickets()
	{
		return $this->hasMany('App\Models\Ticket','task_id','id');
	}

}