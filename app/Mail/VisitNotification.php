<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VisitNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $visit;

    public function __construct($visit)
    {
        $this->visit = $visit;
    }

    public function build()
    {
        return $this->view('emails.notification')
                   ->subject('Notificação de Visita Agendada');
    }
}