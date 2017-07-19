<?php

namespace App\Mail;

use App\User;
use Faker\Provider\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovoCorrespondente extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $description = '')
    {
        //
        $this->title = 'Cadastro de Correspondente';

        // O que faz?
        $this->description = $description;

        // Preenche quais requisitos?
        $this->attends = ['F_1'];

        // Save the user
        $this->user = $user;

        // Create user access Token
        $this->token = Uuid::uuid();

        $user->update([
            'token' => $this->token
        ]);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.correspondente.novo')
            ->with([
                'url' => action('CorrespondentesController@entrar',['token' => $this->token]),
                'user' => $this->user
            ]);
    }
}
