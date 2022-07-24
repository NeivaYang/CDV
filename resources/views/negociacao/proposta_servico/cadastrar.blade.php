@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.cadastrar_proposta_servico')
@endsection

@section('conteudo')
    <form action="{{route('proposta.servico.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_oportunidade" value="{{$oportunidade['id_oportunidade']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_servico">@lang('oportunidade.servico')<em class="label-required"> *</em>
                        <select name="id_servico[]" id="id_servico" class='form-control selectpicker' multiple title="@lang('comum.seleciona_item')" required>
                        @foreach ($servicos as $servico)
                            <option value="{{$servico->id}}">{{$servico->nome}}</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-4' >
                    <label for="data_proposta">@lang('proposta.data_proposta')<em class="label-required"> *</em>
                        <input name='data_proposta' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_proposta' required />                    
                    </label>
                </div>        
                
                <div class="form-group col-md-4">
                    <label for="sistema_irrigacao">@lang('proposta.sistema_irrigacao')<em class="label-required"> *</em>
                        <select name="sistema_irrigacao[]" id="" class='form-control selectpicker' multiple="multiple" title="@lang('comum.seleciona_item')" required>
                        @foreach ($sistemas_irrigacao as $sistema)                        
                            <option value="{{$sistema['valor']}}">@lang('sistemaIrrigacao.'.$sistema['valor'])</option>
                        @endforeach
                        </select>
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="quantidade_equipamento">@lang('proposta.quantidade_equipamento')<em class="label-required"> *</em>
                        <input class="form-control" id="quantidade_equipamento" name="quantidade_equipamento" type="number" aria-describedby="" min="1" max="99999" required/>
                    </label>
                </div>
               
                <div class="form-group col-md-3">
                    <label for="area_abrangida">@lang('proposta.area_abrangida')<em class="label-required"> *</em>
                        <input class="form-control pr-5" id="area_abrangida" name="area_abrangida" type="number" aria-describedby="" min="1" max="99999999" required/>
                        <em class="input-unidade">ha</em>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="valor_area">@lang('proposta.valor_area')<em class="label-required"> *</em>
                        <input class="form-control maskMoney" id="valor_area" name="valor_area" type="text" aria-describedby="" min="1" max="999999999" required/>
                    </label>
                </div>
               
                <div class="form-group col-md-3">
                    <label for="valor_total">@lang('proposta.valor_total')
                        <input class="form-control maskMoney" id="valor_total" name="valor_total" type="text" aria-describedby="" disabled />
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="desconto_concedido">@lang('proposta.desconto_concedido')
                        <input class="form-control pr-5 maskMoney" id="desconto_concedido" name="desconto_concedido" type="text" aria-describedby="" min="0" max="100" />
                        <em class="input-unidade">%</em>
                    </label>
                </div>
               
                <div class="form-group col-md-3">
                    <label for="valor_final">@lang('proposta.valor_final')
                        <input class="form-control maskMoney" id="valor_final" name="valor_final" type="text" aria-describedby="" disabled />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descricao">@lang('proposta.descricao')
                        <textarea name="descricao" class="form-control" id="descricao" rows="3" cols="100"></textarea>                    
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-12 text-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-dark" href="{{route('proposta.gerenciar', $oportunidade['id_oportunidade'])}}">@lang('buttons.voltar')</a>
                </div>        
            </div>
        </div>

    </form>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#id_servico').selectpicker({
        style: '',
        styleBase: 'form-control'
    });            

    $('input[name="area_abrangida"]').change(function(e) {
        calculaValores();
    });

    $('input[name="valor_area"]').change(function(e) {
        calculaValores();
    });

    $('input[name="desconto_concedido"]').change(function(e) {
        calculaValores();
    });

    function calculaValores() {  
        var area_abrangida = $('input[name="area_abrangida"]').val().replace(".","").replace(",",".");
        var valor_area = $('input[name="valor_area"]').val().replace(".","").replace(",",".");
        var valor_total = $('input[name="valor_total"]').val().replace(".","").replace(",",".");
        var desconto_concedido = $('input[name="desconto_concedido"]').val().replace(".","").replace(",",".");
        var valor_final = $('input[name="valor_final"]').val().replace(".","").replace(",",".");

        area_abrangida = (area_abrangida) ? parseFloat(area_abrangida) : 0;
        valor_area = (valor_area) ? parseFloat(valor_area) : 0;
        valor_total = (valor_total) ? parseFloat(valor_total) : 0;
        desconto_concedido = (desconto_concedido) ? parseFloat(desconto_concedido) : 0;
        valor_final = (valor_final) ? parseFloat(valor_final) : 0;

        if ((area_abrangida > 0) && (valor_area > 0)) {
            valor_total = area_abrangida * valor_area;
        }

        if (desconto_concedido > 0) {
            valor_final = (valor_total > 0) ? (((100 - desconto_concedido)/100) * valor_total) : 0;
        } else {
            valor_final = valor_total;
        }

        valor_total = valor_total.toFixed(2).toString().replace(".",",");
        valor_final = valor_final.toFixed(2).toString().replace(".",",");

        $('input[name="valor_total"]').val(valor_total).trigger('mask.maskMoney');
        $('input[name="valor_final"]').val(valor_final).trigger('mask.maskMoney');
    }
});
</script>
@endsection