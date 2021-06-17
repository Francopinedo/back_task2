<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model {

	protected $table = 'emails';
	public $timestamps = true;
	protected $fillable = array('title', 'subject', 'body', 'email_category_id','added_by','user_id');

}
