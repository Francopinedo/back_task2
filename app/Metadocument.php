<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadocument extends Model
{
    protected $table = 'metadocuments';
	protected $fillable = ['language_id','activity_id','doctype_id','version','name','link_logo_left','link_logo_right','path_ref','document_id','code'];
}
