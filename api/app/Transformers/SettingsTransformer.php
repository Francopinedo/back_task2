<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Settings;

class SettingsTransformer extends TransformerAbstract
{

    public function transform(Settings $settings)
    {
        return [
			'id'               => $settings->id,
			'plugins_enabled'               => $settings->plugins_enabled,
			'workflows_enabled'               => $settings->workflows_enabled,
			'payments_enabled'               => $settings->payments_enabled,
			'wiki_enabled'               => $settings->wiki_enabled,
			'mail_server_enable'               => $settings->mail_server_enable,
			'mail_server_protocol'               => $settings->mail_server_protocol,
			'mail_server_encryption'               => $settings->mail_server_encryption,
			'mail_server_hosts'               => $settings->mail_server_hosts,	
			'mail_server_port'               => $settings->mail_server_port,	
			'mail_server_user'               => $settings->mail_server_user,	
			'mail_server_pass'               => $settings->mail_server_pass,	
			'mail_server_from_email'      => $settings->mail_server_from_email,
			'chat_server_enable'			 => $settings->chat_server_enable,
			'chat_server_url'			 => $settings->chat_server_url,
			'payment_integration'			 => $settings->payment_integration,
			'payment_gateway'			 => $settings->payment_gateway,
			'digital_signature'			 => $settings->digital_signature,
			'cloud_storage'			 => $settings->cloud_storage,
			'cloud_storage_provider'			 => $settings->cloud_storage_provider,
			'task_creation_email'			 => $settings->task_creation_email,
			'fields_add_feature'			 => $settings->fields_add_feature,
			'alfred_active'			 => $settings->alfred_active,
			'field_captions'			 => $settings->field_captions,
			'system_log'			 => $settings->system_log,
			'sox_audit_log'			 => $settings->sox_audit_log,
			'log_level'		=> empty($settings->log_level)? array() : json_decode($settings->log_level),
			'process_group_active'			 => $settings->process_group_active,
			'knowledge_areas_active'			 => $settings->knowledge_areas_active,
						'version'			 => $settings->version,
									'max_users'			 => $settings->max_users,


        ];
    }
}
