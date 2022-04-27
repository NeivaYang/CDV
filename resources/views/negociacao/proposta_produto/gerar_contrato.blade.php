@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerar_contrato')
@endsection

@section('conteudo')
    <form action="{{route('proposta.produto.salvarcontrato')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_negociacao" value="{{$proposta_produto['id_negociacao']}}">
        <input type="hidden" name="id_proposta" value="{{$proposta_produto['id']}}"/>

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="tipo">@lang('negociacao.produto')
                        <select name="tipo[]" id="tipo" class='form-control selectpicker' multiple title="@lang('comum.seleciona_item')" disabled>
                        @foreach ($produtos_proposta as $produto)
                            <option value="{{$produto->id}}" selected='selected'>{{$produto->nome}}</option>
                        @endforeach
                        </select>
                    </label>
                </div>

                <div class='form-group col-md-4' >
                    <label for="data_proposta">@lang('proposta.data_proposta')
                        <input name='data_proposta' value="{{$proposta_produto['data_proposta']}}" class='form-control' type='date' id='data_proposta' disabled />
                    </label>
                </div>        
                
                <div class="form-group col-md-4">
                    <label for="area_manejada">@lang('proposta.area_manejada')
                        <input class="form-control" id="area_manejada" name="area_manejada" type="number" aria-describedby="" min="1" max="99999999" disabled value="{{$proposta_produto['area_manejada']}}" />                    
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="quantidade_equipamento">@lang('proposta.quantidade_equipamento')
                        <input class="form-control" id="quantidade_equipamento" name="quantidade_equipamento" type="number" aria-describedby="" min="1" max="99999" disabled value="{{$proposta_produto['quantidade_equipamento']}}" />
                    </label>
                </div>
               
                <div class="form-group col-md-4">
                    <label for="area_abrangida">@lang('proposta.area_abrangida')
                        <input class="form-control" id="area_abrangida" name="area_abrangida" type="number" aria-describedby="" min="0" max="999999999" disabled value="{{$proposta_produto['area_abrangida']}}" />                    
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="quantidade_lance">@lang('proposta.quantidade_lance')
                        <input class="form-control" id="quantidade_lance" name="quantidade_lance" value='{{$proposta_produto['quantidade_lance']}}' type="number" aria-describedby="" min="1" max="99999" disabled />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="valor_total">@lang('proposta.valor_proposta')
                        <input class="form-control" id="valor_total" name="valor_total" type="text" aria-describedby="" disabled value="{{$proposta_produto['valor_total']}}" />
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="desconto_concedito">@lang('proposta.desconto_concedido')
                        <input class="form-control" id="desconto_concedido" name="desconto_concedido" type="number" aria-describedby="" min="0" max="100" disabled value="{{$proposta_produto['desconto_concedido']}}" />
                    </label>
                </div>
               
                <div class="form-group col-md-4">
                    <label for="valor_final">@lang('proposta.valor_final')
                        <input class="form-control" id="valor_final" name="valor_final" type="text" aria-describedby="" disabled value="{{$proposta_produto['valor_final']}}" />                    
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="numero">@lang('contrato.numero')
                        <input class="form-control" id="numero" name="numero" type="text" aria-describedby="" value="{{$negociacao['codigo']}}" />
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
                    <label for="observacao">@lang('contrato.observacao')
                        <textarea name="observacao" class="form-control" id="observacao" rows="3" cols="100"></textarea>                    
                    </label>
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
    $('#form_submit').on('submit', function() {
        $('#tipo').prop('disabled', false);
    });
</script>
@endsection