<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

	protected $table = 'countries';
	public $timestamps = true;
	protected $fillable = array('name', 'code','language_id', 'currency_id', 'workinghours_from', 'workinghours_to');

	public function language()
	{
		return $this->belongsTo('App\Languages');
	}

	public function currency()
	{
		return $this->belongsTo('App\Currency');
	}

}