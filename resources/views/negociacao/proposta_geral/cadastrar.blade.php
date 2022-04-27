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
            </div>
            <div class="form-row">
                <table class="table table-striped" id="tabela_itens">
                    <thead>
                      <tr>
                        <th scope="col" style="width: 23%">@lang('proposta.item_venda')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 13%">@lang('proposta.sistema_irrigacao')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 8%">@lang('proposta.unidade')</th>
                        <th scope="col" style="width: 10%">@lang('proposta.quantidade')<em class="label-required">*</em></th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_unitario') R$<em class="label-required">*</em></th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_total') R$</th>
                        <th scope="col" style="width: 10%">@lang('proposta.desconto_concedido') %</th>
                        <th scope="col" style="width: 10%">@lang('proposta.valor_final') R$</th>
                        <th scope="col" style="width: 6%">@lang('comum.acoes')</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                            <select id="item_venda" name="id_item_venda[]" class="form-control form-select" onchange=buscaUnidade(this,this.options[selectedIndex].value); required>
                                <option value="" disabled selected>@lang('comum.seleciona_item')</option>
                                @foreach($itens_venda as $item)
                                    <option value="{{$item->id}}">{{$item->nome}}</option>
                                @endforeach
                            </select>
                        </td>  
                        <td>
                            <select name="sistema_irrigacao[]" class="form-control form-select" required>
                                <option value="" disabled selected>@lang('comum.seleciona_item')</option>
                                <option value="none">@lang('sistemaIrrigacao.none')</option>
                                <option value="aspersor">@lang('sistemaIrrigacao.aspersor')</option>
                                <option value="autopropelido">@lang('sistemaIrrigacao.autopropelido')</option>
                                <option value="gotejador">@lang('sistemaIrrigacao.gotejador')</option>
                                <option value="linear">@lang('sistemaIrrigacao.linear')</option>
                                <option value="microaspersor">@lang('sistemaIrrigacao.microaspersor')</option>
                                <option value="pivocentral">@lang('sistemaIrrigacao.pivocentral')</option>
                            </select>
                        </td>
                        <td ><input name='unidade[]' style="text-align: center; vertical-align: middle;" readonly/></td>
                        <td ><input name='quantidade[]' class="form-control" type="number" onchange="calculaValores(this)" min="1" max="99999" aria-describedby="" required /></td>
                        <td ><input name='valor_unitario[]' class="form-control maskMoney" type="text" step="any" onchange="calculaValores(this)" required /></td>
                        <td class="maskMoney" style="text-align: center; vertical-align: middle;"></td>
                        <td ><input name='desconto_concedido[]' id="desconto_concedido" class="form-control maskMoney" type="text" step="any" onchange="calculaValores(this)" /></td>
                        <td class="maskMoney" style="text-align: center; vertical-align: middle;"></td>
                        <td class="delete" style="text-align: center; vertical-align: middle;"></td>
                      </tr>                      
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                                <button class="btn btn-md btn-outline-primary" id="addBtn" type="button"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp&nbsp @lang('proposta.adicionar_item')</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                {{--<button class="btn btn-md btn-primary" id="addBtn" type="button">@lang('proposta.adicionar_item')</button>--}}

            </div>
        </div>

        <div class="col-12 mb-2">
            <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
        </div>

        <div class="col-md-12 form-group">
            
            {{-- <button form='form' class="btn btn-lg btn-info text-center text-light"  type="submit">@lang('buttons.salvar')</button> --}}

            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>


            {{-- <a class="btn btn-outline-dark" href="{{route('proposta.gerenciar', $oportunidade['id_oportunidade'])}}">@lang('buttons.voltar')</a> --}}
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
            let quantidade = linha.find("td:eq(3) input").val();
            let valor_unitario = linha.find("td:eq(4) input").val().replaceAll(".","").replace(",",".");
            let desconto_concedido = linha.find("td:eq(6) input").val().replaceAll(".","").replace(",",".");

            if (quantidade != null && quantidade != '' && valor_unitario != null && valor_unitario != ''){
                let valor_total = quantidade * valor_unitario;
                let valor_desconto = valor_total * (desconto_concedido/100);
                let valor_final = valor_total - valor_desconto;

                valor_total = valor_total.toLocaleString('pt-br', {minimumFractionDigits: 2});
                valor_final = valor_final.toLocaleString('pt-br', {minimumFractionDigits: 2});
                
                linha.find("td:eq(5)").html(valor_total);
                linha.find("td:eq(7)").html(valor_final);
            }else{
                linha.find("td:eq(5)").html('');
                linha.find("td:eq(7)").html('');
            }

        }
    //////////////////////////////////////////////

    // Busca de "Unidade" do item.
        function buscaUnidade(tr, option){
            var itens_venda = <?php echo $itens_venda; ?>;
            let linha = $(tr).closest('tr');

            $.each(itens_venda, function( index, item ) {                
                if (item.id == option){                  
                    linha.find("td:eq(2) input").attr('value', item.unidade).val(item.unidade);
                }
            });
        }
    //////////////////////////////////////////////

    // Remover linhas.
        function deletaLinha(tr){
            tr.closest('tr').remove();
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

            // Limpa os td.
            tr.find("td:eq(2) input").attr('value', '').html('');
            tr.find("td:eq(5)").html('');
            tr.find("td:eq(7)").html('');
            
            // Adiciona o icone de exclusão.
            tr.find("td:last-child").html('<i class="fas fa-fw fa-sm fa-trash-alt" style="text-align: center; width: 100%;" onclick="deletaLinha(this)"></i>');
            
            table.append(tr);
        });

    });

</script>
@endsection