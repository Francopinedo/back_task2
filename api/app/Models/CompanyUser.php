<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyUser extends Model {

	protected $table = 'company_users';
	public $timestamps = true;
	protected $fillable = array('company_id', 'user_id');
}