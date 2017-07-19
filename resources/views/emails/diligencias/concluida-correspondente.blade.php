
@component('mail::message')
# Prezado Sr. {{ $user->nome }},

Agradecemos o retorno da diligência. Realizaremos a conferência dos arquivos para a conclusão do Ato nº {{ $diligencia->id }}.
Na sequência enviaremos as considerações sobre os serviços realizados, bem como informaremos a data do pagamento.

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent