@extends('layouts.app')

@section('content')
    <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Diligências
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
            <div class="spacer">

                <!-- Current Stats Start -->
                <div class="current-stats" id="statuses">
                    <div class="row">
                        @foreach($statuses as $status)
                            <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 status-block">
                                <div class="{{ $status->class }} status-btn center-align-text">
                                    <div class="spacer-xs">
                                        <i class="fa fa-github fa-2x"></i>
                                        <small class="text">{{ $status->status }}</small>
                                        <h3 class="no-margin no-padding {{ $status->slug  }}-content"></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Current Stats End -->

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel">
                        <div class="panel-heading"><div class="text-left" style="float:left">
                                <h4 class="panel-title">Diligências</h4>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-info btn-rounded" id="new">Nova</button>
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
            location.href = '{{ route('diligencias.create') }}';
        });

        $('.acao-negociar').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });

        $('.view-diligencia').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });
        $('.edit-diligencia').click(function(){
            var ref = $(this).data('ref');

            location.href = ref;
        });

        /*
         * Define Statuses clicks
         */
        $('.sondagem').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('1');
            $('#filter-btn').click();
        });
        $('.aguardando-confirmacao').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('2');
            $('#filter-btn').click();
        });
        $('.aguardando-checkin').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('3');
            $('#filter-btn').click();
        });
        $('.aguardando-conclusao').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('4');
            $('#filter-btn').click();
        });
        $('.sem-checkin').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('5');
            $('#filter-btn').click();
        });
        $('.em-negociacao').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('6');
            $('#filter-btn').click();
        });
        $('.atrasada').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('7');
            $('#filter-btn').click();
        });
        $('.em-revisao').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('8');
            $('#filter-btn').click();
        });
        $('.devolvida').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('9');
            $('#filter-btn').click();
        });
        $('.pagamento-autorizado').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('10');
            $('#filter-btn').click();
        });
        $('.efetivada').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('11');
            $('#filter-btn').click();
        });
        $('.cancelada').click(function(){
            $('[name="Diligencias[filters][status_id-in][]"]').val('12');
            $('#filter-btn').click();
        });

        // Dashboard status
        $('#statuses').html(function(){

            $.ajax({
                url: "{{ route('status.getStatusesPercentages') }}",
                dataType: "html",
                type: "GET"
            }).done(function(data) {

                populateStatusFields(data);
            });
        });

    </script>
@endsection
