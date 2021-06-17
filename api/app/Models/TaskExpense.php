<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskExpense extends Model {

	protected $table = 'task_expenses';
	public $timestamps = true;
	protected $fillable = array('task_id', 'detail', 'cost', 'amount', 'reimbursable', 'quantity','currency_id');

public function Task()
	{
		return $this->belongsTo('App\Models\Task','task_id','id');
	}
}