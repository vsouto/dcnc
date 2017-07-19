
@component('mail::message')
# Prezado Sr. {{ $user->nome }},

De modo a garantir a segurança em nossos procedimentos, pedimos a gentileza que você realize o <b>“check-in”</b> da solicitação de n.º {{ $diligencia->id }} através do link:

@component('mail::button', ['url' => $url])
Ver Diligência
@endcomponent

Antes de realizar o “check-in”, tenha em mãos os dados completos do advogado e do preposto que deverão comparecer à audiência, tais como nome completo, CPF, n.º da OAB, e telefone de contato, pois os documentos de representação serão automaticamente gerados pelo sistema a partir destas informações.

Caso o “check-in” não seja realizado dentro das próximas 24 (vinte e quatro) horas, contadas a partir do envio deste e-mail, o ato abaixo indicado será automaticamente redirecionado para outro correspondente credenciado em nosso sistema.

<h4>IMPORTANTE:</h4> O procedimento de “check-in” não é uma nova contratação, mas apenas a confirmação da contratação anteriormente efetuada pelas partes, nos termos abaixo resumidos:

@include('emails.diligencias.info',['diligencia' => $diligencia])

Em caso de dúvidas ou de inconsistências nas informações aqui prestadas, gentileza contatar o nosso setor de logística jurídica pelo telefone: 31 3274-5668.

Atenciosamente,

@endcomponent