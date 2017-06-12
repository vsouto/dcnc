@extends('layouts.app')

@section('content')
    <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Criar Diligência
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
                <form id="create_diligencia" method="post" action="{{ route('diligencias.store') }}" class="form-horizontal" enctype="multipart/form-data">
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
                                                    <label class="col-lg-6 control-label">Comarca <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::select('comarca_id', $comarcas, null, [
                                                                'class' => 'form-control',
                                                                'id' => 'comarcas-select']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Cliente / Advogado <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::hidden('advogado_id', Auth::user()->id, [
                                                                    'class' => 'form-control',
                                                                    'id'    => 'advogado_id'
                                                                    ]) }}
                                                            {{ Form::select('advogados', $advogados, null, [
                                                                'class' => 'form-control',
                                                                'id' => 'advogados-select']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Título <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('titulo', null, [
                                                             'class' => 'form-control',
                                                             'id'    => 'titulo'
                                                             ]) }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Descrição <span class="text text-danger"> *</span></label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('descricao', null, [
                                                             'class' => 'form-control',
                                                             'id'    => 'name'
                                                             ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Número Integração</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('num_integracao', null, [
                                                                 'class' => 'form-control',
                                                                 'id'    => 'num_integracao'
                                                                 ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Número Processo <span class="text text-danger"> *</span></label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('num_processo', null, [
                                                                 'class' => 'form-control',
                                                                 'id'    => 'num_processo'
                                                                 ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Prazo <span class="text text-danger"> *</span></label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('prazo', null, [
                                                                'class' => 'form-control datepicker',
                                                                'id'    => 'prazo'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Solicitante <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::text('solicitante', null, [
                                                                'class' => 'form-control',
                                                                'id'    => 'solicitante'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Autor <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::text('autor', null, [
                                                                'class' => 'form-control',
                                                                'id'    => 'autor'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="blog">
                                        <div class="blog-header">
                                            <h5 class="blog-title">Réu & Localização</h5>
                                        </div>
                                        <div class="blog-body">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Nome do Réu <span class="text text-danger"> *</span></label>
                                                        {{ Form::text('reu', null, ['class' => 'form-control datepicker',
                                                                'id' => 'reu']) }}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Órgão <span class="text text-danger"> *</span></label>
                                                        {{ Form::text('orgao', null, ['class' => 'form-control datepicker',
                                                            'id' => 'etb']) }}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Local <span class="text text-danger"> *</span></label>
                                                        {{ Form::text('local_orgao', null, ['class' => 'form-control datepicker',
                                                            'id' => 'etb']) }}
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Vara</label>
                                                        {{ Form::text('vara', null, ['class' => 'form-control']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">Orientações <span class="text text-danger"> *</span></label>
                                                        {{ Form::textarea('orientacoes', null, ['class' => 'form-control','rows' => '3']) }}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row Ends -->
                        </div>
                        <!-- Row Ends -->

                        <div class="row">

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <!-- Widget starts -->
                                <div class="blog blog-info">
                                    <div class="blog-header">
                                        <h5 class="blog-title">Serviços</h5>
                                    </div>
                                    <div class="blog-body">
                                        <div class="form-select-grouper">
                                            <table class="table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Serviço</th>
                                                    <th>Selecione</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($servicos as $servico)
                                                    <tr>
                                                        <td>{{ $servico->id }}</td>
                                                        <td>{{ $servico->servico }}</td>
                                                        <td><input type="radio" name="servico_id" class="form-control" value="{{ $servico->id }}"> </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                <!-- Widget ends -->
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <!-- Widget starts -->
                                <div class="blog blog-danger">
                                    <div class="blog-header">
                                        <h5 class="blog-title">Documentos</h5>
                                    </div>
                                    <div class="blog-body">
                                        <div >
                                            <input type="file" name="files[]" multiple />
                                            <br>
                                            <p class="no-margin text">Você pode selecionar mais de um arquivo de uma vez.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Widget ends -->
                            </div>

                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-6">
                                    <div class="col-md-12">
                                        <span class="text text-danger"> * Campos Obrigatórios</span>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-6">
                                    <button type="button" class="btn btn-danger" title="" id="btn-cancel">
                                        <i class="fa fa-close"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success" id="btn-submit">Criar</button>
                                </div>
                            </div>

                        </div>

                {!! Form::close() !!}

            </div>
            <!-- Spacer ends -->
        </div>
    </div>
@endsection

@section('footer')


    {{--<script type="text/javascript" src="{{ URL::asset('js/transition.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/collapse.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datetimepicker.min.js') }}"></script>--}}

    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" >

    <script>

        $('#advogados-select').change(function(){
            $('#advogado_id').val( $(this).val());
        });
        /*
        $(function () {
            $('#prazo').datetimepicker({
                format: 'd.m.Y H:i',
                inline: true,
            });
        });
         */
        $( "#prazo" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection
