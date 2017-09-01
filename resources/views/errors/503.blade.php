@extends('layouts.login')

@section('content')
    <div class="row">
        <div class="col-md-push-4 col-md-4 col-sm-push-3 col-sm-6 col-sx-12">

            <!-- Header end -->
            <div class="login-container">
                <div class="login-wrapper animated flipInY">
                    <h1>Ops!</h1>
                    <h6>Ocorreu um erro em suas configurações ou você está tentando acessar algo que não deveria!</h6>
                    <h6>Detalhes do erro:<br>
                        {{ $exception->getMessage() }}</h6>
                    Entre em contato com nosso suporte através do email: {{ 'contato@dcnc-log.com.br' }}
                </div>
            </div>
        </div>
    </div>
@endsection
