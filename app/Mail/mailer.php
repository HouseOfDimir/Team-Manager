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
        $details = $this->details->toArray();

        if(isset($details['exception'])){
            return $this->markdown('emails.ErrorReport', $details)
                ->from(env('MAIL_FROM_ADDRESS'))
                ->to(env('MAIL_ADMIN'))
                ->replyTo(env('MAIL_FROM_ADDRESS'))
                ->subject($this->details['title'])
                ->priority(3);

        }elseif(isset($details['attachment'])){
            return $this->markdown('emails.EmployeePlanning', $details)
                ->from(env('MAIL_FROM_ADDRESS'))
                ->to($this->details['mail'])
                ->replyTo(env('MAIL_FROM_ADDRESS'))
                ->subject($this->details['title'])
                ->attach($this->details['attachment'])
                ->priority(3);

        }else{

            return $this->markdown('emails.EmployeeInformations', $details)
                ->from(env('MAIL_FROM_ADDRESS'))
                ->to(env('MAIL_USERNAME'))
                ->replyTo(env('MAIL_FROM_ADDRESS'))
                ->subject($this->details['title'])
                ->priority(3);
        }
    }
}
