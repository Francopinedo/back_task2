<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industry extends Model {

	protected $table = 'industries';
	public $timestamps = true;
	protected $fillable = array('name');

}