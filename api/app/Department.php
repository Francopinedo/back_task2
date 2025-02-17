<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

	protected $table = 'departments';
	public $timestamps = true;
	protected $fillable = array('title', 'office_id');

	public function office()
	{
		return $this->belongsTo('App\Office');
	}

}