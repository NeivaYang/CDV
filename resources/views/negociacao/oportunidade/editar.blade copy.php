@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('oportunidade.editar_oportunidade')
@endsection

@section('conteudo')
    <form action="{{route('oportunidade.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$oportunidade['id']}}">
        <input type="hidden" name="id_user" value="{{$oportunidade['id_user']}}">
        <input type="hidden" name="estagio" id="estagio" value="{{$oportunidade['estagio']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">@lang('oportunidade.codigo')
                        <input class="form-control" id="codigo" name="codigo" type="text" aria-describedby="" value="{{$oportunidade['codigo']}}" disabled/>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                        @if ($oportunidade['estagio'] == '0' || $oportunidade['estagio'] == '1')
                        <button type="button" class="btn btn-info estagio-opt" data-toggle="button" data-opcao="0" id="estagio0"
                        @if ($dias_estagio[0] > 0) data-tooltip="tooltip" title="{{$dias_estagio[0]}}" @endif
                         aria-pressed="false" autocomplete="off" disabled>                            
                        @else
                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="0" id="estagio0"
                        @if ($dias_estagio[0] > 0) data-tooltip="tooltip" title="{{$dias_estagio[0]}}" @endif
                         aria-pressed="false" autocomplete="off">                            
                        @endif
                            @lang('oportunidade.qualificacao')
                        </button>

                        @if ($oportunidade['estagio'] == '1')
                        <button type="button" class="btn btn-info estagio-opt" data-toggle="button" data-opcao="1" id="estagio1"
                        @if ($dias_estagio[1] > 0) data-tooltip="tooltip" title="{{$dias_estagio[1]}}" @endif
                         aria-pressed="false" autocomplete="off" disabled>                            
                        @else
                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="1" id="estagio1"
                        @if ($dias_estagio[1] > 0) data-tooltip="tooltip" title="{{$dias_estagio[1]}}" @endif
                         aria-pressed="false" autocomplete="off">                            
                        @endif
                            @lang('oportunidade.reuniao')
                        </button>

                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="2" id="estagio2"
                        @if ($dias_estagio[2] > 0) data-tooltip="tooltip" title="{{$dias_estagio[2]}}" @endif
                         aria-pressed="false" autocomplete="off">
                            @lang('oportunidade.negociacao')
                        </button>

                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="3" id="estagio3"
                        @if ($dias_estagio[3] > 0) data-tooltip="tooltip" title="{{$dias_estagio[3]}}" @endif
                         aria-pressed="false" autocomplete="off">
                            @lang('oportunidade.abandono')
                        </button>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user2">@lang('oportunidade.colaborador')
                        <select name="id_user2" id="id_user2" class='form-control' required disabled>
                        @foreach ($colaboradores as $colaborador)
                            <option value="{{$colaborador->id}}" @if ($colaborador->id == $oportunidade['id_user']) selected @endif>
                                {{$colaborador->nome}} ({{$colaborador->funcao}})
                            </option>
                        @endforeach
                        </select>
                    </label>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('oportunidade.cliente')
                        <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' >
                        @foreach ($clientes as $cliente)
                            <option value="{{$cliente->id}}" @if ($cliente->id == $oportunidade['id_cliente']) selected @endif>
                                {{$cliente->nome}}
                            </option>
                        @endforeach
                        </select>                    
                    </label>
                </div>    

                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')
                        <select name="id_cdc" id="id_cdc" class='form-control'>
                            @foreach ($cdcs as $cdc)
                                <option value="{{$cdc->id_cdc}}" @if ($cdc->id_cliente == $oportunidade['id_cliente'] && $cdc->id_cdc == $oportunidade['id_cdc']) selected @endif>
                                    {{$cdc->cdc}} - {{$cdc->nome}} ({{$cdc->area_total}}/{{$cdc->area_irrigada}} )
                                </option>
                            @endforeach
                        </select>                        
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo">@lang('oportunidade.tipo')
                        <select name="tipo" id="" class='form-control' >
                            <option value="produto" @if ($oportunidade['tipo'] == 'produto') selected @endif>@lang('oportunidade.produto')</option>
                            <option value="servico" @if ($oportunidade['tipo'] == 'servico') selected @endif>@lang('oportunidade.servico')</option>                    
                        </select>                        
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('oportunidade.moeda')
                        <select name="moeda" id="" class='form-control' required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($moedas as $moeda)                        
                            <option value="{{$moeda['valor']}}" @if ($oportunidade['moeda'] == $moeda['valor']) selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('oportunidade.data_inicio')
                        <input name='data_inicio' value="{{$oportunidade['data_inicio']}}" class='form-control' required='true' type='date' id='data_inicio' required/>                    
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="contrato">@lang('oportunidade.contrato')
                        <select name="contrato" id="" class='form-control' required>
                            <option value="novo" @if ($oportunidade['contrato'] == 'novo') selected @endif>@lang('oportunidade.novo')</option>
                            <option value="renovacao" @if ($oportunidade['contrato'] == 'renovacao') selected @endif>@lang('oportunidade.renovacao')</option>                    
                        </select>
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="contrato_anterior">@lang('negociacao.contrato_anterior')
                        <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby="" value="{{$oportunidade['contrato_anterior']}}" />
                    </label>
                </div>    

                <div class='form-group col-md-3' >
                    <label for="data_fechamento">@lang('oportunidade.data_fechamento')
                        <input name='data_fechamento' value="{{$oportunidade['data_fechamento']}}" class='form-control' required='true' type='date' id='data_fechamento' required />                    
                    </label>
                    <div class="line"></div>
                </div>        

                <div class='form-group col-md-3' >
                    <label for="data_entrega">@lang('oportunidade.data_entrega')
                        <input name='data_entrega' value="{{$oportunidade['data_entrega']}}" class='form-control' required='true' type='date' id='data_entrega' required />             
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="montante">@lang('oportunidade.montante')
                        <input class="form-control" id="montante" name="montante" type="number" aria-describedby="" value="{{$oportunidade['montante']}}" />
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="margem_bruta">@lang('oportunidade.margem_bruta')
                        <input class="form-control" id="margem_bruta" name="margem_bruta" type="number" aria-describedby="" value="{{$oportunidade['margem_bruta']}}" />
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="numero_equipamentos">@lang('oportunidade.numero_equipamentos')
                        <input class="form-control" id="numero_equipamentos" name="numero_equipamentos" type="number" aria-describedby="" value="{{$oportunidade['numero_equipamentos']}}" />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-dark" href="{{route('oportunidade.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('[data-tooltip="tooltip"]').tooltip();

        $('.dynamic').change(function () {
            if ($(this).val() != '') {
                var valor = $(this).val();
                var dependente = $(this).data('dependente');
                var _token = $('input[name="_token"').val();
                $.ajax({
                    url: "{{route('oportunidade.preencheSelecao')}}",
                    method: "POST",
                    data: { valor: valor, dependente:dependente, _token: _token},
                    success:function(result) {
                        $('#'+dependente).html(result);
                        if (dependente == 'id_cliente') {
                            $('#id_cdc').html('');
                        }
                    }, 
                    error : function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });

        $('.estagio-opt').click(function () {
            var valor = $(this).data('opcao');
            var texto = $(this).html();
            var btn = ['btn-info','btn-light','btn-primary','btn-warning'];

            for (var index = 0; index < 4; index++) {
                var name_id = "estagio"+index;

                for (var x = 0; x < 4; x++) {
                    if ($('#'+name_id).hasClass(btn[x])) {
                        $('#'+name_id).removeClass(btn[x]);
                    }
                }

                if (index > valor) {
                    $('#'+name_id).addClass(btn[1]);
                } else {
                    var btnOn = (valor >= 2) ? btn[valor] : btn[0];
                    $('#'+name_id).addClass(btnOn);
                }
            }

            $('#estagio').val(valor);
        });

    });
</script>
@endsection