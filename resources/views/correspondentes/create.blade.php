@extends('layouts.app')

@section('content')
    <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Criar Correspondente
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
                <form id="create_correspondente" method="post" action="{{ route('correspondentes.store') }}" class="form-horizontal" enctype="multipart/form-data">
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
                                                    <label class="col-lg-6 control-label">Nome <span class="text text-danger"> *</span></label>
                                                    <div class="col-lg-6">
                                                        {{ Form::text('nome', null, [
                                                             'class' => 'form-control',
                                                             'id'    => 'nome'
                                                             ]) }}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Email <span class="text text-danger"> *</span></label>
                                                        <div class="col-lg-6">
                                                            {{ Form::email('email', null, [
                                                             'class' => 'form-control',
                                                             'id'    => 'email'
                                                             ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Senha <span class="text text-danger"> *</span></label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('senha', null, [
                                                                 'class' => 'form-control',
                                                                 'id'    => 'senha'
                                                                 ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Telefone</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('phone', null, [
                                                                 'class' => 'form-control',
                                                                 'id'    => 'phone'
                                                                 ]) }}
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Endereço</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::text('endereco', null, [
                                                                'class' => 'form-control ',
                                                                'id'    => 'endereco'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-lg-6 control-label">Serviços</label>
                                                    <div class="col-lg-6">
                                                        <div class="form-select-grouper">
                                                            <table class="table table-striped no-margin">
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
                                                </div>
                                            </fieldset>
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
                                    <button type="submit" class="btn btn-success" id="btn-submit">Create</button>
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


        $('#new').click(function(){
            location.href = '{{ route('correspondentes.create') }}';
        });

        $( "#prazo" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection
