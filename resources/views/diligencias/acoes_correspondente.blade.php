
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
@else
    {!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
@endif