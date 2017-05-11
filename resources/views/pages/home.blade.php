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
        <div class="current-stats">
            <div class="row">
                @foreach($statuses as $status)
                    <div class="col-lg-2 col-md-4 col-sm-4 col-xs-6 status-block">
                        <div class="{{ $status->class }} status-btn center-align-text">
                            <div class="spacer-xs">
                                <i class="fa fa-github fa-2x"></i>
                                <small class="text-white">{{ $status->status }}</small>
                                <h3 class="no-margin no-padding">9%</h3>
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
                            <h5 class="blog-title">Network</h5>
                        </div>
                        <div class="blog-body">
                            <div class="row">
                                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                    <div id="us-map" class="chart-height-lg"></div>
                                </div>
                                <div class="visitors-total">
                                    <h3>{{ $correspondentes_count }}</h3>
                                    <p>Total Correspondentes</p>
                                </div>
                                <div class="visit-stats">
                                    <ul class="clearfix">
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-1" style="width:48px; height: 48px;"></div>
                                                <span>65%</span>
                                            </div>
                                            <h2 class="text-danger">7235</h2>
                                            <p>Overprice</p>
                                        </li>
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-2" style="width:48px; height: 48px;"></div>
                                                <span>17%</span>
                                            </div>
                                            <h2 class="text-info">3269</h2>
                                            <p>Ok</p>
                                        </li>
                                        <li>
                                            <div class="donut animated rubberBand">
                                                <div id="donut-chart-3" style="width:48px; height: 48px;"></div>
                                                <span>32%</span>
                                            </div>
                                            <h2 class="text-success">5972</h2>
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
                                        <th style="width: 23px;" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-sort="ascending" aria-label="
															: activate to sort column descending">
                                            <input type="checkbox">
                                        </th>
                                        <th style="width: 149px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Date: activate to sort column ascending">Prazo</th>
                                        <th style="width: 191px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Inv. No: activate to sort column ascending">Proc. Nº</th>
                                        <th style="width: 539px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Client Details: activate to sort column ascending">Cliente</th>
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Status</th>
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Status: activate to sort column ascending">Urgência</th>
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">Serviços
                                        <th style="width: 190px;" class="sorting" role="columnheader" tabindex="0" aria-controls="data-table" rowspan="1" colspan="1" aria-label="Balance: activate to sort column ascending">Ações
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                        @foreach($diligencias_destaque as $diligencia)
                                            <tr class="gradeX odd">
                                                <td class="  sorting_1">
                                                    <input type="checkbox">
                                                </td>
                                                <td class=" ">{{ $diligencia->prazo->diffForHumans() }}</td>
                                                <td class=" ">{{ $diligencia->num_processo }}</td>
                                                <td class=" ">
                                                    <a href="invoice.html" data-original-title="" title="">
                                                        {{ $diligencia->advogado->cliente->nome or '' }} - <small>{{ $diligencia->advogado->nome or '' }}</small>
                                                    </a>
                                                </td>
                                                <td class=" ">
                                                    <span class="label label-info {{$diligencia->status->class }}">{{ $diligencia->status->status or ''}}</span>
                                                </td>
                                                <td class=" ">
                                                    <span class="label label-info">{{ $diligencia->urgencia }}</span>
                                                </td>
                                                <td class=" ">
                                                    <span class="text-primary">{{ $diligencia->total }}</span>
                                                </td>
                                                <td class=" ">
                                                    <span class="btn btn-sm btn-info btn-rounded btn-transparent">
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
                            <h5 class="blog-title">Correspondentes Menos Ocupados</h5>
                        </div>
                        <div class="blog-body">
                            <ul class="clients-list">
                                @foreach ($correspondentes_menos_ocupados as $correspondente)
                                    <li class="client clearfix">
                                        <img src="img/user4.jpg" class="avatar" alt="Client">
                                        <div class="client-details">
                                            <p>
                                                <span class="name">{{ $correspondente->nome }}</span>
                                                <span class="email">{{ $correspondente->email }}</span>
                                            </p>
                                            <ul class="icons-nav">
                                                <li>
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Delete">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Email">
                                                        <i class="fa fa-envelope-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#" data-toggle="tooltip" data-placement="left" title="Contact">
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

    <!-- Addons starts -->
    <div class="add-on clearfix">
        <div class="add-on-wrapper">
            <h5>Tasks</h5>
            <section class="todo">
                <fieldset class="todo-list">
                    <label class="todo-list-item info">
                        <input type="checkbox" class="todo-list-cb">
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">Attend seminar</span>
                    </label>
                    <label class="todo-list-item danger">
                        <input type="checkbox" class="todo-list-cb">
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">UX workshop</span>
                    </label>
                    <label class="todo-list-item success">
                        <input type="checkbox" class="todo-list-cb" checked>
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">Pickup kids @4pm</span>
                    </label>
                    <label class="todo-list-item danger">
                        <input type="checkbox" class="todo-list-cb" checked>
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">Send wishes</span>
                    </label>
                    <label class="todo-list-item success">
                        <input type="checkbox" class="todo-list-cb">
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">Redesign Application</span>
                    </label>
                    <label class="todo-list-item info">
                        <input type="checkbox" class="todo-list-cb" checked>
                        <span class="todo-list-mark"></span>
                        <span class="todo-list-desc">Send an email</span>
                    </label>
                </fieldset>
            </section>
        </div>
    </div>
    <!-- Addons ends -->

    <!-- Addons starts -->
    <div class="add-on clearfix">
        <div class="add-on-wrapper clearfix">
            <h5>Notifications</h5>
            <a href="#" class="btn btn-xs btn-success" id="success">Success</a>
            <a href="#" class="btn btn-xs btn-danger" id="error">Error</a>
            <a href="#" class="btn btn-xs btn-info" id="custom">Custom</a>
            <a href="#" class="btn btn-xs btn-warning" id="notification">Standard</a>
            <a href="#" class="btn btn-xs btn-fb" id="forever">Persistent</a>
            <a href="#" class="btn btn-xs btn-linkedin" id="delay">Hide in 10 secs</a>
        </div>
    </div>
    <!-- Addons ends -->

    <!-- Addons starts -->
    <div class="add-on clearfix">
        <h5>Usage</h5>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="light-grey-bg">
                    <div class="spacer-xs">
                        <p class="center-align-text text-primary no-margin">MEMORY</p>
                        <p class="center-align-text text-primary">10 GB</p>
                        <ul class="cpu-memory">
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                            <li class="cpu">&nbsp;</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="light-grey-bg">
                    <div class="spacer-xs">
                        <p class="center-align-text text-black no-margin">CPU</p>
                        <p class="center-align-text text-black">59.5%</p>
                        <ul class="cpu-memory">
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li>&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                            <li class="memory">&nbsp;</li>
                        </ul>
                    </div>
                </div>
            </div>
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
@endsection