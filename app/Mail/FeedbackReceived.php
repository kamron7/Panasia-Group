<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $selectedText;
    public $feedback;
    public $url;

    public function __construct($selectedText, $feedback, $url)
    {
        $this->selectedText = $selectedText;
        $this->feedback = $feedback;
        $this->url = $url;
    }

    public function build()
    {
        return $this->subject('Новый отзыв с сайта')
            ->view('emails.feedback');
    }
}
