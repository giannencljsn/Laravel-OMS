<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmployeeNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $messageBody;

    /**
     * Create a new message instance.
     *
     * @param string $subject
     * @param string $messageBody
     */
    public function __construct($subject, $messageBody)
    {
        $this->subject = $subject;
        $this->messageBody = $messageBody;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
            ->view('emails.employee_notification')
            ->with([
                'messageBody' => $this->messageBody,
            ]);
    }
}
