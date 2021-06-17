<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctype extends Model 
{
	protected $table = 'doctypes';
	protected $fillable = array('type_desc');
}