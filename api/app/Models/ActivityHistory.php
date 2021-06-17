<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model {

	protected $table = 'activities_history';
	public $timestamps = true;
	protected $fillable = array('agenda_id', 'date', 'description', 'follower_id', 'due');

	public function Agenda()
	{
		return $this->belongsTo('App\Models\Agenda');
	}

	public function Follower()
	{
		return $this->belongsTo('App\Models\User', 'follower_id');
	}

}