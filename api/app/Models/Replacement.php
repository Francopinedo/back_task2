<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Replacement extends Model {

	protected $table = 'replacements';
	public $timestamps = true;
	protected $fillable = array('absence_id', 'user_id', 'from', 'to', 'ticket', 'comment');

	public function Absence()
	{
		return $this->belongsTo('App\Absence');
	}

	public function User()
	{
		return $this->belongsTo('App\User');
	}

}