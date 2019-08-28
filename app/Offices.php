<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offices extends Model {

	protected $table = 'offices';
	public $timestamps = true;
	protected $fillable = array('city_id', 'workinghours_from', 'workinghours_to');

	public function City()
	{
		return $this->belongsTo('App\Cities');
	}

}