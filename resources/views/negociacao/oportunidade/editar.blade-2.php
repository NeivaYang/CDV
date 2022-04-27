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
                    <label for="codigo">@lang('oportunidade.codigo')</label>
                    <input class="form-control" id="codigo" name="codigo" type="text" aria-describedby="" value="{{$oportunidade['codigo']}}" disabled/>
                    <div class="line_disabled"></div>
                </div>

                <div class="form-group col-md-6">
                    <div class="btn-group btn-group-toggle w-100" data-toggle="buttons">
                        @if ($oportunidade['estagio'] == '0' || $oportunidade['estagio'] == '1')
                        <button type="button" class="btn btn-info estagio-opt" data-toggle="button" data-opcao="0" id="estagio0" aria-pressed="false" autocomplete="off" disabled>                            
                        @else
                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="0" id="estagio0" aria-pressed="false" autocomplete="off">                            
                        @endif
                            @lang('oportunidade.qualificacao')
                        </button>

                        @if ($oportunidade['estagio'] == '1')
                        <button type="button" class="btn btn-info estagio-opt" data-toggle="button" data-opcao="1" id="estagio1" aria-pressed="false" autocomplete="off" disabled>                            
                        @else
                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="1" id="estagio1" aria-pressed="false" autocomplete="off">                            
                        @endif
                            @lang('oportunidade.reuniao')
                        </button>

                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="2" id="estagio2" aria-pressed="false" autocomplete="off">
                            @lang('oportunidade.negociacao')
                        </button>

                        <button type="button" class="btn btn-light estagio-opt" data-toggle="button" data-opcao="3" id="estagio3" aria-pressed="false" autocomplete="off">
                            @lang('oportunidade.abandono')
                        </button>

                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" data-texto="@lang('oportunidade.fechado')" aria-haspopup="true" aria-expanded="false">
                                @lang('oportunidade.fechado')
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <button class="dropdown-item estagio-opt" data-opcao="4" type="button">@lang('oportunidade.fechado_positivo')</button>
                                <button class="dropdown-item estagio-opt" data-opcao="5" type="button">@lang('oportunidade.fechado_negativo')</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user2">@lang('oportunidade.colaborador')</label>
                    <select name="id_user2" id="id_user2" class='form-control' required disabled>
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{$colaborador->id}}" @if ($colaborador->id == $oportunidade['id_user']) selected @endif>
                            {{$colaborador->nome}} ({{$colaborador->funcao}})
                        </option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('oportunidade.cliente')</label>
                    <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' >
                    @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}" @if ($cliente->id == $oportunidade['id_cliente']) selected @endif>
                            {{$cliente->nome}}
                        </option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>    

                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')</label>
                    <select name="id_cdc" id="id_cdc" class='form-control'>
                        @foreach ($cdcs as $cdc)
                            <option value="{{$cdc->id_cdc}}" @if ($cdc->id_cliente == $oportunidade['id_cliente'] && $cdc->id_cdc == $oportunidade['id_cdc']) selected @endif>
                                {{$cdc->cdc}} - {{$cdc->nome}} ({{$cdc->area_total}}/{{$cdc->area_irrigada}} )
                            </option>
                        @endforeach
                    </select>    
                    <div class="line"></div>            
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo">@lang('oportunidade.tipo')</label>
                    <select name="tipo" id="" class='form-control' >
                        <option value="produto" @if ($oportunidade['tipo'] == 'produto') selected @endif>@lang('oportunidade.produto')</option>
                        <option value="servico" @if ($oportunidade['tipo'] == 'servico') selected @endif>@lang('oportunidade.servico')</option>                    
                    </select>
                    <div class="line"></div>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('oportunidade.moeda')</label>
                    <select name="moeda" id="" class='form-control' required>
                    <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($moedas as $moeda)                        
                        <option value="{{$moeda['valor']}}" @if ($oportunidade['moeda'] == $moeda['valor']) selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('oportunidade.data_inicio')</label>
                    <input name='data_inicio' value="{{$oportunidade['data_inicio']}}" class='form-control' required='true' type='date' id='data_inicio' required />
                    <div class="line"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="contrato">@lang('oportunidade.contrato')</label>
                    <select name="contrato" id="" class='form-control' required>
                        <option value="novo" @if ($oportunidade['contrato'] == 'novo') selected @endif>@lang('oportunidade.novo')</option>
                        <option value="renovacao" @if ($oportunidade['contrato'] == 'renovacao') selected @endif>@lang('oportunidade.renovacao')</option>                    
                    </select>
                    <div class="line"></div>
                </div>
                
                <div class="form-group col-md-3">
                    <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby="" value="{{$oportunidade['contrato_anterior']}}" >
                    @component('_layouts._components._inputLabel', ['texto'=>__('oportunidade.contrato_anterior'), 'id' => ''])@endcomponent
                </div>    

                <div class='form-group col-md-3' >
                    <label for="data_fechamento">@lang('oportunidade.data_fechamento')</label>
                    <input name='data_fechamento' value="{{$oportunidade['data_fechamento']}}" class='form-control' required='true' type='date' id='data_fechamento' required />
                    <div class="line"></div>
                </div>        

                <div class='form-group col-md-3' >
                    <label for="data_entrega">@lang('oportunidade.data_entrega')</label>
                    <input name='data_entrega' value="{{$oportunidade['data_entrega']}}" class='form-control' required='true' type='date' id='data_entrega' required />
                    <div class="line"></div>
                </div>        
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <input class="form-control" id="montante" name="montante" type="number" aria-describedby="" value="{{$oportunidade['montante']}}" >
                    @component('_layouts._components._inputLabel', ['texto'=>__('oportunidade.montante'), 'id' => 'montante'])@endcomponent
                </div>

                <div class="form-group col-md-3">
                    <input class="form-control" id="margem_bruta" name="margem_bruta" type="number" aria-describedby="" value="{{$oportunidade['margem_bruta']}}" >
                    @component('_layouts._components._inputLabel', ['texto'=>__('oportunidade.margem_bruta'), 'id' => 'margem_bruta'])@endcomponent
                </div>

                <div class="form-group col-md-3">
                    <input class="form-control" id="numero_equipamentos" name="numero_equipamentos" type="number" aria-describedby="" value="{{$oportunidade['numero_equipamentos']}}" >
                    @component('_layouts._components._inputLabel', ['texto'=>__('oportunidade.numero_equipamentos'), 'id' => 'numero_equipamentos'])@endcomponent
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

            for (var index = 0; index < 4; index++) {
                var name_id = "estagio"+index;
                if (!$('#'+name_id).prop('disabled')) {
                    if ((index > valor) && $('#'+name_id).hasClass('btn-info')) {
                        $('#'+name_id).removeClass('btn-info');
                        $('#'+name_id).addClass('btn-light');
                    }
                    if ((index <= valor) && $('#'+name_id).hasClass('btn-light')) {
                        $('#'+name_id).removeClass('btn-light');
                        $('#'+name_id).addClass('btn-info');
                    }
                }
            }

            if (valor > 3) {
                $('#btnGroupDrop1').html(texto);
                if ($('#btnGroupDrop1').hasClass('btn-light')) {
                    $('#btnGroupDrop1').removeClass('btn-light');
                    $('#btnGroupDrop1').addClass('btn-info');
                }
            } else {
                $('#btnGroupDrop1').html($('#btnGroupDrop1').data('texto'));
                if ($('#btnGroupDrop1').hasClass('btn-info')) {
                    $('#btnGroupDrop1').removeClass('btn-info');
                    $('#btnGroupDrop1').addClass('btn-light');
                }
            }

            $('#estagio').val(valor);
        });

    });
</script>
@endsection