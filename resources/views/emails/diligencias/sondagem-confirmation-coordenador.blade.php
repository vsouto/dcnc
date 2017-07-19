
@component('mail::message')
# Prezado Sr. {{ $user->nome }},


O seu escritório foi pré-selecionado para realizar o ato de n.º xxxx, cujos dados encontram-se abaixo resumidos:

@include('emails.diligencias.info',['diligencia' => $diligencia])

Caso você tenha interesse, disponibilidade e esteja de acordo com as condições acima indicadas, gentileza confirmar o “aceite” da diligência através do link :

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

As demais orientações, documentos e/ou informações adicionais serão enviados após o processamento do “aceite” em nosso sistema.

Esta solicitação será automaticamente redirecionada para outro prestador caso o “aceite” não seja confirmado em nosso sistema em até 8 (oito) horas, contados a partir do envio do presente e-mail.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent