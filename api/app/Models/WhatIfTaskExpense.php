<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatIfTaskExpense extends Model {

	protected $table = 'whatif_task_expenses';
	public $timestamps = true;
	protected $fillable = array('whatif_task_id', 'detail', 'cost', 'amount', 'reimbursable', 'quantity','currency_id');

public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}
	public function WhatIfTask()
	{
		return $this->belongsTo('App\Models\WhatIfTask');
	}
}