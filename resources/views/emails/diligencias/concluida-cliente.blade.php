
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

O correspondente {{ $correspondente->nome }} definiu a diligência de nº {{ $diligencia->id }} como concluída.
Na sequência ela deve ser revisada e ter as considerações sobre os serviços realizados.
Acesse-a para revisar:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Atenciosamente,

@endcomponent