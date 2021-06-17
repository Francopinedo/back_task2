<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model {

	protected $table = 'stakeholders';
	public $timestamps = true;
	protected $fillable = array('influence', 'impacted', 'impact', 'expectations', 'contact_id');

	public function Contact()
	{
		return $this->belongsTo('App\Models\Contact');
	}

}