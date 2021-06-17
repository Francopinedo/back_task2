<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engagement extends Model {

	protected $table = 'engagements';
	public $timestamps = true;
	protected $fillable = array('name');

}