<?php

use Illuminate\Database\Seeder;

class SuSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('su_settings')->truncate();
        DB::table('su_settings')->insert([
            'plugins_enabled' => 0,
            'workflows_enabled' => 1, 
            'payments_enabled' => 1,
            'wiki_enabled' => 0,
            'mail_server_enable' => 1 ,
            'mail_server_protocol' => 'IMAP',
            'mail_server_encryption' => 'NONE',
            'mail_server_hosts' => 'smtp.gmail.com',
            'mail_server_port' => 0,
            'mail_server_user' => '-',
            'mail_server_pass' => '-',
            'mail_server_from_email' => 'Admin Task Control',
            'chat_server_enable' => 1,
            'chat_server_url' => 'chatbox.com',
            'payment_integration' => 0,
            'payment_gateway' => 'Skrill',
            'digital_signature' => 0,
            'cloud_storage' => 0,
            'cloud_storage_provider' => 'DropBox',
            'task_creation_email' => 0,
            'social_media' => 0,
            'fields_add_feature' => 1,
            'alfred_active' => 1,
            'field_captions' => 1,
            'system_log' => 1,
            'sox_audit_log' => 1,
            'process_group_active' => 1,
            'knowledge_areas_active' => 1,
            'version' => '1.1.1',
            'max_users' => 20,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
