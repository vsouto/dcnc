<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover no-margin">
        <tbody>
        <tr>
            <td class="invoice_info_header_td info" width="12%"><strong>Título</strong></td>
            <td colspan="3" width="25%">{{ $diligencia->titulo }}</td>
        </tr>
        <tr>
            <td class="invoice_info_header_td info"><strong>Descrição</strong></td>
            <td colspan="3">{{ $diligencia->descricao }}</td>
        </tr>
        <tr>
            <td class="invoice_info_header_td info"><strong>Prazo</strong></td>
            <td colspan="3">{{ $diligencia->prazo->diffForHumans() }} ({{ $diligencia->prazo->format('d/m/Y h:i') }})</td>
        </tr>
        <tr>
            <td class="invoice_info_header_td info"><strong>Urgência</strong></td>
            <td colspan="3">{!! getUrgenciaClass($diligencia->urgencia) !!}</td>
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
            <td id="" colspan="3">{{ $diligencia->local_orgao }}</td>
        </tr>{{--
        <tr>
            <td colspan="4" class="invoice_info_header_td info text-center">
                <strong><a href="" target="_blank">Ver mais informações</a></strong>
            </td>
        </tr>--}}
        </tbody>
    </table>
    <br>
</div>