@extends('layouts.app')

@section('content')
    <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Editar Correspondente
        </div>
        <ul class="stats hidden-xs">
            <li>
                <div class="stats-block hidden-sm hidden-xs">
                    <span id="downloads_graph"></span>
                </div>
                <div class="stats-details">
                    <h4>$<span id="today_income">580</span> <i class="fa fa-chevron-up up"></i></h4>
                    <h5>Receitas do Dia</h5>
                </div>
            </li>
            <li>
                <div class="stats-block hidden-sm hidden-xs">
                    <span id="users_online_graph"></span>
                </div>
                <div class="stats-details">
                    <h4>$<span id="today_expenses">235</span> <i class="fa fa-chevron-down down"></i></h4>
                    <h5>Despesas do Dia</h5>
                </div>
            </li>
        </ul>
    </div>
    <!-- Top Bar ends -->

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <!-- Spacer starts -->
            <div class="spacer">
                {{ Form::model($correspondente, ['class' => 'form-horizontal','route' => ['correspondentes.update', $correspondente->id],
                            'method' => 'PATCH']) }}
                    {{ Form::token() }}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Row Starts -->
                    <div class="row">
                        <!-- Row Starts -->
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <div class="blog">
                                    <div class="blog-header">
                                        <h5 class="blog-title">Principais Informações</h5>
                                    </div>
                                    <div class="blog-body">
                                        <fieldset>
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Estado <span class="text text-danger"> *</span></label>
                                                <div class="col-lg-6">
                                                    <div class="form-select-grouper">
                                                        {{ Form::select('estado_id', $estados, $correspondente->comarcas->first()->uf, [
                                                            'class' => 'form-control',
                                                            'id' => 'estado-select']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group resto-form" id="" style="display: block;">

                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Comarca <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            <select id="comarcas-select" class="form-control" name="comarca_id"></select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Nome <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('nome', $correspondente->nome, [
                                                             'class' => 'form-control',
                                                             'id'    => 'nome'
                                                             ]) }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Email <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        {{ Form::email('email', $correspondente->user->email, [
                                                         'class' => 'form-control',
                                                         'id'    => 'email'
                                                         ]) }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Senha </label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('password', null, [
                                                             'class' => 'form-control',
                                                             'id'    => 'password'
                                                             ]) }}
                                                        <div class="alert alert-info alert-transparent">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            <strong>Obs:</strong> Apenas digite uma nova senha se quiser alterá-la.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Telefone</label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('phone', $correspondente->user->phone, [
                                                             'class' => 'form-control',
                                                             'id'    => 'phone'
                                                             ]) }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Endereço</label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('endereco', $correspondente->user->endereco, [
                                                            'class' => 'form-control ',
                                                            'id'    => 'endereco'
                                                            ]) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>

                                        <fieldset class="resto-form" style="display: block;">
                                            <legend>Serviços</legend>
                                            <div class="form-group">
                                                <div class="col-lg-12 control-label">
                                                    <table class="table table-striped no-margin" style="width: 100%;" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Serviço</th>
                                                            <th>Valor</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($servicos as $servico)
                                                            <tr>
                                                                <td>{{ $servico->id }}</td>
                                                                <td>{{ $servico->servico }}</td>
                                                                <td>
                                                                    <input type="text"
                                                                           name="servico[{{ $servico->id }}][valor]"
                                                                           class="form-control"
                                                                            value="{{ $correspondente->servicos()->where('servico_id',$servico->id)->first()->pivot->valor or '' }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 resto-form" style="display: block;">
                                <div class="blog">
                                    <div class="blog-header">
                                        <h5 class="blog-title">Informações Bancárias</h5>
                                    </div>
                                    <div class="blog-body">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Tipo de Conta</label>
                                                    {{ Form::select('tipo_conta', $tipos_conta, $correspondente->tipo_conta ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'tipo_conta'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group PF" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">CPF</label>
                                                    {{ Form::text('cpf', $correspondente->user->cpf ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'cpf'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group PJ" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">CNPJ</label>
                                                    {{ Form::text('cnpj', $correspondente->cnpj ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'cnpj'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Banco</label>
                                                    {{ Form::text('bank', $correspondente->bank ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'bank'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Agência</label>
                                                    {{ Form::text('ag', $correspondente->agencia ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'ag'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Conta</label>
                                                    {{ Form::text('conta', $correspondente->conta ,[
                                                        'class' => 'form-control ',
                                                        'id'    => 'conta'
                                                    ]) }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Row Ends -->

                        <div class="form-group">

                            <div class="col-lg-6 col-lg-offset-6">
                                <button type="button" class="btn btn-danger" title="" id="btn-cancel">
                                    <i class="fa fa-close"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-success" id="btn-submit">Save</button>
                            </div>
                        </div>
                    </div>
                    <!-- Row Ends -->

                {!! Form::close() !!}

            </div>
            <!-- Spacer ends -->
        </div>
    </div>
@endsection

@section('footer')

    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" media="screen">

    <script>

        $(function() {

            // Checa se já tem estado selecionado
            if ( $('#estado-select').val() != '0') {

                $('.resto-form').show();

                var estado_id = $('#estado-select').val();
                var selected = '{{ $correspondente->comarcas->first()->id }}';

                getComarcas(estado_id, selected);
            }

            if ( $('#select-conta').val() != '0') {

                var selecao = $('#select-conta').val();

                selectConta(selecao);
            }
        });

        $('#new').click(function(){
            location.href = '{{ route('correspondentes.create') }}';
        });

        $('#tipo_conta').change(function(){
            var selecao = $(this).val();

            selectConta(selecao);
        });

        $('#estado-select').change(function(){
            var estado_id = $(this).val();

            getComarcas(estado_id);

            $('.resto-form').show();
        });

        $( "#prazo" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

        function selectConta(selecao) {
            $('.PF').hide();
            $('.PJ').hide();
            $('.' + selecao).show();
        }
    </script>
@endsection
