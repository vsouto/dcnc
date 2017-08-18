
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

A solicitação de n.º {{ $diligencia->id }} teve seu pagamento efetivado.

Agradecemos o trabalho realizado.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent