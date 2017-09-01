@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Users'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <!-- Spacer starts -->
            <div class="spacer">
                {{ Form::model($user, ['class' => 'form-horizontal','route' => ['users.update', $user->id],
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
                                                <div class="form-group resto-form" id="" style="display: block;">

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
                                                            <div class="alert alert-info alert-transparent">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                                <strong>Obs:</strong> Apenas digite uma nova senha se quiser alterá-la.
                                                            </div>
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
                                                    <div class="form-group">
                                                        <label class="col-lg-6 control-label">Nível</label>
                                                        <div class="col-lg-6">
                                                            {{ Form::select('level', $levels, null, [
                                                                'class' => 'form-control ',
                                                                'id'    => 'level'
                                                                ]) }}
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


    <script>

        $(function() {



        });

    </script>
@endsection
