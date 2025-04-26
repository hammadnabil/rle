<?php

namespace App\Mail;

use App\Models\Izin;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StatusIzinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $izin;

    public function __construct(Izin $izin)
    {
        $this->izin = $izin;
    }

    public function build()
    {
        return $this->subject('Status Pengajuan Izin Anda')
                    ->view('emails.status_izin');
    }
}
