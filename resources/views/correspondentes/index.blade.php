@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Correspondentes'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container">

        <!-- Container fluid Starts -->
        <div class="container-fluid">
            <div class="spacer">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="text-left" style="float:left">
                                <h4 class="panel-title">Correspondentes</h4>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-info btn-rounded" id="new">Novo</button>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dt_example" class="table-responsive example_alt_pagination clearfix">
                                    <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                                        {!! $grid->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>

        $('#new').click(function(){
            location.href = '{{ route('correspondentes.create') }}';
        });

        $('.edit-entity').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });

        $('.edit-comarcas').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });

    </script>
@endsection