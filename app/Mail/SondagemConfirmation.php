<?php

namespace App\Mail;

use App\Diligencia;
use App\User;
use Faker\Provider\Uuid;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SondagemConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Diligencia $diligencia, $description = '', $type)
    {
        //
        $this->title = 'Sondagem do Correspondente';

        // O que faz?
        $this->description = $description;

        // Preenche quais requisitos?
        $this->types = [
            'A_1' => 'emails.diligencias.sondagem-confirmation-coordenador',
            'A_2' => 'emails.diligencias.sondagem-confirmation-correspondente',
            'A_3' => 'emails.diligencias.sondagem-confirmation-correspondente-cancelled'
        ];

        // Define the type
        $this->view = $this->types[$type];

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
        return $this->markdown($this->view)
            ->subject($this->title)
            ->with([
                'url' => action('CorrespondentesController@entrar',['token' => $this->token]),
                'user' => $this->user,
                'diligencia' => $this->diligencia
            ]);
    }
}
