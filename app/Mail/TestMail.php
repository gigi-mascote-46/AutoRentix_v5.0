<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;

    /**
     * Create a new message instance.
     */
    public function __construct($subjectLine = 'Teste de Mailtrap via Laravel')
    {
        $this->subjectLine = $subjectLine;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->view('emails.testmail');  // criaremos essa view em seguida
    }
}
