@extends('layouts.app')

@section('content')

@if (Auth::user()->level >= 4)
    @include('elements.top-bar', ['title' => 'Diligências'])
@endif

    <!-- Main Container starts -->
<div class="main-container">

    <!-- Container fluid Starts -->
    <div class="container-fluid">
        <!-- Spacer starts -->
        <div class="spacer">
            {{ Form::model($diligencia, array('route' => array('diligencias.update', $diligencia->id), 'method' => 'PUT',
                    'class' => 'form-horizontal')) }}
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
                                                <label class="col-lg-6 control-label">Audiência <span class="text text-danger"> *</span></label>
                                                <div class="col-lg-6">
                                                    <div class="form-select-grouper">
                                                        {{Form::hidden('audiencia',0)}}
                                                        {{ Form::checkbox('audiencia', 1) }}
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($diligencia->status_id <= 2)
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Estado <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::select('estado_id', $estados, $diligencia->comarca->uf, [
                                                                'class' => 'form-control',
                                                                'id' => 'estados-select']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Comarca <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            {{ Form::select('comarca_id', $comarcas, $diligencia->comarca->id, [
                                                                'class' => 'form-control',
                                                                'id' => 'comarcas-select']) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (Auth::user()->level == 2)
                                                    <!-- Cliente -->
                                            <div class="form-group">
                                                <label class="col-lg-6 control-label">Cliente / Advogado <span class="text text-danger"> *</span></label>
                                                <div class="col-lg-6">
                                                    <div class="form-select-grouper">
                                                        {{ Form::hidden('advogado_id', Auth::user()->id, [
                                                                'class' => 'form-control',
                                                                'id'    => 'advogado_id'
                                                                ]) }}
                                                        {{ Form::text('advogado', Auth::user()->nome, [
                                                            'class' => 'form-control',
                                                            'disabled' => 'disabled',
                                                            'id' => 'advogado_id-select']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            @else
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
                                            @endif
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
                                                    <label class="col-lg-6 control-label">Número Integração (ACT)</label>
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
                                                        {{ Form::text('prazo', $diligencia->prazo->format('d/m/Y H:i'), [
                                                            'class' => 'form-control',
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
                                                    {{ Form::text('reu', null, ['class' => 'form-control',
                                                            'id' => 'reu']) }}
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Órgão <span class="text text-danger"> *</span></label>
                                                    {{ Form::text('orgao', null, ['class' => 'form-control',
                                                        'id' => 'etb']) }}
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Local (Endereço Completo) <span class="text text-danger"> *</span></label>
                                                    {{ Form::text('local_orgao', null, ['class' => 'form-control',
                                                        'id' => 'etb']) }}
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Vara <span class="text text-danger"> *</span></label>
                                                    {{ Form::text('vara', null, ['class' => 'form-control']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="control-label">Orientações <span class="text text-danger"> *</span></label>
                                                    {{ Form::textarea('orientacoes', null, ['class' => 'form-control','rows' => '10']) }}
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
                                        <div class="alert alert-warning alert-white rounded">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                                            <strong>Atenção:</strong>
                                            O serviço de uma Diligência não pode ser alterado. Criar uma nova, se necessário.
                                        </div>
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
                                <button type="submit" class="btn btn-success" id="btn-submit">Salvar</button>
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

    <script type="text/javascript" src="{{ asset('js/moment-with-locales.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

    <link href="{{ asset('css/bootstrap-datetimepicker/bootstrap-datetimepicker.css') }}" rel="stylesheet" media="screen">

    <script>

        $(function() {
/*
            // Checa se já tem estado selecionado
            if ( $('#estado-select').val() != '0') {

                $('.resto-form').show();

                var estado_id = $('#estado-select').val();
                var selected = '{{ $diligencia->comarca->uf }}';

                getComarcas(estado_id, selected);
            }

            if ( $('#select-conta').val() != '0') {

                var selecao = $('#select-conta').val();

                selectConta(selecao);
            }*/
        });

        $('#advogados-select').change(function(){
            $('#advogado_id').val( $(this).val());
        });

        $('#estados-select').change(function(){
            var estado_id = $(this).val();

            getComarcas(estado_id);
        });

        $(function () {
            $('#prazo').datetimepicker({
                format: 'DD/MM/YYYY HH:mm',
                inline: true,
                locale: 'pt',
                viewMode: 'years',
                //minDate: moment().format('D/M/Y H:m')
                //minDate: moment().format('L')
            });

            var estado_id = $('#estados-select').val();

                    @if (Input::old('estado_id') && !empty(Input::old('estado_id')) && Input::old('estado_id') != '0')
                        var estado_selected = '{{ Input::old('estado_id') }}';

            getComarcas(estado_id, estado_selected);
            @endif
        });

    </script>
@endsection
