<?php

namespace App\Mail;


use App\Diligencia;
use App\User;
use Faker\Provider\Uuid;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckinCobranca extends Mailable
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
        $this->title = 'Email de Sondagem do Correspondente';

        // O que faz?
        $this->description = $description;

        // Preenche quais requisitos?
        $this->types = [
            'C_1' => 'emails.diligencias.checkin-cobranca-correspondente',
            'C_2' => 'emails.diligencias.checkin-lembrete-correspondente',
            'C_3' => 'emails.diligencias.checkin-feito-cliente',
        ];

        $this->type = $this->types[$type];

        // Save the user
        $this->user = $user;

        // Create user access Token
        $this->token = Uuid::uuid();

        $user->update([
            'token' => $this->token
        ]);

        $this->diligencia = $diligencia;

        $this->correspondente = User::where('correspondente_id',$diligencia->correspondente_id)->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.name');
    }
}
