<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotations extends Model {

	protected $table = 'quotations';
	public $timestamps = true;
	protected $fillable = array('project_id', 'customer_id');

	public function Project()
	{
		return $this->belongsTo('App\Models\Project');
	}

	public function Customer()
	{
		return $this->belongsTo('App\Customers');
	}

}