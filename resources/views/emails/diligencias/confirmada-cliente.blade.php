
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos, para o seu controle, que o ato de n.º {{ $diligencia->id }} será cumprido pelo Dr. {{ $correspondente->nome }}, o qual poderá ser contatado por meio dos seguintes números:
{{ $correspondente->phone }}, {{ $correspondente->email }}, {{ $correspondente->endereco }}

@include('emails.diligencias.info',['diligencia' => $diligencia])

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Caso exista mais alguma informação, orientação e/ou documento a serem disponibilizados ao correspondente, pedimos a gentileza que os indexem o quanto antes em nosso sistema.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent