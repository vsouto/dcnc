
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos que a diligência de n.º {{ $diligencia->id }}, cujos dados encontram-se abaixo resumidos, encontra-se em atraso.

@include('emails.diligencias.info',['diligencia' => $diligencia])

Gentileza disponibilizar os documentos  através do link abaixo:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Em caso de qualquer dúvida ou empecilho ao cumprimento da presente solicitação, favor entrar em contato imediatamente com o nosso setor de logística jurídica pelo telefone 31 32745668.

Atenciosamente,

@endcomponent