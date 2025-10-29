<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    public function __construct($name, $otp)
    {
        $this->name = $name;
        $this->otp = $otp;
    }

    public function build()
    {
        return $this->subject('Kode OTP Verifikasi Anda')
                    ->view('backend.emails.otp_mail')
                    ->with([
                        'name' => $this->name,
                        'otp' => $this->otp,
                    ]);
    }
}
