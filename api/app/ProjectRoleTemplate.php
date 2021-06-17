<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectRoleTemplate extends Model {

	protected $table = 'project_role_templates';
	public $timestamps = true;
	protected $fillable = array('title');
}