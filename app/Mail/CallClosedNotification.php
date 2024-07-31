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
       

    }
}
