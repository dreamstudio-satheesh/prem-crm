<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class EmailSettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'email.mail_host', 'value' => 'smtp.example.com'],
            ['key' => 'email.mail_port', 'value' => '587'],
            ['key' => 'email.mail_encryption', 'value' => 'tls'],
            ['key' => 'email.mail_username', 'value' => 'user@example.com'],
            ['key' => 'email.mail_password', 'value' => 'secret'],
            ['key' => 'email.from_address', 'value' => 'noreply@example.com'],
            ['key' => 'email.from_name', 'value' => 'Admin User']
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
