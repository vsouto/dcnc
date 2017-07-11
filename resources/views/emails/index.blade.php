@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Emails'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container-fulll">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <div class="spacer">
                @if(Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                <div class="blog-header">
                    <h4 class="blog-title">Emails</h4>
                </div>
                <div class="calls-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 scrolled">
                            {!! $grid->render() !!}
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

        $('#salvar_configs').click(function() {

            $('#setup_configs').submit();
        });
    </script>
@endsection
