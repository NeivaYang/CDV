<link href="{{asset('css/tables.css')}}" rel="stylesheet" type="text/css">

@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('contrato.visualizar_contrato')
@endsection

@section('conteudo')
    <div class="row mb-3">
        <div class="col-10">
            <div class="card border-light">
                <div class="card-body text-info">
                    <div class="row border-bottom">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.numero') <br>
                                <small class="text-secondary">{{$contrato_venda['numero']}}</small>
                            </h4>
                        </div>    
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.data_inicio') <br>
                                <small class="text-secondary">{{$contrato_venda['data_inicio']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.data_termino') <br>
                                <small class="text-secondary">{{$contrato_venda['data_termino']}}</small>
                            </h4>
                        </div>
                    </div>

                    @if (!empty($contrato_venda['observacao'])) 
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.observacao') <br>
                                <small class="text-secondary">{{$contrato_venda['observacao']}}</small>
                            </h4>
                        </div>
                    </div>
                    @endif

                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.cliente') <br>
                                <small class="text-secondary">{{$oportunidade['cliente']}}</small>
                            </h4>
                        </div>    
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.contrato') <br>
                                <small class="text-secondary">@lang('oportunidade.'.$oportunidade['contrato'])</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.moeda') <br>
                                <small class="text-secondary">@lang('moeda.'.$oportunidade['moeda'])</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.assinatura_empresa') <br>
                                <small class="text-secondary">{{$contrato_venda['assinante_empresa']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.assinatura_cliente') <br>
                                <small class="text-secondary">{{$contrato_venda['assinante_cliente']}}</small>
                            </h4>
                        </div>
                    </div>

                    <div class="row border-bottom pt-3">
                        <table class="table table-striped" id="tabela_itens">
                            <thead>
                            <tr>
                                <th scope="col" style="width; 22%">@lang('proposta.item_venda')</th>
                                <th scope="col" style="width; 132%">@lang('proposta.sistema_irrigacao')</th>
                                <th scope="col" style="width: 10%">@lang('proposta.quantidade_equipamento')</th>
                                <th scope="col" style="width; 7%">@lang('proposta.unidade')</th>
                                <th scope="col" style="width; 8%">@lang('proposta.quantidade')</th>
                                <th scope="col" style="width; 10%">@lang('proposta.valor_unitario') R$</th>
                                <th scope="col" style="width; 10%">@lang('proposta.valor_total') R$</th>
                                <th scope="col" style="width; 10%">@lang('proposta.desconto_concedido') %</th>
                                <th scope="col" style="width; 10%">@lang('proposta.valor_final') R$</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($propostas_itens['venda_itens'] as $key => $item_proposta)
                                    <tr style="text-align: center; vertical-align: middle;">
                                        <td>
                                            @foreach($itens_venda as $item)
                                                @php if($item->id == $item_proposta['id_item_venda']){ echo $item->nome; } @endphp
                                            @endforeach
                                        </td>  
                                        <td>@lang('sistemaIrrigacao.'.$item_proposta['sistema_irrigacao'])</td>
                                        <td >{{$item_proposta['quantidade_equipamento']}}</td>
                                        <td >{{$item_proposta['unidade']}}</td>
                                        <td >{{$item_proposta['quantidade']}}</td>
                                        <td >{{$item_proposta['valor_unitario']}}</td>
                                        <td >{{$item_proposta['valor_total']}}</td>
                                        <td >{{$item_proposta['desconto_concedido']}}</td>
                                        <td >{{$item_proposta['valor_final']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    
                </div>
            </div>        
        </div>
    </div>
    
    <div class="col-12 text-left">
        <a class="btn btn-outline-dark" href="{{route('contrato.gerenciar')}}">@lang('buttons.voltar')</a>
    </div>    
@endsection

@section('scripts')
<script>
    // Colocar máscara no valores
    function putMaskValues() {
            $('table tbody tr').each(function() {
                let valor5 = parseFloat($(this).find('td:eq(5)').html());
                let valor6 = parseFloat($(this).find('td:eq(6)').html());
                let valor7 = parseFloat($(this).find('td:eq(7)').html());
                let valor8 = parseFloat($(this).find('td:eq(8)').html());
                
                valor5 = valor5.toLocaleString('pt-br', {minimumFractionDigits: 2});
                valor6 = valor6.toLocaleString('pt-br', {minimumFractionDigits: 2});
                valor7 = valor7.toLocaleString('pt-br', {minimumFractionDigits: 2});
                valor8 = valor8.toLocaleString('pt-br', {minimumFractionDigits: 2});

                $(this).find("td:eq(5)").html(valor5);
                $(this).find("td:eq(6)").html(valor6);
                $(this).find("td:eq(7)").html(valor7);
                $(this).find("td:eq(8)").html(valor8);
            })            
        }
    //////////////////////////////////////////////

    $(document).ready(function() {
        putMaskValues();
    });
</script>@endsection