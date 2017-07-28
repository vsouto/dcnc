
<br>

@if ($diligencia->status_id == 8)
    <!-- Em Revisão -->
    <h4>Em Revisão</h4>
    <div class="alert alert-info alert-white rounded">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
        <strong>Atenção:</strong> Esta diligência está aguardando a sua revisão para ser finalizada.
    </div>
    <div class="panel-group no-margin" id="accordion">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-danger collapsed" data-original-title="" title="">
                        Resolução
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                   O Correspondente enviou as seguintes informações:
                    <br>
                    <br>
                    <label>Realizado com sucesso?</label>
                    {{ $diligencia->realizado_sucesso? 'Sim' : 'Não' }}
                    <br>
                    <label>Realizador Nome</label>
                    {{ $diligencia->realizador_nome or 'Ele mesmo' }}
                    <br>
                    <label>Realizador Telefone</label>
                    {{ $diligencia->realizador_telefone or 'Ele mesmo' }}
                    <br>
                    <label>Realizador Email</label>
                    {{ $diligencia->realizador_email or 'Ele mesmo' }}
                    <br>
                    @if ($diligencia->revisao_resolucao)
                        <label>Informações de Revisão:</label>
                        {{ $diligencia->revisao_resolucao or 'Ele mesmo' }}
                        <br>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="text-danger" data-original-title="" title="">
                        Revisar
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    Ao clicar em <b>Aprovar</b> você concorda com a resolução do correspondente descrita acima.
                    <br>
                    <br>
                    Clicando em <b>Reprovar</b>, você retorna a diligência para que o correspondente complete com as informações que você o instruir.
                    <br>
                    <br>
                    {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
                    <br>
                    <div id="form-devolver-correspondente" style="display: none;">
                        <form id="form-devolver" method="post" action="{{ route('diligencias.devolver',['id' => $diligencia->id]) }}" class="form-horizontal" enctype="multipart/form-data">
                        {{ Form::token() }}
                            <label>Instruções para Revisão: </label><br>
                            <textarea name="revisao_instrucoes" class="form-control" id="revisao_instrucoes" cols="200" rows="6"></textarea>
                            <br style="clear: both;">
                            <button type="button" class="btn btn-info btn-rounded" id="acao-devolver-confirma">Devolver</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif