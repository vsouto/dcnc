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
                    <td>R$
                        <span class="text @if ($valor >= $servico->max) 'text-danger' : 'text-info' @endif">
                            {{ $valor }}
                        </span>
                    </td>
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
        <strong>Alerta:</strong> Não existem serviços atrelados à esta diligência ou ainda não existe um correspondente vinculado.
    </div>
@endif