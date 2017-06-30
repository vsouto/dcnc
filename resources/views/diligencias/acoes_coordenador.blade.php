{!! \App\Diligencia::getCurrentAction($diligencia->id) !!}
<br>
<br>

@if ($diligencia->status_id == 6)
    <!-- Em Negociação -->
    <h4>Correspondentes Recomendados</h4>
    @if(!$correspondentes_recomendados)
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
                    <tr>
                        <td class="danger">{{ $correspondente->id }}</td>
                        <td class="info">{{ $diligencia->comarca->comarca}}</td>
                        <td class="warning">{{ $correspondente->nome }}</td>
                        <td class="success"></td>
                        <td class="success"></td>
                        <td class="success"></td>
                        <td class="success">{!! getRatingStars($correspondente->rating) !!}</td>
                        <td class="success">
                            {{--}}
                            <span class="text @if (\App\Correspondente::isCorrespondenteOverpriced($diligencia->servicos->first()->id,$correspondente->id)) text-danger @endif ">
                                    R$ {{ $correspondente->valor }}
                                </span>
                                {{--}}
                            <span class="text @if ($correspondente->valor > $diligencia->servicos->first()->max) text-danger @endif">
                                    R$ {{ $correspondente->valor }}
                                </span>
                        </td>
                        <td class="success">
                            <button type="button"
                                    class="btn btn-info btn-rounded btn-transparent select-correspondente"
                                    id=""
                                    data-ref="{{ $correspondente->id }}">Selecionar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endif