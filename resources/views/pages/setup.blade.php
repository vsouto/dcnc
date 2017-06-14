@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Setup'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container-fulll">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <div class="spacer">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="blog">
                        <div class="blog-header"><div class="text-left" style="float:left">
                                <h4 class="blog-title">Serviços</h4>
                            </div>
                            <div class="text-right">
                            </div>
                        </div>
                        <div class="calls-body">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 scrolled">
                                    <form id="setup_servicos" method="post" action="{{ route('servicos.store') }}" class="form-horizontal" enctype="multipart/form-data">
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
                                        <table class="table no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Serviço</th>
                                                <th>Ideal</th>
                                                <th>Máximo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($servicos as $servico)
                                            <tr>
                                                <td>{{ $servico->id }}</td>
                                                <td>{{ $servico->servico }}</td>
                                                <td><input type="text" name="{{ $servico->servico }}[ideal]" value="{{ $servico->ideal }}"></td>
                                                <td><input type="text" name="{{ $servico->servico }}[max]" value="{{ $servico->max }}"></td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <button type="button" class="btn btn-info" id="salvar_servicos">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')

    <!-- Float panel -->
    <script type="text/javascript" src="{{ URL::asset('js/floatThead/jquery.floatThead.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/floatThead/jquery.floatThead-slim.min.js') }}"></script>

    <!-- daterangePicker -->
    <script type="text/javascript" src="{{ URL::asset('js/daterangepicker/daterangepicker.js') }}"></script>
    <link href="{{ asset('js/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" >

    <script>

        $('#salvar_servicos').click(function() {

            $('#setup_servicos').submit();
        });
    </script>
@endsection
