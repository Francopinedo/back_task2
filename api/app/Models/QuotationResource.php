<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationResource extends Model
{

    protected $table = 'quotation_resources';
    public $timestamps = true;
    protected $fillable = array('quotation_id',
        'project_role_id',
        'seniority_id',
        'workplace', 'user_id', 'currency_id', 'load', 'rate', 'hours', 'type', 'comments',
        'rate_id', 'office_id', 'country_id', 'city_id', 'task_id');

    public function Currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function Quotation()
    {
        return $this->belongsTo('App\Models\Quotation');
    }

    public function User()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function ProjectRole()
    {
        return $this->belongsTo('App\ProjectRole');
    }

    public function Seniority()
    {
        return $this->belongsTo('App\Seniority');
    }
}