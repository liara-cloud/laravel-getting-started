<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Headers;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function build()
    {
        return $this->subject('Test Email')
                    ->view('emails.test');

    }

    public function headers(): Headers
    {
        return new Headers(
            text: [
                'x-liara-tag' => 'test_email',
            ],
        );
    }


}
