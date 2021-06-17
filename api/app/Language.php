<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	protected $table = 'languages';
	public $timestamps = true;
	protected $fillable = array('name', 'code');

}