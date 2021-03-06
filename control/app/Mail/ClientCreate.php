<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientCreate extends Mailable
{
    use Queueable, SerializesModels;

    protected $mail_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Creación de cuenta Advans')
                    ->view('mails.clientcreate')
                    ->with([
                        'user' => $this->mail_data['user'],
                        'password' => $this->mail_data['password'],
                        'rfc' => $this->mail_data['rfc'],
                        'link' => $this->mail_data['link'],
                    ]);;
    }
}
