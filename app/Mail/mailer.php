<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.EmployeeInformations', $this->details->toArray())
        ->from(env('MAIL_USERNAME'), 'no-reply-'.env('APP_NAME'))
        //->sender(env('MAIL_USERNAME'), 'John Doe')
        ->to(env('MAIL_USERNAME'))
        ->replyTo(env('MAIL_USERNAME'))
        ->subject($this->details['title'])
        ->priority(3);
    }
}
