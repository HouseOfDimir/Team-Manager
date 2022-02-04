<?php

namespace App\Lib;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

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
    /* public function build()
    {
        return $this->subject($this->details['title'])
                    ->view($this->details['view'])->with(['details' => $this->details]);
    } */

    public function build()
    {
        /* return $this->subject($this->details['title'])
                    ->view('mailN1', compact($this->details))->from(env('MAIL_USERNAME')); */

        /* Mail::send('mailN1', $this->details->toArray(), function ($message){
            $message->from(env('MAIL_USERNAME'), 'John Doe');
            $message->sender(env('MAIL_USERNAME'), 'John Doe');
            $message->to(env('MAIL_USERNAME'), 'John Doe');
            $message->replyTo(env('MAIL_USERNAME'), 'John Doe');
            $message->subject($this->details['title']);
            $message->priority(3);
            //$message->attach('pathToFile');
        }); */

        return $this->view('mailN1', compact($this->details))
                    ->from(env('MAIL_USERNAME'), 'no-reply-'.env('APP_NAME'))
                    //->sender(env('MAIL_USERNAME'), 'John Doe')
                    ->to(env('MAIL_USERNAME'))
                    ->replyTo(env('MAIL_USERNAME'))
                    ->subject($this->details['title'])
                    ->priority(3);
    }
}
