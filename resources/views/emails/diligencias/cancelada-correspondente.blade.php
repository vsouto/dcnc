
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos, para o seu controle, que a diligência de n.º {{ $diligencia->id }}, foi cancelada no sistema.

@include('emails.diligencias.info',['diligencia' => $diligencia])

Em caso de dúvidas ou de inconsistências, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent