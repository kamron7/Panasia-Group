<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
        $this->afterCommit();
    }

    public function build()
    {
        return $this->subject('Код подтверждения регистрации')
            ->view('emails.register_code')
            ->with(['code' => $this->code]);
    }
}
