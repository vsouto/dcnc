
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Realizamos a conferência da diligência nº {{ $diligencia->id }} e o advogado responsável pela solicitação pontuou inconsistências na diligência.

@include('emails.diligencias.info',['diligencia' => $diligencia])

Gentileza corrigi-las o quanto antes e reinserir o ato através do link abaixo:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Em caso de dúvidas nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent