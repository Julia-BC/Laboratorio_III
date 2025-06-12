<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


//// Classe para enviar o e-mail de verificação de cadastro
class VerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user; //Armazena o usuário que receberá o e-mail de verificação

    /**
     * Construtor: recebe o usuário que será verificado.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Define o envelope (assunto) do e-mail.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirme seu cadastro pelo E-mail',
        );
    }

    /**
     * Define o conteúdo do e-mail (view a ser usada).
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verification', //// View ->  resources/views/emails/verification.blade.php
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
