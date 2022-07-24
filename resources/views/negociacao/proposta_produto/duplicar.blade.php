@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.cadastrar_proposta_produto')
@endsection

@section('conteudo')
    <form action="{{route('proposta.produto.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_negociacao" value="{{$proposta_produto['id_negociacao']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo">@lang('negociacao.produto')
                        <select name="tipo[]" id="" class='form-control selectpicker' multiple title="@lang('comum.seleciona_item')" required>                            
                        @foreach ($produtos as $produto)
                            <option value="{{$produto->id}}">{{$produto->nome}}</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-4' >
                    <label for="data_proposta">@lang('proposta.data_proposta')
                        <input name='data_proposta' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_proposta' required />                    
                    </label>
                </div>        
                
                <div class="form-group col-md-4">
                    <label for="data_proposta">@lang('proposta.area_manejada')
                        <input name='area_manejada' value="{{$proposta_produto['area_manejada']}}" class='form-control' type='number' id='area_manejada' required />                    
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="quantidade_equipamento">@lang('proposta.quantidade_equipamento')
                        <input class="form-control" id="quantidade_equipamento" value='{{$proposta_produto['quantidade_equipamento']}}' name="quantidade_equipamento" type="number" aria-describedby="" min="1" max="99999" />
                    </label>
                </div>
               
                <div class="form-group col-md-4">
                    <label for="area_abrangida">@lang('proposta.area_abrangida')
                        <input class="form-control" id="area_abrangida" name="area_abrangida" value='{{$proposta_produto['area_abrangida']}}' type="number" aria-describedby="" min="1" max="99999999" />
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="quantidade_lance">@lang('proposta.quantidade_lance')
                        <input class="form-control" id="quantidade_lance" name="quantidade_lance" value='{{$proposta_produto['quantidade_lance']}}' type="number" aria-describedby="" min="1" max="99999" />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="valor_total">@lang('proposta.valor_proposta')
                        <input class="form-control" id="valor_total" name="valor_total" value='{{$proposta_produto['valor_total']}}' type="number" aria-describedby="" min="0" max="99999" />                    
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="desconto_concedido">@lang('proposta.desconto_concedido')
                        <input class="form-control" id="desconto_concedido" name="desconto_concedido" value='{{$proposta_produto['desconto_concedido']}}' type="number" aria-describedby="" min="0" max="100" />
                    </label>
                </div>
               
                <div class="form-group col-md-4">
                    <label for="valor_final">@lang('proposta.valor_final')
                        <input class="form-control" id="valor_final" name="valor_final" type="text" aria-describedby="" readonly/>                    
                    </label>
                </div>                
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <input class="form-control" id="expectativa_sucesso" name="expectativa_sucesso" type="number" aria-describedby="" value="{{$proposta_produto['expectativa_sucesso']}}" min="{{$proposta_produto['expectativa_sucesso']}}" max="100" step="5" />
                    @component('_layouts._components._inputLabel', ['texto'=>__('negociacao.expectativa_sucesso'), 'id' => ''])@endcomponent
                </div>
            </div>
        </div>

        <div class="col-12 text-left">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
            <a class="btn btn-outline-dark" href="{{route('proposta.gerenciar', $proposta_produto['id_negociacao'])}}">@lang('buttons.voltar')</a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    calculaValores();

    $('input[name="area_abrangida"]').change(function(e) {
        calculaValores();
    });

    $('input[name="valor_total"]').change(function(e) {
        calculaValores();
    });

    $('input[name="desconto_concedido"]').change(function(e) {
        calculaValores();
    });

    function calculaValores(){
        var area_abrangida = $('input[name="area_abrangida"]').val();
        var valor_total = $('input[name="valor_total"]').val();
        var desconto_concedido = $('input[name="desconto_concedido"]').val();
        var valor_final = $('input[name="valor_final"]').val();        

        if (desconto_concedido > 0) {
            valor_final = (valor_total > 0) ? (((100 - desconto_concedido)/100) * valor_total) : 0;
        } else {
            valor_final = valor_total;
        }
        $('input[name="valor_final"]').val(valor_final);
    }
});
</script>
@endsection