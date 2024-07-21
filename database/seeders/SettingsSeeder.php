<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'app.name', 'value' => 'My CRM App'],
            ['key' => 'company.name', 'value' => 'My Company'],
            ['key' => 'company.email', 'value' => 'info@mycompany.com'],
            ['key' => 'ui.theme_color', 'value' => '#007bff']  // Bootstrap primary blue
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
        }
    }
}
