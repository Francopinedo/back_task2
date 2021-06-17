<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model {

	protected $table = 'email_templates';
	public $timestamps = true;
	protected $fillable = array('title', 'subject', 'body', 'email_category_template_id');

}