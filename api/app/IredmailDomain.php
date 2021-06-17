<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

class IredmailDomain extends Model
{
    protected $table = 'iredmail_domains';
    public $timestamps = true;
    protected $fillable = array('domain', 'company_id');

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
    public function mails()
    {
        return $this->hasMany('App\IredmailMail','iredmail_domain_id');
    }
};