<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Models\Setting;

class MailConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (\Schema::hasTable('settings')) { // Check if the settings table exists
            $mailSettings = Setting::whereIn('key', [
                'email.mail_host',
                'email.mail_port',
                'email.mail_encryption',
                'email.mail_username',
                'email.mail_password',
                'email.from_address',
                'email.from_name'
            ])->get()->pluck('value', 'key')->toArray();

            Config::set('mail.mailers.smtp.host', $mailSettings['email.mail_host']);
            Config::set('mail.mailers.smtp.port', $mailSettings['email.mail_port']);
            Config::set('mail.mailers.smtp.encryption', $mailSettings['email.mail_encryption']);
            Config::set('mail.mailers.smtp.username', $mailSettings['email.mail_username']);
            Config::set('mail.mailers.smtp.password', $mailSettings['email.mail_password']);
            Config::set('mail.from.address', $mailSettings['email.from_address']);
            Config::set('mail.from.name', $mailSettings['email.from_name']);
        }
    }

    public function register()
    {
        //
    }
}
