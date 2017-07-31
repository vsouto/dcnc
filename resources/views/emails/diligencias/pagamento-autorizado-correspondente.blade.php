
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos, que o ato de n.º {{ $diligencia->id }}, foi revisado e considerado aprovado para liberação do financeiro.
Acompanhe a diligência e os próximos passos através do link abaixo:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Atenciosamente,

@endcomponent