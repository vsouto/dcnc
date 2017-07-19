<?php

namespace App\Mail;
use App\Diligencia;
use App\User;
use Faker\Provider\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DiligenciaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Diligencia $diligencia, $description = '')
    {
        //
        $this->title = 'Email de Sondagem do Correspondente';

        // O que faz?
        $this->description = $description;

        // Preenche quais requisitos?
        $this->attends = ['A_2', 'A_2', 'A_3'];

        // Save the user
        $this->user = $user;

        // Create user access Token
        $this->token = Uuid::uuid();

        $user->update([
            'token' => $this->token
        ]);

        $this->diligencia = $diligencia;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.diligencias.sondagem-confirmation')
            ->with([
                'url' => action('CorrespondentesController@entrar',['token' => $this->token]),
                'user' => $this->user,
                'diligencia' => $this->diligencia
            ]);
    }
}
