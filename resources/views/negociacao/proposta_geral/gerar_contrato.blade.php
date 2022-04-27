<link href="{{asset('css/tables.css')}}" rel="stylesheet" type="text/css">

@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerar_contrato')
@endsection

@section('conteudo')
    <form action="{{route('proposta.geral.salvarcontrato')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_oportunidade" value="{{$oportunidade['id_oportunidade']}}">
        <input type="hidden" name="id_proposta" value="{{$proposta['id_venda']}}"/>

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="cliente">@lang('oportunidade.cliente')
                        <input name='cliente' value="{{$oportunidade['cliente']}}" class='form-control' type="text" id='cliente' disabled />
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_proposta">@lang('proposta.data_proposta')
                        <input name='data_proposta' value="{{$proposta['data_proposta']}}" class='form-control' type='date' id='data_proposta' disabled />                    
                    </label>
                </div>  
            </div>

            <div class="form-row">
                <table class="table table-striped" id="tabela_itens">
                    <thead>
                    <tr>
                        <th scope="col">@lang('proposta.item_venda')</th>
                        <th scope="col">@lang('proposta.sistema_irrigacao')</th>
                        <th scope="col">@lang('proposta.unidade')</th>
                        <th scope="col">@lang('proposta.quantidade')</th>
                        <th scope="col">@lang('proposta.valor_unitario')</th>
                        <th scope="col">@lang('proposta.valor_total')</th>
                        <th scope="col">@lang('proposta.desconto_concedido') %</th>
                        <th scope="col">@lang('proposta.valor_final')</th>
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
                                <td >{{$item_proposta['unidade']}}</td>
                                <td >{{$item_proposta['quantidade']}}</td>
                                <td >{{$item_proposta['valor_unitario']}}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                                <td >{{$item_proposta['desconto_concedido']}}</td>
                                <td style="text-align: center; vertical-align: middle;"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="numero">@lang('contrato.numero')
                        <input class="form-control" id="numero" name="numero" type="text" aria-describedby="" value="{{$oportunidade['codigo']}}" />                        
                    </label>
                </div>
               
                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('contrato.data_inicio')
                        <input name='data_inicio' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_inicio' required />                    
                    </label>
                </div>        
                
                <div class='form-group col-md-3' >
                    <label for="data_termino">@lang('contrato.data_termino')
                        <input name='data_termino' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_termino' required />                    
                    </label>
                </div>        
                
                <div class="form-group col-md-3">
                    <label for="aviso_expiracao">@lang('contrato.aviso_expiracao')
                        <select name="aviso_expiracao" id="aviso_expiracao" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            <option value="15">15 @lang('contrato.dias')</option>
                            <option value="30">30 @lang('contrato.dias')</option>
                            <option value="60">60 @lang('contrato.dias')</option>
                        </select>                        
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3 align-self-start">
                    <label for="assinante_empresa">@lang('contrato.assinatura_empresa')
                        <input class="form-control" id="assinante_empresa" name="assinante_empresa" type="text" aria-describedby="" value="{{$oportunidade['colaborador']}}" />
                    </label>
                </div>
        
                <div class="form-group col-md-3 align-self-start">
                    <label for="id_cliente">@lang('contrato.assinatura_cliente')
                        <input class="form-control" id="assinante_empresa" name="assinante_cliente" type="text" aria-describedby="" value="{{$oportunidade['cliente']}}" />
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label for="observacao">@lang('contrato.observacao')
                        <textarea name="observacao" class="form-control" id="observacao" rows="3" cols="100"></textarea>                        
                    </label>
                </div>
            </div>
        </div>

        <div class="col-12 text-left">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
            <a class="btn btn-outline-dark" href="{{route('proposta.geral.gerenciar', $oportunidade['id_oportunidade'])}}">@lang('buttons.voltar')</a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $('#id_servico').selectpicker({
        style: '',
        styleBase: 'form-control'
    });

    // Calculando os totais já existentes.
    $('#tabela_itens tbody tr').each(function(){        
            let linha = $(this).closest('tr');
            // Valores dos campos.
            let quantidade = linha.find("td:eq(3)").text();
            let valor_unitario = linha.find("td:eq(4)").text();
            let desconto_concedido = linha.find("td:eq(6)").text();
            if (quantidade != null && quantidade != '' && valor_unitario != null && valor_unitario != ''){
                let valor_total = quantidade * valor_unitario;
                if (desconto_concedido != 0 && desconto_concedido != '') { valor_desconto = valor_total * (desconto_concedido/100); }else{ valor_desconto = 0; }
                let valor_final = valor_total - valor_desconto;                
                linha.find("td:eq(5)").html(valor_total.toFixed(2));
                linha.find("td:eq(7)").html(valor_final.toFixed(2));
            }else{
                linha.find("td:eq(5)").html('');
                linha.find("td:eq(7)").html('');
            }
        });
</script>
@endsection