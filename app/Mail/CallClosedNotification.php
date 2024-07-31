<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

class CallClosedNotification extends Mailable
{
    use Queueable, SerializesModels;

    protected $recipientEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($recipientEmail)
    {
        $this->recipientEmail = $recipientEmail;

        // Update mail configuration dynamically
        $this->updateMailConfig();
    }

    /**
     * Build the message.
     */
    public function build()
    {
        Log::info('Building email for recipient: ' . $this->recipientEmail);
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($this->recipientEmail)
                    ->subject('Call Closed Notification - Prem Infotech')
                    ->view('emails.call_closed_notification');
    }

    /**
     * Update mail configuration from database settings.
     */
    protected function updateMailConfig()
    {
        $settings = Setting::whereIn('key', [
            'email.mail_host',
            'email.mail_port',
            'email.mail_encryption',
            'email.mail_username',
            'email.mail_password',
            'email.from_address',
            'email.from_name'
        ])->pluck('value', 'key');

        $config = [
            'driver'     => 'smtp',
            'host'       => $settings['email.mail_host'],
            'port'       => $settings['email.mail_port'],
            'encryption' => $settings['email.mail_encryption'],
            'username'   => $settings['email.mail_username'],
            'password'   => $settings['email.mail_password'],
            'from'       => [
                'address' => $settings['email.from_address'],
                'name'    => $settings['email.from_name']
            ],
        ];

        config(['mail.mailers.smtp' => $config]);
        config(['mail.from.address' => $settings['email.from_address']]);
        config(['mail.from.name' => $settings['email.from_name']]);

        Log::info('Mail configuration updated: ', $config);
    }
}
