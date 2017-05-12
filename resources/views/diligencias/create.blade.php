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
                                                    <label class="col-lg-6 control-label">Cliente</label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::hidden('advogado_id', Auth::user()->id, [
                                                                    'class' => 'form-control',
                                                                    'id'    => 'cliente_id'
                                                                    ]) }}
                                                            {{ Form::text('cliente', Auth::user()->nome, [
                                                                'class' => 'form-control',
                                                                'id'    => 'cliente',
                                                                'disabled' => 'disabled'
                                                                ]) }}
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
                                                        <label class="col-lg-6 control-label">Prazo</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('prazo', null, [
                                                                'class' => 'form-control datepicker',
                                                                'id'    => 'prazo'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Tipo</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::select('tipo_id', $tipos, null, [
                                                                'class' => 'form-control',
                                                                'id'    => 'tipo'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Solicitante</label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::text('solicitante', null, [
                                                                'class' => 'form-control',
                                                                'id'    => 'solicitante'
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
                                                        <label class="control-label">Orientações</label>
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

                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 disabled">
                                <!-- Widget starts -->
                                <div class="blog blog-info disabled">
                                    <div class="blog-header">
                                        <h5 class="blog-title">Histórico</h5>
                                    </div>
                                    <div class="blog-body">
                                        <img src="{{ asset('img/historico.PNG') }}" style="opacity: 0.4;">
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


    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet" media="screen">

    <script>
        $('#new').click(function(){
            location.href = '{{ route('diligencias.create') }}';
        });

        $( "#prazo" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection