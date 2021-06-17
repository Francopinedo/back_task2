<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $table = 'roles';
	public $timestamps = true;
	protected $fillable = array('name', 'slug', 'company_role_id');

	public function PermissionRoles()
	{
		return $this->hasMany('App\Models\PermissionRole');
	}

    public function DirectoryRoles()
    {
        return $this->hasMany('App\Models\DirectoryRole');
    }
}