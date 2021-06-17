<?php


namespace App;
use Illuminate\Database\Eloquent\Model;

class IredmailMail extends Model
{
    protected $table = 'iredmail_mails';
    public $timestamps = true;
    protected $fillable = array('mail', 'iredmail_domain_id', 'user_id','secret');

    public function domain()
    {
        return $this->belongsTo('App\IredmailDomain');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
};

