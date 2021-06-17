<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskResource extends Model
{

    protected $table = 'task_resources';
    public $timestamps = true;
    protected $fillable = array('task_id',
        'user_id',
        'project_role_id',
        'rate',
        'quantity', //en realidad se refiere al numero de horas
        'currency_id',
        'seniority_id');
public function Task()
	{
		return $this->belongsTo('App\Models\Task','task_id','id');
	}
}