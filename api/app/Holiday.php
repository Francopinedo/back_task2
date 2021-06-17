<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model {

	protected $table = 'holidays';
	public $timestamps = true;
	protected $fillable = array('date', 'description', 'country_id', 'company_id', 'added_by');

	public function country()
	{
		return $this->belongsTo('App\Countries');
	}

}