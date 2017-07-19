
@component('mail::message')
# Prezado Sr. {{ $user->nome }},

Uma nova conta de usuário foi criada para seu uso em nossa plataforma:

Você pode acessar a plataforma clicando abaixo:

@component('mail::button', ['url' => $url])
Plataforma
@endcomponent

As demais orientações virão conforme sua conta for atribuída a alguma tarefa no sistema.

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent