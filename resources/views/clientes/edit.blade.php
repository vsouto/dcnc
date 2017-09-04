@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Clientes'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <!-- Spacer starts -->
            <div class="spacer">
                {{ Form::model($cliente, ['class' => 'form-horizontal','route' => ['clientes.update', $cliente->id],
                            'method' => 'PATCH', 'enctype="multipart/form-data"']) }}
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
                                                    <label class="col-lg-6 control-label">Responsável</label>
                                                    <div class="col-lg-6">
                                                        {{ Form::select('user_id', $users, null, [
                                                            'class' => 'form-control',
                                                            'id'    => 'user_id'
                                                            ]) }}
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
                                                                'class' => 'form-control',
                                                                'id'    => 'endereco'
                                                                ]) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sx-12 col-sm-12">
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">Info</h4>
                                        </div>
                                        <div class="panel-body">
                                            <div class="demo-btn-group">
                                                <div class="alert alert-info alert-white rounded">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                                    <div class="icon"><i class="fa fa-info"></i></div>
                                                    <strong>Info: </strong> Um usuário master do cliente será criado com este email e senha, para acessar o sistema.
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
                                        <i class="fa fa-close"></i> Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success" id="btn-submit">Salvar</button>
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
            location.href = '{{ route('clientes.create') }}';
        });

        $( "#prazo" ).datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

    </script>
@endsection
