<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyRole extends Model {

	protected $table = 'company_roles';
	public $timestamps = true;
	protected $fillable = array('company_id', 'title');

	public function Company()
	{
		return $this->belongsTo('App\Models\Company');
	}

	public function Role()
	{
		return $this->hasOne('App\Models\Role');
	}

	public function PermissionRoles()
	{
		return $this->hasManyThrough('App\Models\PermissionRole', 'App\Models\Role');
	}

    public function DirectoryRoles()
    {
        return $this->hasManyThrough('App\Models\DirectoryRole', 'App\Models\Role');
    }

}