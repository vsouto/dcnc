
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos, para o seu controle, que o ato de n.º {{ $diligencia->id }}, cumprido pelo Dr. {{ $correspondente->nome }}, teve seu pagamento devidamente efetivado.

@include('emails.diligencias.info',['diligencia' => $diligencia])

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent