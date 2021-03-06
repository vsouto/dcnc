@extends('layouts.app')

@section('content')
    @if (Auth::user()->level >= 4)
        @include('elements.top-bar', ['title' => 'Diligências'])
    @endif

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
                        @if (!$diligencia->comarca)
                            <div class="alert alert-warning alert-white rounded">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
                                <strong>Alerta!</strong> Não existe nenhuma comarca vinculada à esta diligência!
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
                                            @if (Auth::user()->level >= 5 && $diligencia->status_id <= 7)
                                                <button type="button" class="btn btn-success" id="edit_diligencia"><i class="fa fa-pencil"></i> <span class="hidden-xs">Editar</span></button>
                                                <button type="button" class="btn btn-danger"><i class="fa fa-envelope-o"></i> <span class="hidden-xs">Email</span></button>
                                            @endif
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
                                            <td id="">{{ $diligencia->prazo->diffForHumans() }} ({{ $diligencia->prazo->format('d/m/Y H:i') }})</td>
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
                                            <td id="">{{ $diligencia->comarca->comarca or '' }}</td>
                                            <td class="invoice_info_header_td info"><strong>Vara</strong></td>
                                            <td id="">{{ $diligencia->vara }}</td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Local</strong></td>
                                            <td id="" colspan="">{{ $diligencia->local_orgao }}</td>
                                            <td class="invoice_info_header_td info"><strong>Audiência?</strong></td>
                                            <td id="">{{ $diligencia->audiencia? 'Sim' : 'Não' }}</td>
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
                                            <td id="invoice_vessel" colspan="3">
                                                @if ($diligencia->correspondente)
                                                    {{ $diligencia->correspondente->nome }} {!! getRatingStars($diligencia->correspondente->rating) !!}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="invoice_info_header_td info"><strong>Serviço</strong></td>
                                            <td id="" colspan="3">{{ $diligencia->servicos->first()->servico}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>

                                    @if (Auth::user()->level >= 5 || \App\Diligencia::isCurrentCorrespondente($diligencia))
                                        @include('diligencias.servicos')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Widget starts -->
                        <div class="blog blog-success">
                            <div class="blog-header">
                                <h5 class="blog-title">Ações</h5>
                            </div>
                            <div class="blog-body">
                                Se houver alguma ação a ser tomada nesta Diligência, ela poderá ser realizada aqui.
                                <br>
                                <br>
                                @if ( Auth::user()->level == '1')
                                    @include('diligencias.acoes_correspondente')
                                @elseif ( Auth::user()->level == '2')
                                    @include('diligencias.acoes_cliente')
                                @elseif ( Auth::user()->level == '3')

                                @elseif ( Auth::user()->level == '4')

                                @elseif ( Auth::user()->level >= '5')
                                    @include('diligencias.acoes_coordenador')
                                @endif

                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>

                </div>
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
                                            @if (Storage::disk('uploads')->exists($file->filename))
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
                                                                <a href="{{ asset($file->filepath) }}" title="" target="_blank">
                                                                    <i class="fa fa-download"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </li>
                                            @else
                                                <li class="client clearfix">
                                                    <i class="fa fa-ambulance pull-left fa-lg fa-3x"></i> Arquivo não existe ou está corrompido.
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- Widget ends -->
                    </div>
                </div>

            </div>
            <!-- Spacer ends -->
        </div>
    </div>


<!-- Right sidebar starts -->
<div class="right-sidebar">

    @if (\App\Diligencia::isCurrentCorrespondente($diligencia))
        <!-- Addons starts -->
        <div class="add-on clearfix">
            <div class="add-on-wrapper">
                <h5>Ações</h5>
                <section class="">
                    <fieldset class="">
                        <label class="todo-list-item info">
                            <button type="button" class="btn btn-default "><i class="fa fa-bullhorn"></i> Solicitar Documentos</button>
                        </label>
                        <label class="todo-list-item success">
                            <button type="button" class="btn btn-success "><i class="fa fa-cloud-upload"></i> Atualizar perfil</button>
                        </label>
                    </fieldset>
                </section>
            </div>
        </div>
    <!-- Addons ends -->
    @endif

    @if (Auth::user()->level >= 5 && $diligencia->status_id <= 2)
        <!-- Addons starts -->
        <div class="add-on clearfix">
            <div class="add-on-wrapper">
                <h5>Ações</h5>
                <section class="">
                    <fieldset class="">
                        <label class="todo-list-item danger">
                            <button type="button" class="btn btn-default btn-danger" id="cancel-diligencia"><i class="fa fa-bullhorn"></i> Cancelar Diligência</button>
                        </label>
                    </fieldset>
                </section>
            </div>
        </div>
        <!-- Addons ends -->
    @endif
</div>
<!-- Right sidebar ends -->
@endsection

@section('footer')

    <script>
        $('#new').click(function(){
            location.href = '{{ route('diligencias.create') }}';
        });

        $('#cancel-diligencia').click(function(){

            if (confirm('Confirma cancelar esta diligência?'))
                location.href = '{{ route('diligencias.cancelar',['id' => $diligencia->id]) }}';
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

            $('#form-devolver-correspondente').show();
        });

        $('#acao-devolver-confirma').click(function(){

            if( $('#revisao_instrucoes').val().length < 5) {
                alert('Digite ao menos 5 caracteres de instruções.');
            }
            else {
                $('#form-devolver').submit();
            }

            //location.href = '{{ route('diligencias.devolver', ['id' => $diligencia->id]) }}';
        });

        $('#acao-resolver-confirma').click(function(){

            if( $('#revisao_resolucao').val().length < 5) {
                alert('Digite ao menos 5 caracteres de informações.');
            }
            else {
                $('#form-resolver').submit();
            }

            //location.href = '{{ route('diligencias.resolver', ['id' => $diligencia->id]) }}';
        });

        $('#acao-concluir').click(function(){

            $('#form-concluir').submit();
            //location.href = '{{ route('diligencias.concluir', ['id' => $diligencia->id]) }}';
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

        $('.select-correspondente').click(function(){

            var id = $(this).data('ref');
            var diligencia_id = '{{ $diligencia->id }}';

            location.href = '{{ route('diligencias.selecionarCorrespondente') }}/' + id + '/' + diligencia_id;
        });

    </script>
@endsection
