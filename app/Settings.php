<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

	protected $table = 'su_settings';

	protected $fillable = array('id','plugins_enabled', 'workflows_enabled', 'payment_enabled', 'wiki_enabled', 'mail_server_enable', 'mail_server_protocol', 'mail_server_encryption', 'mail_server_hosts', 'mail_server_port', 'mail_server_user', 'mail_server_pass', ' 	mail_server_from_email', 'chat_server_enable', 'chat_server_url','payment_integration','payment_gateway','digital_signature','cloud_storage','cloud_storage_provider','task_creation_email','fields_add_feature',
'alfred_active','field_captions','system_log','sox_audit_log','process_group_active','knowledge_areas_active'
);

	
}
