<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeniorityTemplate extends Model {

	protected $table = 'seniority_templates';
	public $timestamps = true;
	protected $fillable = array('title');

}