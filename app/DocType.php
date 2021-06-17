<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocType extends Model
{
    protected $table = 'doctypes';
	protected $fillable = ['type_desc'];
}
