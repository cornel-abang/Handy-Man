<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendJobOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $logo_url = '<img src="{{asset("assets/images/logo.jpeg")}}">';
        return $this->from('info@handiman.ng', 'Handiman Services')
            ->to($this->data->invoice->service->artisan->email, $this->data->invoice->service->artisan->full_name)
            ->subject('Job Order - '.$this->data->invoice->service->category.' for '.$this->data->invoice->service->user->name)
            ->markdown('emails.job_order',['logo_url'=>$logo_url]);
    }
}
