<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model {

	protected $table = 'absences';
	public $timestamps = true;
	protected $fillable = array('absence_type_id', 'project_id', 'comment', 'from', 'to', 'user_id','added_by');

	public function AbsenceType()
	{
		return $this->belongsTo('App\Models\AbsenceType');
	}

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function User()
	{
		return $this->belongsTo('App\Models\User');
	}

}