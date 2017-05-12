@extends('layouts.app')

@section('content')
        <!-- Top Bar starts -->
<div class="top-bar">
    <div class="page-title">
        Dashboard
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

            <!-- Row Starts -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-success no-margin">
                        <div class="panel-heading">
                            <div class="text-left" style="float:left">
                                <h4 class="panel-title">Diligências</h4>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-info btn-rounded" id="new">Nova</button>
                            </div>
                        </div>
                        <div class="blog-body">
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
            <!-- Row Ends -->

            <br style="clear:both">


        </div>
        <!-- Spacer ends -->

    </div>
    <!-- Container fluid ends -->
</div>
<!-- Main Container ends -->

<!-- Right sidebar starts -->
<div class="right-sidebar">

    <!-- Addons starts -->
    <div class="add-on clearfix">
        <div class="add-on-wrapper">
            <h5>Ações</h5>
            <section class="">
                <fieldset class="">
                    <label class="todo-list-item info">
                        <button type="button" class="btn btn-default "><i class="fa fa-bullhorn"></i> Solicitar Documentos</button>
                    </label>
                    <label class="todo-list-item danger">
                        <button type="button" class="btn btn-danger "><i class="fa fa-bolt"></i> Contestar</button>
                    </label>
                    <label class="todo-list-item success">
                        <button type="button" class="btn btn-success "><i class="fa fa-cloud-upload"></i> Atualizar dados</button>
                    </label>
                </fieldset>
            </section>
        </div>
    </div>
    <!-- Addons ends -->


</div>
<!-- Right sidebar ends -->
@endsection

@section('footer')

    <!-- JVector Map -->
    <script src="{{ asset('js/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('js/jvectormap/jquery-jvectormap-usa.js') }}"></script>

    <script src="{{ asset('js/jvectormap/maps/brazil.js') }}"></script>

    <!-- chart -->
    <script src="{{ asset('js/flot/custom/stacked-dashboard.js') }}"></script>

    <script src="{{ asset('js/custom-index.js') }}"></script>

    <script>
        $('.view-diligencia').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });

        $('#new').click(function(){
            location.href = '{{ route('diligencias.create') }}';
        });

    </script>
@endsection