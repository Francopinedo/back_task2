<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayTemplate extends Model {

	protected $table = 'holidays_templates';
	public $timestamps = true;
	protected $fillable = array('date', 'description', 'country_id');

	public function country()
	{
		return $this->belongsTo('App\Countries');
	}

}