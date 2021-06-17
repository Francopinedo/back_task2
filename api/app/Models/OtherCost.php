<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherCost extends Model {

	protected $table = 'other_costs';
	public $timestamps = true;
	protected $fillable = array('company_id', 'detail', 'value', 'currency_id', 'from', 'to');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Currency()
	{
		return $this->belongsTo('App\Currency');
	}

}