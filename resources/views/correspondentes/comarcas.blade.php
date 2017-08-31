@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Correspondentes - Comarcas'])
    @endif

    <!-- Main Container starts -->
<div class="main-container">

    <!-- Container fluid Starts -->
    <div class="container-fluid">

        <!-- Spacer starts -->
        <div class="spacer">

            <h4>Correspondente: {{ $correspondente->id . ' - ' . $correspondente->nome }}</h4>
            <br>
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-lg-12 col-md-12 col-sx-12 col-sm-12">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#comarcas" data-toggle="tab" data-original-title="" title="">Comarcas</a>
                        </li>
                        <li class="">
                            <a href="#adicionar" data-toggle="tab" data-original-title="" title="">Adicionar</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade  active in" id="comarcas">
                            <p class="text">Comarcas já <b>vinculadas</b> à este correspondente.</p>
                            <p class="no-margin">
                            <div class="panel-group no-margin" id="accordion">
                                @foreach ($correspondente->comarcas as $comarca)
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#comarca-{{ $comarca->id }}" class="text-danger collapsed" data-original-title="" title="">
                                                    Comarca: {{ $comarca->comarca }}
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="comarca-{{ $comarca->id }}" class="panel-collapse collapse" style="height: 0px;">
                                            <div class="panel-body">
                                                <form id="correspondente_comarcas"
                                                      method="post" action="{{ route('correspondentes.comarcasUpdate') }}" class="form-horizontal" enctype="multipart/form-data">
                                                    {{ Form::token() }}
                                                    {{ Form::hidden('correspondente_id', $correspondente->id) }}
                                                    {{ Form::hidden('comarca_id', $comarca->id) }}
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
                                                                <td>{{ $servico->servico }} </td>
                                                                <td>
                                                                    <?php $find = $correspondente->servicos()?
                                                                            $correspondente->servicos()
                                                                                    ->where('comarca_id',$comarca->id)
                                                                                    ->where('servico_id',$servico->id)
                                                                                    ->first() :
                                                                            []; ?>
                                                                    @if ($find)
                                                                        <input type="text" name="servico[{{ $servico->id }}][valor]"
                                                                           class="form-control"
                                                                           value="{{ $find->pivot->valor }}">
                                                                    @else
                                                                            <input type="text" name="servico[{{ $servico->id }}][valor]"
                                                                                   class="form-control"
                                                                                   value="">
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                            <tr>
                                                                <td colspan="3">
                                                                    <button class="btn btn-default" type="submit">
                                                                        <i class="fa fa-save"></i> Salvar</button>
                                                                    <button class="btn btn-danger remover-comarca" type="button" id="" data-ref="{{ $comarca->id }}">
                                                                        <i class="fa fa-trash-o"></i> Remover</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="adicionar">
                            <p class="text"><b>Adiciona</b> uma Comarca à este correspondente.</p>
                            <form id="correspondente_comarcas"
                                  method="post" action="{{ route('correspondentes.comarcasStore') }}" class="form-horizontal" enctype="multipart/form-data">
                                {{ Form::token() }}
                                {{ Form::hidden('correspondente_id', $correspondente->id) }}
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Comarca</h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label class="col-md-12">Estado <span class="text text-danger"> *</span></label>
                                            <div class="col-md-12">
                                                <div class="form-select-grouper">
                                                    {{ Form::select('estado_id', $estados, null, [
                                                        'class' => 'form-control',
                                                        'id' => 'estado-select']) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group resto-form"  style="display: none;">
                                            <label class="col-md-12">Comarca <span class="text text-danger"> *</span></label>
                                            <div class="col-md-12">
                                                <div class="form-select-grouper">
                                                    <select id="comarcas-select" class="form-control" name="comarca_id"></select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-success servicos-form" style="display: none;">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">Serviços</h4>
                                    </div>
                                    <div class="panel-body">
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
                                                            <td><input type="text" name="servico[{{ $servico->id }}][valor]" class="form-control"> </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <button class="btn btn-default" type="submit"><i class="fa fa-save"></i> Adicionar</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row Ends -->

        </div>
    </div>
</div>

@endsection

@section('footer')

    <script>
        $('#estado-select').change(function(){
            var estado_id = $(this).val();

            getComarcas(estado_id);

            $('.resto-form').show();
        });

        $('#comarcas-select').change(function(){
            $('.servicos-form').show();
        });

        $('.remover-comarca').click(function(){

            if (confirm('Confirma remover esta comarca deste correspondente?')) {

                var correspondente_id = '{{ $correspondente->id }}';
                var comarca_id = $(this).data('ref');

                removerComarcaCorrespondente(correspondente_id, comarca_id);
            }
        });

    </script>
@endsection
