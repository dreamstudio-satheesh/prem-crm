<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        // Server settings
        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = env('MAIL_HOST');                       // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = env('MAIL_USERNAME');               // SMTP username
        $this->mail->Password = env('MAIL_PASSWORD');               // SMTP password
        $this->mail->SMTPSecure = env('MAIL_ENCRYPTION', 'tls');    // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = env('MAIL_PORT', 587);                  // TCP port to connect to
    }

    public function send($to, $subject, $body, $altBody)
    {
        try {
            // Recipients
            $this->mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $this->mail->addAddress($to);                           // Add a recipient

            // Content
            $this->mail->isHTML(true);                              // Set email format to HTML
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->AltBody = $altBody;

            $this->mail->send();
            return 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
