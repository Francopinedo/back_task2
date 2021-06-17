<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model {

	protected $table = 'role_user';
	public $timestamps = true;

	protected $fillable = array('user_id', 'role_id');

}