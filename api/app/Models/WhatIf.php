<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatIf extends Model {

	protected $table = 'whatif';
	public $timestamps = true;
	protected $fillable = array(
		'project_id',
		'comment',
		'user_id',
	);
  public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}
	  public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}