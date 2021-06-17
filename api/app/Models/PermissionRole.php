<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model {

	protected $table = 'permission_role';
	public $timestamps = true;
	protected $fillable = array('permission_id', 'role_id');

	public function permission()
	{
		return $this->belongsTo('App\Models\Permission');
	}
}