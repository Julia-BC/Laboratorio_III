<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

trait VerifiesEmail
{
    public function sendVerificationEmail($user)
    {
        // Gerar token e salvar
        $user->verification_token = Str::random(60);
        $user->email_verified_at = null; // resetar verificação
        $user->save();

        // Enviar o e-mail
        Mail::to($user->email)->send(new VerificationMail($user));
    }
}