<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metadocument extends Model 
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['language_id','activity_id','doctype_id','code','version','name','link_logo_left','link_logo_right','path_ref','document_id'];

	public function language()
	{
		return $this->belongsTo('App\Language');
	}

	public function activity()
	{
		return $this->belongsTo('App\Activity');
	}

	public function doctype()
	{
		return $this->belongsTo('App\Doctype');
	}

}