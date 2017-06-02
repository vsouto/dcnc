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

        <!-- Spacer starts -->
        <div class="spacer">
            <!-- Row Start -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Widget starts -->
                    <div class="blog">
                        <div class="blog-header">
                            <h5 class="blog-title">Rede</h5>
                        </div>
                        <div class="blog-body">
                            <div class="row">
                                <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12">
                                    <div id="map" class="chart-height-lg"></div>
                                </div>
                                <div class="visitors-total">
                                    <h3 id="total_correspondentes">{{ $correspondentes_count }}</h3>
                                    <p>Total Correspondentes</p>
                                </div>
                                <div class="visit-stats">
                                    <ul class="clearfix">
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-1" style="width:48px; height: 48px;"></div>
                                                <span id="">{{ $correspondentes_overprice }}</span>
                                            </div>
                                            <h2 class="text-danger" id="correspondentes_overprice">{{ $correspondentes_overprice }}</h2>
                                            <p>Overprices</p>
                                        </li>
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-2" style="width:48px; height: 48px;"></div>
                                                <span id="">{{ calculateRatingPercentage($correspondentes_rating_avg) }}%</span>
                                            </div>
                                            <h2 class="text-info" id="correspondentes_rating_avg">{{ number_format($correspondentes_rating_avg,0,'','.') }}</h2>
                                            <p>Rating Médio</p>
                                        </li>
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-3" style="width:48px; height: 48px;"></div>
                                                <span>{{ getCorrespondentesUsoPercentage($correspondentes_em_uso, $correspondentes_count) }}%</span>
                                            </div>
                                            <h2 class="text-success" id="correspondentes_uso">{{ $correspondentes_em_uso }}</h2>
                                            <p>Em Uso</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Widget ends -->
                </div>
            </div>
            <!-- Row End -->

            <!-- Row Starts -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="blog blog-success no-margin">
                        <div class="blog-header">
                            <h5 class="blog-title">Diligências em Destaque</h5>
                        </div>
                        <div class="blog-body">
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-hover table-bordered pull-left dataTable" id="data-table" aria-describedby="data-table_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 149px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="">Urgência</th>
                                        <th style="width: 149px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="">Prazo</th>
                                        <th style="width: 191px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Inv. No: activate to sort column ascending">Proc. Nº</th>
                                        <th style="width: 539px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Client Details: activate to sort column ascending">Cliente</th>
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">Ações
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        @foreach($diligencias_destaque as $diligencia)
                                            <tr class="gradeX odd">
                                                <td class=" ">{!! getUrgenciaClass($diligencia->urgencia)!!}</td>
                                                <td class=" ">{{ $diligencia->prazo->diffForHumans() }}</td>
                                                <td class=" ">{{ $diligencia->num_processo }}</td>
                                                <td class=" ">
                                                    <a href="invoice.html" data-original-title="" title="">
                                                        {{ $diligencia->advogado->cliente->nome or '' }} - <small>{{ $diligencia->advogado->nome or '' }}</small>
                                                    </a>
                                                </td>
                                                <td class=" ">
                                                    <span class="badge {{$diligencia->status->class }}">{{ $diligencia->status->status or ''}}</span>
                                                </td>
                                                <td class=" ">
                                                    <span class="btn btn-sm btn-info btn-rounded btn-transparent view-diligencia" data-ref="{{ route('diligencias.show',['id' => $diligencia->id]) }}">
                                                        <i class="fa fa-eye"></i></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row Ends -->

            <br style="clear:both">
            <!-- Row Start -->
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <!-- Widget starts -->
                    <div class="blog blog-danger">
                        <div class="blog-header">
                            <h5 class="blog-title">Correspondentes Com Mais Atrasos</h5>
                        </div>
                        <div class="blog-body">
                            <ul class="clients-list">
                                @foreach ($correspondentes_mais_atrasos as $correspondente)
                                    <li class="client clearfix">
                                        <img src="img/user4.jpg" class="avatar" alt="Client">
                                        <div class="client-details">
                                            <p>
                                                <span class="name">{{ $correspondente->nome }}</span>
                                                <span class="email">{{ $correspondente->email }}</span>
                                            </p>
                                            <ul class="icons-nav">
                                                <li>
                                                    {{ $correspondente->atrasos }}
                                                </li>
                                                <li>
                                                    <a href="mailto:{{ $correspondente->user->email }}" data-toggle="tooltip" data-placement="left" title="Email">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="tel:{{ $correspondente->user->phone }}" data-toggle="tooltip" data-placement="left" title="Contact">
                                                        <i class="fa fa-phone"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Widget ends -->
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="blog">
                            <div class="blog-header">
                                <h5 class="panel-title">Situação das Diligências</h5>
                            </div>
                            <div class="blog-body">
                                <div id="stacked-area-chart" class="chart-height"></div>
                            </div>
                        </div>
                </div>

            </div>
            <!-- Row End -->

        </div>
        <!-- Spacer ends -->

    </div>
    <!-- Container fluid ends -->
</div>
<!-- Main Container ends -->

<!-- Right sidebar starts -->
<div class="right-sidebar">


</div>
<!-- Right sidebar ends -->
    @include('elements.scripts')

@endsection

@section('footer')

    <!-- chart -->
    <script src="{{ asset('js/flot/custom/stacked-dashboard.js') }}"></script>
    <script src="{{ asset('js/custom-index.js') }}"></script>

    <script src="{{ asset('js/maps/brazil.js') }}"></script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={{ Config::get('constants.MAPS_KEY') }}&callback=initMap">
    </script>

    <script>
        $('.view-diligencia').click(function(){

            var ref = $(this).data('ref');

            location.href = ref;
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