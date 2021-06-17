<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model {

	protected $table = 'project_expenses';
	public $timestamps = true;
	protected $fillable = array('cost', 'amount', 'currency_id', 'project_id', 'detail', 'expense_id', 'reimbursable','frequency');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}