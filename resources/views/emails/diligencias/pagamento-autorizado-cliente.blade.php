
@component('mail::message')
# Prezado Dr. {{ $user->nome }},

Informamos, para o seu controle, que o ato de n.º {{ $diligencia->id }}, executado pelo Dr. {{ $correspondente->nome }}, encontra-se aprovado para pagamento.
Acompanhe a diligência e os próximos passos através do link abaixo:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Atenciosamente,

@endcomponent