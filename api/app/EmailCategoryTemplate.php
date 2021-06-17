<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailCategoryTemplate extends Model {

	protected $table = 'email_category_templates';
	public $timestamps = true;
	protected $fillable = array('title');
}