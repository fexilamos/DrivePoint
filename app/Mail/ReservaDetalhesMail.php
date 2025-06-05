<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaDetalhesMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public $dias;

    public function __construct($reserva, $dias)
    {
        $this->reserva = $reserva;
        $this->dias = $dias;
    }

    public function build()
    {
        return $this->subject('Detalhes da sua Reserva')
            ->view('emails.reserva-detalhes');
    }
}
