
@component('mail::message')
# Prezado Sr. {{ $user->nome }},

Informamos que o Sr. {{ $correspondente->nome }} confirmou a execução do ato de nº {{ $diligencia->id }} através de nossa ferramenta de <b>Check-In</b>.

Orientamos que mantenha sempre todas as informações atualizadas no sistema, bem como os documentos e orientações necessárias para o correto cumprimento da tarefa por parte do correspondente.

Em caso de qualquer dúvida ou empecilho ao cumprimento da presente solicitação, favor entrar em contato imediatamente com o nosso setor de logística jurídica pelo telefone 31 32745668.

Atenciosamente,

@endcomponent