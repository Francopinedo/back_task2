<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskMaterial extends Model {

	protected $table = 'task_materials';
	public $timestamps = true;
	protected $fillable = array('task_id', 'detail', 'cost', 'amount', 'reimbursable', 'quantity','currency_id');

	public function Task()
	{
		return $this->belongsTo('App\Models\Task','task_id','id');
	}

}