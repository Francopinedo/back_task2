<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metadocument extends Model 
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];
	protected $fillable = ['language_id','industry_id','doctype_id','code','version','name','link_logo_left','link_logo_right','path_ref','document_id'];

	public function language()
	{
		return $this->belongsTo('App\Language');
	}

	public function industry()
	{
		return $this->belongsTo('App\Industry');
	}

	public function doctype()
	{
		return $this->belongsTo('App\Doctype');
	}

}