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
    public function __construct(User $user, Diligencia $diligencia, $description = '', $type)
    {
        //
        $this->title = 'Diligência Confirmada';

        // O que faz?
        $this->description = $description;

        // Preenche quais requisitos?
        $this->types = [
            'B_1' => 'emails.diligencias.confirmada-cliente',
            'B_2' => 'emails.diligencias.confirmada-correspondente'
        ];

        $this->view = $this->types[$type];

        // Save the user
        $this->user = $user;

        // Create user access Token
        $this->token = Uuid::uuid();

        $user->update([
            'token' => $this->token
        ]);

        $this->diligencia = $diligencia;

        $this->correspondente = User::where('correspondente_id',$diligencia->correspondente->id)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown($this->view)
            ->with([
                'url' => action('CorrespondentesController@entrar',['token' => $this->token]),
                'user' => $this->user,
                'diligencia' => $this->diligencia,
                'correspondente' => $this->correspondente
            ]);
    }
}
