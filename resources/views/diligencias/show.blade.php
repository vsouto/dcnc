@extends('layouts.app')

@section('content')
        <!-- Top Bar starts -->
    <div class="top-bar">
        <div class="page-title">
            Visualizando Diligência
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

                <div class="row">
                    @if (session('message'))
                        <div class="alert alert-success alert-white rounded">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <div class="icon"><i class="fa fa-check"></i></div>
                            <strong>{{ session('message') }}</strong>
                        </div>
                    @endif
                    @if (!$diligencia->advogado->cliente)
                        <div class="alert alert-warning alert-white rounded">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <strong>Alerta!</strong> Não existe nenhum cliente vinculado à esta diligência!
                        </div>
                    @endif
                    @if (!$diligencia->correspondente_id)
                        <div class="alert alert-warning alert-white rounded">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                            <strong>Alerta!</strong> Ainda não existe nenhum correspondente vinculado à esta diligência!
                        </div>
                    @endif
                    <div class="col-md-12 col-sm-12 col-sx-12">
                        <div class="panel no-margin"  id="printable">
                            <div class="panel-heading">
                                <h4 class="panel-title">Diligência <span class="text-danger">#{{ $diligencia->id }}</span>
                                </h4>
                                <i class="custom-text">Criada - <small class="text-success">{{ $diligencia->created_at }}</small></i>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-sx-12">
                                        <div class="img-responsive pull-left">
                                            <img src="{{ asset('img/dcnc.png') }}" alt="DCNC Advogados" width="160px">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-sx-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-info" id="print"><i class="fa fa-print"></i> <span class="hidden-xs">Print</span></button>
                                            <button type="button" class="btn btn-success" id="edit_diligencia"><i class="fa fa-pencil"></i> <span class="hidden-xs">Editar</span></button>
                                            <button type="button" class="btn btn-danger"><i class="fa fa-envelope-o"></i> <span class="hidden-xs">Email</span></button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="less-margin">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td style="width:50%">
                                                <address class="no-margin">
                                                    <h4><strong>DCNC Advogados</strong></h4>
                                                    <strong>Av Raja Gabáglia 1617, 6º e 7º andares</strong> <br>
                                                    <abbr title="email">E-mail:</abbr>
                                                    <a href="mailto:contato@dcncadvogados.com.br" data-original-title="" title="">contato@dcncadvogados.com.br</a><br>
                                                    <abbr title="Phone">Phone:</abbr> 55 (31) 3274-5668<br>
                                                </address>
                                            </td>
                                            <td style="width:50%" class="right-align-text">
                                                @if ($diligencia->advogado->cliente)
                                                    <address class="no-margin">
                                                        <h4><strong>{{ $diligencia->advogado->cliente->nome }} </strong></h4>
                                                        <strong>{{ $diligencia->advogado->cliente->endereco }}</strong> <br>
                                                        <abbr title="email">E-mail:</abbr>
                                                        <a href="mailto:{{ $diligencia->advogado->cliente->email }}" data-original-title="" title="">{{ $diligencia->advogado->cliente->email }}</a><br>
                                                        <abbr title="Phone">Phone:</abbr> {{ $diligencia->advogado->cliente->phone }}<br>
                                                    </address>
                                                @else
                                                    <address class="no-margin">
                                                        Sem cliente associado
                                                    </address>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                                <h4><strong>Informações Gerais</strong></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover no-margin">
                                        <tbody>
                                        <tr>
                                            <td class="invoice_info_header_td info" width="12%"><strong>Título</strong></td>
                                            <td id="" width="25%">{{ $diligencia->titulo }}</td>
                                            <td class="invoice_info_header_td info"  width="12%"><strong>ID</strong></td>
                                            <td id="">{{ $diligencia->id }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Descrição</strong></td>
                                            <td id="">{{ $diligencia->descricao }}</td>
                                            <td class="invoice_info_header_td info"><strong>Núm Processo</strong></td>
                                            <td id="">{{ $diligencia->num_processo }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Núm Integração</strong></td>
                                            <td id="">{{ $diligencia->num_integracao }}</td>
                                            <td class="invoice_info_header_td info"><strong>Prazo</strong></td>
                                            <td id="">{{ $diligencia->prazo->diffForHumans() }} ({{ $diligencia->prazo->format('d/m/Y h:i') }})</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Solicitante</strong></td>
                                            <td id="">{{ $diligencia->solicitante }}</td>
                                            <td class="invoice_info_header_td info"><strong>Urgência</strong></td>
                                            <td id="">{!! getUrgenciaClass($diligencia->urgencia) !!}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Réu</strong></td>
                                            <td id="">{{ $diligencia->reu }}</td>
                                            <td class="invoice_info_header_td info"><strong>Órgão</strong></td>
                                            <td id="">{{ $diligencia->orgao }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Comarca</strong></td>
                                            <td id="">{{ $diligencia->comarca->comarca }}</td>
                                            <td class="invoice_info_header_td info"><strong>Vara</strong></td>
                                            <td id="">{{ $diligencia->vara }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Local</strong></td>
                                            <td id="" colspan="3">{{ $diligencia->local_orgao }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Orientações</strong></td>
                                            <td id="" colspan="3">{{ $diligencia->orientacoes }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Status</strong></td>
                                            <td id="" colspan="3"><span class='badge {{ $diligencia->status->class}} edit-status'>{{ $diligencia->status->status}}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Correspondente</strong></td>
                                            <td id="invoice_vessel">
                                                @if ($diligencia->correspondente)
                                                    {{ $diligencia->correspondente->nome }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td id="" colspan="2">
                                                <button type="button" class="btn btn-danger">Cancelar Correspondente</button></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>

                                    <h4><strong>Serviços</strong></h4>
                                    @if ($diligencia->servicos->count() > 0 && $diligencia->correspondente)
                                        <table class="table table-striped table-bordered table-hover no-margin">
                                            <thead>
                                            <tr>
                                                <th style="width:10%">#</th>
                                                <th style="width:20%">Serviço</th>
                                                <th style="width:40%">Descrição</th>
                                                <th style="width:10%">Valor</th>
                                                <th style="width:10%">Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $total = 0; ?>
                                            @foreach ($diligencia->servicos as $servico)
                                                <?php $servico_correspondente = $diligencia->correspondente->servicos()->where('servico_id',$servico->id)->first(); ?>
                                                @if (!$servico_correspondente)
                                                    <tr>
                                                        <td>{{ $servico->id }}</td>
                                                        <td>{{ $servico->servico }}</td>
                                                        <td>
                                                            <span class="text-danger">Alerta: O correspondente não tem este serviço!</span>
                                                        </td>
                                                        <td>R$ </td>
                                                        <td></td>
                                                    </tr>
                                                @else
                                                    <?php $valor = $diligencia->correspondente->servicos()->where('servico_id',$servico->id)->first()->pivot->valor; ?>
                                                    <?php $total += $valor ?>
                                                    <tr>
                                                        <td>{{ $servico->id }}</td>
                                                        <td>{{ $servico->servico }}</td>
                                                        <td>
                                                            <span class="text-info">{{ $servico->descricao }}</span>
                                                        </td>
                                                        <td>R$ {{ $valor }}</td>
                                                        <td></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr>
                                                <td class="total" colspan="4">Subtotal</td>
                                                <td>R$ {{ $total }}</td>
                                            </tr>
                                            <tr>
                                                <td class="total" colspan="4">Taxas</td>
                                                <td>-</td>
                                            </tr>
                                            <tr class="warning">
                                                <td class="total text-warning" colspan="4"><h5>Total</h5></td>
                                                <td class="hidden-phone text-info"><h4>R$ {{ $total }}</h4></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <div class="alert alert-danger alert-white rounded">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                                            <strong>Alerta:</strong> Não existem serviços atrelados à esta diligência ou não existe um correspondente vinculado.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <br>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- Widget starts -->
                        <div class="blog blog-info">
                            <div class="blog-header">
                                <h5 class="blog-title">Histórico</h5>
                            </div>
                            <div class="blog-body">

                                <img src="{{ asset('img/historico.PNG') }}" style="opacity: 0.4;">
                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- Widget starts -->
                        <div class="blog blog-danger">
                            <div class="blog-header">
                                <h5 class="blog-title">Documentos</h5>
                            </div>
                            <div class="blog-body">
                                <ul class="clients-list">
                                    @if($diligencia->files->count() <= 0)
                                        Nenhum arquivo anexado.
                                    @else
                                        @foreach ($diligencia->files as $file)
                                            <li class="client clearfix">
                                                <i class="fa {{ getFileClass($file->filename) }} pull-left fa-lg fa-3x"></i>
                                                <div class="client-details">
                                                    <p>
                                                        <span class="name">{{ $file->titulo }}</span>
                                                        <span class="email">{{ $file->user->nome }}</span>
                                                    </p>
                                                    <ul class="icons-nav">
                                                        <li>
                                                            <a href="#" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete">
                                                                <i class="fa fa-trash-o"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ Storage::url($file->filename) }}" data-toggle="tooltip" data-placement="left" title="" data-original-title="Download">
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <!-- Widget starts -->
                        <div class="blog blog-success">
                            <div class="blog-header">
                                <h5 class="blog-title">Ações</h5>
                            </div>
                            <div class="blog-body">
                                Se houver alguma ação a ser tomada neste Diligência, ela poderá ser realizada aqui.
                                <br>
                                <br>
                                <div class="alert alert-warning alert-white rounded">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                                    <strong>Status Atual:</strong> {{ $diligencia->status->status }}
                                </div>
                                {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
                                <br>
                                <br>
                                @if ($diligencia->status_id == 6 && Auth::user()->level >= 5)
                                    <h4>Correspondentes Recomendados</h4>
                                    @if(!$correspondentes_recomendados || $correspondentes_recomendados->count() <= 0)
                                        <div class="alert alert-danger alert-white rounded">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                            <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                                            <strong>Alerta:</strong> Não foram encontrados correspondentes nesta comarca ou existem erros nesta Diligência!
                                        </div>
                                        <br><button type="button" class="btn btn-info btn-rounded" id="criar-correspondente">Criar Correspondente</button>
                                    @else
                                        <table class="table table-hover no-margin">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Comarca</th>
                                                <th>Nome</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>Endereço</th>
                                                <th>Avaliação</th>
                                                <th>Valor</th>
                                                <th>Selecionar</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($correspondentes_recomendados as $correspondente)
                                                <?php if (!$correspondente->user) { continue; } ?>
                                                <tr>
                                                    <td class="danger">{{ $correspondente->id }}</td>
                                                    <td class="info">{{ $diligencia->comarca->comarca}}</td>
                                                    <td class="warning">{{ $correspondente->nome }}</td>
                                                    <td class="success">{{ $correspondente->user->email or '' }}</td>
                                                    <td class="success">{{ $correspondente->user->phone or '' }}</td>
                                                    <td class="success">{{ $correspondente->user->endereco or '' }}</td>
                                                    <td class="success">{!! getRatingStars($correspondente->rating) !!}</td>
                                                    <td class="success">
                                                        @foreach($diligencia->servicos as $servico)
                                                            {{ 'R$ ' . $correspondente->servicos()->where('servico_id',$servico->id)->first()->pivot->valor }}
                                                        @endforeach
                                                    </td>
                                                    <td class="success">
                                                        <button type="button"
                                                                class="btn btn-info btn-rounded btn-transparent"
                                                                id="select-correspondente"
                                                                data-ref="{{ $correspondente->id }}">Selecionar</button></td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>

                </div>

            </div>
            <!-- Spacer ends -->
        </div>
    </div>
@endsection

@section('footer')

    <script>
        $('#new').click(function(){
            location.href = '{{ route('diligencias.create') }}';
        });

        $('#acao-aceitar').click(function(){

            location.href = '{{ route('diligencias.aceitar', ['id' => $diligencia->id]) }}';
        });

        $('#acao-checkin').click(function(){


            location.href = '{{ route('diligencias.checkin', ['id' => $diligencia->id]) }}';
        });

        $('#acao-aprovar').click(function(){

            location.href = '{{ route('diligencias.aprovar', ['id' => $diligencia->id]) }}';
        });

        $('#acao-devolver').click(function(){

            location.href = '{{ route('diligencias.devolver', ['id' => $diligencia->id]) }}';
        });

        $('#acao-concluir').click(function(){

            location.href = '{{ route('diligencias.concluir', ['id' => $diligencia->id]) }}';
        });

        $('#print').click(function(){

            PrintElem( $('#printable'));
        });

        $('#edit_diligencia').click(function(){

            location.href = '{{ route('diligencias.edit',['id' => $diligencia->id]) }}';
        });
        $('#criar-correspondente').click(function(){

            location.href = '{{ route('correspondentes.create') }}';
        });

        $('#select-correspondente').click(function(){

            var id = $(this).data('ref');
            var diligencia_id = '{{ $diligencia->id }}';

            location.href = '{{ route('diligencias.selecionarCorrespondente') }}/' + id + '/' + diligencia_id;
        });

    </script>
@endsection
