<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueryCompleted extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer_name;
    protected $customer_email;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$email)
    {
        $this->customer_name = $name;
        $this->customer_email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.query_completed')
        ->with([

        ]);
    }
}
