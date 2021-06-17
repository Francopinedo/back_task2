<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wiki extends Model
{
    protected $table = 'wiki';
    public $timestamps = true;
    protected $fillable = array(
    	'customer_id', 
    	'project_id',
    	'user_id',
    	'process_group_code', 
    	'knowledge_code', 
    	'swot_code', 
    	'explanation', 
    	'action_taken', 
    	'additionals_comments', 
    	'attached_file');

    public function Customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    public function Project(){
        return $this->belongsTo('App\Models\Project');
    }

    public function User() {
    	return $this->belongsTo('app\Models\User');
    }
}
