
<br>

@if ($diligencia->status_id == 2)
    <!-- Aguardando Confirmação -->
    <h4>Aguardando Confirmação</h4>
    <div class="alert alert-info alert-white rounded">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
        <strong>Atenção:</strong> Esta diligência está aguardando a sua confirmação de aceitação para iniciar.
    </div>
    <div class="panel-group no-margin" id="accordion">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-danger collapsed" data-original-title="" title="">
                        Contrato
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="text-danger" data-original-title="" title="">
                        Informações de Uso
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <h4>Como aceitar a Diligência</h4>
                    <p>Lore Ipsum Lore Ipsum Lore Ipsum </p>
                    <h4>Checkin</h4>
                    <p>Lore Ipsum Lore Ipsum Lore Ipsum </p>
                    <h4>Conclusão do trabalho</h4>
                    <p>Lore Ipsum Lore Ipsum Lore Ipsum </p>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="text-danger" data-original-title="" title="">
                        Aceitação
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    Ao clicar em aceitar você concorda com o Contrato acima e termos de uso da plataforma.
                    <br>
                    <br>
                    {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
                </div>
            </div>
        </div>
    </div>
@elseif ($diligencia->status_id == 4 || $diligencia->status_id == 7)
    <!-- Aguardando Conclusão -->
    <h4>Aguardando Conclusão</h4>
    <div class="alert alert-info alert-white rounded">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
        <strong>Atenção:</strong> Esta diligência está aguardando a sua conclusão.
    </div>
    <div class="panel-group no-margin" id="accordion">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-danger collapsed" data-original-title="" title="">
                        Contrato
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="text-danger" data-original-title="" title="">
                        Informações de Uso
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <h4>Como aceitar a Diligência</h4>
                    <p>.... </p>
                    <h4>Checkin - Como funciona</h4>
                    <p>...</p>
                    <h4>Conclusão do Trabalho</h4>
                    <p>...</p>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="text-danger" data-original-title="" title="">
                        Conclusão
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <form id="form-concluir" method="post" action="{{ route('diligencias.concluir',['id' => $diligencia->id]) }}" class="form-horizontal" enctype="multipart/form-data">
                        {{ Form::token() }}
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group">
                                    <label>O trabalho foi executado com sucesso?</label>
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" value="1" id="sucesso-sim" name="realizado_sucesso" checked>
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="0" id="sucesso-nao" name="realizado_sucesso" >
                                        Não
                                    </label>
                                </div>
                                <div class="input-group">
                                    <label>Você foi o responsável pela execução?</label>
                                    <br>
                                    <label class="radio-inline">
                                        <input type="radio" value="Sim" id="responsavel-sim" name="responsavel" checked>
                                        Sim
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" value="Não" id="responsavel-nao" name="responsavel">
                                        Não
                                    </label>
                                    <div class="" id="realizador-box" style="display: none;">
                                        <br style="clear: both;">
                                        <label>Realizado por: </label><input type="text" name="realizador_nome" class="form-control">
                                        <br style="clear: both;">
                                        <label>Realizador Telefone: </label><input type="text" name="realizador_telefone" class="form-control">
                                        <br style="clear: both;">
                                        <label>Realizador Email: </label><input type="text" name="realizador_email" class="form-control">
                                    </div>
                                </div>

                                <div class="input-group">
                                    @include('elements.file-upload')
                                </div>
                            </div>
                        </div>

                        <br style="clear: both;">
                        Ao clicar em concluir a diligência será enviada para o advogado responsável revisar.
                        <br>
                        <br>
                        {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
                    </form>
                </div>
            </div>
        </div>
    </div>
@elseif ($diligencia->status_id == 9)
    <!-- Devolvida -->
    <h4>Devolvida</h4>
    <div class="alert alert-info alert-white rounded">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <div class="icon"><i class="fa fa-exclamation-triangle"></i></div>
        <strong>Atenção:</strong> Esta diligência está aguardando a sua revisão.
    </div>
    <div class="panel-group no-margin" id="accordion">
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" class="text-danger collapsed" data-original-title="" title="">
                        Contrato
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" style="height: 0px;">
                <div class="panel-body">
                    Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="text-danger" data-original-title="" title="">
                        Informações de Uso
                    </a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <h4>Como aceitar a Diligência</h4>
                    <p>.... </p>
                    <h4>Checkin - Como funciona</h4>
                    <p>...</p>
                    <h4>Conclusão do Trabalho</h4>
                    <p>...</p>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="text-danger" data-original-title="" title="">
                        Revisão
                    </a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse" style="height: auto;">
                <div class="panel-body">
                    <div class="row">
                        <form id="form-resolver" method="post" action="{{ route('diligencias.resolver',['id' => $diligencia->id]) }}" class="form-horizontal" enctype="multipart/form-data">
                            {{ Form::token() }}
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                @if ($diligencia->revisao_instrucoes)
                                    <div class="input-group">
                                        <label>O Revisor Instruiu:</label><br>
                                        {{ $diligencia->revisao_instrucoes  }}
                                        <br>
                                        <br>
                                    </div>
                                @endif
                                <div class="input-group">
                                    <label>Resposta para Revisão: </label><br>
                                    <textarea name="revisao_resolucao" class="form-control" id="revisao_resolucao" cols="200" rows="6"></textarea>
                                    <br style="clear: both;">
                                </div>
                                <div class="input-group">
                                    @include('elements.file-upload')
                                </div>
                            </div>
                        </form>
                    </div>

                    <br style="clear: both;">
                    Ao clicar em concluir a diligência será enviada para o advogado responsável revisar.
                    <br>
                    <br>
                    {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
                </div>
            </div>
        </div>
    </div>
@else
    {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
@endif

<script>

    $('#responsavel-nao').click(function() {
        $('#realizador-box').show();
    });
    $('#responsavel-sim').click(function() {
        $('#realizador-box').hide();
    });
</script>