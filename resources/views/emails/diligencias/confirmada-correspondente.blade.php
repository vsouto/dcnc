
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Você aceitou a solicitação de n.º {{ $diligencia->id }}!
Muito obrigado pela atenção e disponibilidade.
Segue, para registro, o resumo da diligência solicitada pelo Escritório, bem como o respectivo extrato da confirmação:

@include('emails.diligencias.info',['diligencia' => $diligencia])

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Informamos, ainda, que demais orientações, informações e/ou documentos serão disponibilizados em momento oportuno.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent