<link href="{{asset('css/tables.css')}}" rel="stylesheet" type="text/css">

@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.cadastrar_proposta')
@endsection

@section('conteudo')

    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-md-3">
                    <h4>@lang('oportunidade.data_inicio'): <b>{{$oportunidade['data_oportunidade']}}</b></h4>
                </div>
                <div class="col-md-3">
                    <h4>@lang('oportunidade.cliente'): <b>{{$oportunidade['cliente']}}</b></h4>
                </div>
                <div class="col-md-3">
                    <h4>@lang('oportunidade.codigo'): <b>{{$oportunidade['codigo']}}</b></h4>
                </div>                
            </div>
        </div>
    </div>

    <form action="{{route('proposta.geral.salvar')}}" class='row' id="form" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_oportunidade" value="{{$oportunidade['id_oportunidade']}}">

        <div class="col-12 form-group">
            <div class="form-row">
                <div class='form-group col-md-3' >
                    <label for="data_proposta">@lang('proposta.data_proposta')<em class="label-required"> *</em>
                        <input name='data_proposta' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_proposta' required />                    
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_proposta">@lang('proposta.total_geral_sem_desconto')
                        <input name='total_sem_desconto' class='form-control' id='total_sem_desconto' value="0,00" readonly />
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_proposta">@lang('proposta.total_geral_com_desconto')
                        <input name='total_com_desconto' class='form-control' id='total_com_desconto' value="0,00" readonly />
                    </label>
                </div>
        </div>
            <div class="form-row">
                <table class="table table-striped" id="tabela_itens">
                    <thead>
                      <tr>
                        <th scope="col" style="width: 18%">@lang('proposta.item_venda')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 13%">@lang('proposta.sistema_irrigacao')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 9%">@lang('proposta.quantidade_equipamento')<em class="label-required">*</em></th>                        
                        <th scope="col" style="width: 6%">@lang('proposta.unidade')</th>
                        <th scope="col" style="width: 9%">@lang('proposta.quantidade')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_unitario') R$<em class="label-required">*</em></th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_total') R$</th>
                        <th scope="col" style="width: 9%">@lang('proposta.desconto_concedido') %</th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_final') R$</th>
                        <th scope="col" style="width: 6%">@lang('comum.acoes')</th>
                      </tr>
                    </thead>
                    <tbody>
                        @php $pos = 0; @endphp
                        @foreach($propostas_itens['venda_itens'] as $key => $item_proposta)
                            <tr>
                            <td>
                                <select id="item_venda" name="id_item_venda[]" class="form-control form-select" onchange=buscaUnidade(this,this.options[selectedIndex].value); required>                                    
                                    @foreach($itens_venda as $item)
                                        <option value="{{$item->id}}" {{($item->id == $item_proposta['id_item_venda']) ? "selected" : "" }}>{{$item->nome}}</option>
                                    @endforeach
                                </select>
                            </td>  
                            <td>
                                <select name="sistema_irrigacao[]" class="form-control form-select" required>
                                    <option value="none" {{($item_proposta['sistema_irrigacao'] == "none") ? "selected" : ""}}>@lang('sistemaIrrigacao.none')</option>
                                    <option value="aspersor" {{($item_proposta['sistema_irrigacao'] == "aspersor") ? "selected" : ""}}>@lang('sistemaIrrigacao.aspersor')</option>
                                    <option value="autopropelido" {{($item_proposta['sistema_irrigacao'] == "autopropelido") ? "selected" : ""}}>@lang('sistemaIrrigacao.autopropelido')</option>
                                    <option value="gotejador" {{($item_proposta['sistema_irrigacao'] == "gotejador") ? "selected" : ""}}>@lang('sistemaIrrigacao.gotejador')</option>
                                    <option value="linear" {{($item_proposta['sistema_irrigacao'] == "linear") ? "selected" : ""}}>@lang('sistemaIrrigacao.linear')</option>
                                    <option value="microaspersor" {{($item_proposta['sistema_irrigacao'] == "microaspersor") ? "selected" : ""}}>@lang('sistemaIrrigacao.microaspersor')</option>
                                    <option value="pivocentral" {{($item_proposta['sistema_irrigacao'] == "pivocentral") ? "selected" : ""}}>@lang('sistemaIrrigacao.pivocentral')</option>
                                </select>
                            </td>
                            <td><input name='quantidade_equipamento[]' class="form-control" type="number" min="1" max="99999" aria-describedby="" value="{{$item_proposta['quantidade_equipamento']}}" /></td>
                            <td><input name='unidade[]' class="form-control" style="text-align: center; vertical-align: middle;" value="{{$item_proposta['unidade']}}" readonly/></td>
                            <td ><input name='quantidade[]' class="form-control" type="number" onchange="calculaValores(this)" min="1" max="99999" aria-describedby="" value="{{$item_proposta['quantidade']}}" required /></td>
                            <td><input name='valor_unitario[]' class="form-control maskMoney" type="text" onchange="calculaValores(this)" value="{{$item_proposta['valor_unitario']}}" required /></td>
                            <td><input name='valor_total[]' class="form-control" style="text-align: center; vertical-align: middle;" value="{{$item_proposta['valor_total']}}" readonly/></td>
                            <td ><input name='desconto_concedido[]' id="desconto_concedido" class="form-control maskMoney" type="text" step="any" onchange="calculaValores(this)" value="{{$item_proposta['desconto_concedido']}}" /></td>
                            <td><input name='valor_final[]' class="form-control" style="text-align: center; vertical-align: middle;" value="{{$item_proposta['valor_final']}}" readonly/></td>
                            <td class="delete" style="text-align: center; vertical-align: middle;">@php if($pos != 0){ echo('<i class="fas fa-trash-alt" style="text-align: center; width: 100%;" onclick="deletaLinha(this)"></i>');} @endphp </td>
                            @php $pos++; @endphp
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <button class="btn btn-md btn-outline-primary" id="addBtn" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp&nbsp @lang('proposta.adicionar_item')</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>

        <div class="col-12 mb-2">
            <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
        </div>

        <div class="col-md-12 form-group">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
            <a class="btn btn-outline-dark" href="{{route('proposta.geral.gerenciar', $oportunidade['id_oportunidade'])}}">@lang('buttons.voltar')</a>            
        </div>

    </form>

@endsection

@section('scripts')
<script>

    // Cálculos de valores.
        function calculaValores(tr){
            let linha = $(tr).closest('tr');
            
            // Valores dos campos.
            let quantidade = parseFloat(linha.find("td:eq(4) input").val());
            let valor_unitario = parseFloat(linha.find("td:eq(5) input").val().replaceAll(".","").replace(",","."));
            let desconto_concedido = parseFloat(linha.find("td:eq(7) input").val().replaceAll(".","").replace(",","."));
            let valor_total = 0;
            let valor_final = 0;
            let valor_desconto = 0;

            if (quantidade != null && quantidade != '' && valor_unitario != null && valor_unitario != ''){
                valor_total = quantidade * valor_unitario;
                valor_desconto = Math.round(valor_total * (desconto_concedido/100));
                valor_final = valor_total - valor_desconto;
            }
                
                valor_total = valor_total.toLocaleString('pt-br', {minimumFractionDigits: 2});
                valor_final = valor_final.toLocaleString('pt-br', {minimumFractionDigits: 2});
                
            linha.find("td:eq(6) input").attr('value', valor_total).val(valor_total);
            linha.find("td:eq(8) input").attr('value', valor_final).val(valor_final);

            calculatedGeneralTotal()
        }
    //////////////////////////////////////////////

    // Busca de "Unidade" do item.
        function buscaUnidade(tr, option){
            var itens_venda = <?php echo $itens_venda; ?>;
            let linha = $(tr).closest('tr');

            $.each(itens_venda, function( index, item ) {                
                if (item.id == option){
                    linha.find("td:eq(3) input").attr('value', item.unidade).val(item.unidade);
                }
            });
        }
    //////////////////////////////////////////////

    // Remover linhas.
        function deletaLinha(tr){
            tr.closest('tr').remove();
        }
    //////////////////////////////////////////////

    // Calcula totais gerais
        function calculatedGeneralTotal() {
            let total_geral_com_desconto = 0;
            let total_geral_sem_desconto = 0;

            $('table tbody tr').find('td:eq(6) input').each(function() {
                let valor = parseFloat($(this).val().replaceAll(".","").replace(",","."));
                total_geral_sem_desconto += valor;
            })

            $('table tbody tr').find('td:eq(8) input').each(function() {
                let valor = parseFloat($(this).val().replaceAll(".","").replace(",","."));
                total_geral_com_desconto += valor;
            })

            total_geral_sem_desconto = total_geral_sem_desconto.toLocaleString('pt-br', {minimumFractionDigits: 2});
            total_geral_com_desconto = total_geral_com_desconto.toLocaleString('pt-br', {minimumFractionDigits: 2});
            
            $('#total_sem_desconto').attr('value', total_geral_sem_desconto).val(total_geral_sem_desconto);
            $('#total_com_desconto').attr('value', total_geral_com_desconto).val(total_geral_com_desconto);
        }
    //////////////////////////////////////////////

    // Colocar máscara no valores
        function putMaskValues() {
            $('table tbody tr').find('td:eq(6) input').each(function() {
                let valor = parseFloat($(this).val());
                valor = valor.toLocaleString('pt-br', {minimumFractionDigits: 2});
                $(this).val(valor);
            })

            $('table tbody tr').find('td:eq(8) input').each(function() {
                let valor = parseFloat($(this).val());
                valor = valor.toLocaleString('pt-br', {minimumFractionDigits: 2});
                $(this).val(valor);
            })            
        }
    //////////////////////////////////////////////

    
    $(document).ready(function() {

        // Adicionar linhas.
        $('#addBtn').on('click', function () {
            var table = $('#tabela_itens');
            var tr    = table.find('tr:eq(1)').clone();

            // Limpas os inputs.
            $(tr).find('input,select').each(function () {
                $(this).val('');
            });

            // Adiciona o icone de exclusão.
            tr.find("td:last-child").html('<i class="fas fa-fw fa-sm fa-trash-alt" style="text-align: center; width: 100%;" onclick="deletaLinha(this)"></i>');
            
            table.append(tr);

            // Limpa os td.
            tr.find("td:eq(3) input").attr('value', '');
            tr.find("td:eq(5) input").attr('value', '0').val('0');
            tr.find("td:eq(6) input").attr('value', '0,00').val('0,00');
            tr.find("td:eq(7) input").attr('value', '0').val('0');
            tr.find("td:eq(8) input").attr('value', '0,00').val('0,00');

            $('.maskMoney').maskMoney({allowNegative: false, thousands:'.', decimal:','});

            $('table tbody tr:last').find('.maskMoney').each(function(){ // function to apply mask on load!
                $(this).maskMoney('mask', $(this).val());
            })

        });

        $('.maskMoney').maskMoney({allowNegative: false, thousands:'.', decimal:','});

        $('.maskMoney').each(function(){ // function to apply mask on load!
            $(this).maskMoney('mask', $(this).val());
        })
                
        putMaskValues()

        calculatedGeneralTotal()
    });

</script>
@endsection