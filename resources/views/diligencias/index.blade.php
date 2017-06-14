@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Diligências'])
    @endif

    <!-- Main Container starts -->
    <div class="main-container-fulll">

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
                                        <i class="fa fa-tag fa-2x"></i>
                                        <small class="text">{{ $status->status }}</small>
                                        <h3 class="no-margin no-padding {{ $status->slug  }}-content text-center status-loader"><i class="fa fa-refresh fa-spin fa-2x"></i></h3>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Current Stats End -->

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="blog">
                        <div class="blog-header"><div class="text-left" style="float:left">
                                <h4 class="blog-title">Diligências</h4>
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-info btn-rounded" id="new">Nova</button>
                            </div>
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

        $(document).ready(function(){

            // Refresh the page in 3,5 minutes
            setTimeout(function(){
                location.reload();
            }, 350000);

            setFloatingTableHead( '#Diligencias' );

            //$('#Diligencias').css('table-layout','fixed');
        });

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

            //$('.status-loader').html('<i class="fa fa-refresh fa-spin fa-2x"></i>');

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
