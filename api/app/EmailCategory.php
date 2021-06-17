<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCategory extends Model {

	protected $table = 'email_categories';
	public $timestamps = true;
	protected $fillable = array('title', 'company_id','added_by','user_id');

	public function emails()
	{
		return $this->hasMany('App\Email');
	}
}
