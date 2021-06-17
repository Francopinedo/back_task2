<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model {

	protected $table = 'taxes';
	public $timestamps = true;
	protected $fillable = array('detail', 'country_id', 'percentage', 'value', 'company_id', 'currency_id');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Country()
	{
		return $this->belongsTo('App\Countries');
	}

}