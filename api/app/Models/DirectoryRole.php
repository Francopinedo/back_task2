<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DirectoryRole extends Model {

	protected $table = 'directory_role';
	public $timestamps = true;
	protected $fillable = array('directory_id', 'role_id', 'read', 'write');

	public function directory()
	{
		return $this->belongsTo('App\Models\Directory');
	}
}