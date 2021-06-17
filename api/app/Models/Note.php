<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {

	protected $table = 'notes';
	public $timestamps = true;
	protected $fillable = array('project_id', 'title', 'description', 'color','user_id');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}
}
