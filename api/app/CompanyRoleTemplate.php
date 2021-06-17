<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyRoleTemplate extends Model {

	protected $table = 'company_role_templates';
	public $timestamps = true;
	protected $fillable = array('title');
}