<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seniority extends Model {

	protected $table = 'seniorities';
	public $timestamps = true;
	protected $fillable = array('company_id', 'title');

	public function Company()
	{
		return $this->belongsTo('App\Company');
	}

}