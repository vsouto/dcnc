
@component('mail::message')
# Prezado Sr. {{ $user->nome }},

Considerando que não houve confirmação da sua disponibilidade para o cumprimento do ato de n.º {{ $diligencia->id }}, estamos cancelando a pré-contratação anteriormente veiculada pelo Escritório.

@include('emails.diligencias.info',['diligencia' => $diligencia])

Informamos, outrossim, que esta diligência será automaticamente repassada a outro correspondente credenciado em nossos bancos de dados. Deste modo, favor desconsiderar a solicitação acima reproduzida.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent