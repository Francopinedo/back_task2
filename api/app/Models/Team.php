<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {

	protected $table = 'teams';
	public $timestamps = true;
	protected $fillable = array('project_id', 'name');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}