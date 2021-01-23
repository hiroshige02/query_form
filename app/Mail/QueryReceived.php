<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QueryReceived extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer_name;
    protected $query_day;
    protected $date_flag;
    protected $title = "お問い合わせありがとうございます";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$day,$date_flag)
    {
        $this->customer_name = $name;
        $this->query_day = $day;
        $this->date_flag = $date_flag;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('oajeilwi13@gmail.com')
        ->view('email.query_received')
        ->subject($this->title)
        ->with([
            'name' => $this->customer_name,
            'day' => $this->query_day,
            'date_flag' => $this->date_flag,
        ]);
    }
}
