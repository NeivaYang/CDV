@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('oportunidade.confirma_remover')
@endsection

@section('conteudo')
    <form action="{{route('oportunidade.exclui')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$oportunidade['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">@lang('oportunidade.codigo')
                        <input class="form-control" id="codigo" name="codigo" type="text" aria-describedby="" value="{{$oportunidade['codigo']}}" disabled />                    
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="estagio">@lang('oportunidade.estagio')
                        <select name="estagio" id="" class='form-control' required disabled>
                            <option value="">@lang('comum.seleciona_item')</option>
                            <option value="0" @if ($oportunidade['estagio'] == '0') selected @endif>@lang('oportunidade.prospecto')</option>
                            <option value="1" @if ($oportunidade['estagio'] == '1') selected @endif>@lang('oportunidade.reuniao')</option>
                            <option value="2" @if ($oportunidade['estagio'] == '2') selected @endif>@lang('oportunidade.negociacao')</option>
                            <option value="3" @if ($oportunidade['estagio'] == '3') selected @endif>@lang('oportunidade.abandono')</option>
                            <option value="4" @if ($oportunidade['estagio'] == '4') selected @endif>@lang('oportunidade.fechado_positivo')</option>
                            <option value="5" @if ($oportunidade['estagio'] == '5') selected @endif>@lang('oportunidade.fechado_negativo')</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user">@lang('oportunidade.colaborador')
                        <select name="id_user" id="id_user" class='form-control' required disabled>
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
                        <select name="id_cliente" id="id_cliente" class='form-control' disabled >
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
                        <select name="id_cdc" id="id_cdc" class='form-control' disabled>
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
                        <select name="tipo" id="" class='form-control' disabled >
                            <option value="produto" @if ($oportunidade['tipo'] == 'produto') selected @endif>@lang('oportunidade.produto')</option>
                            <option value="servico" @if ($oportunidade['tipo'] == 'servico') selected @endif>@lang('oportunidade.servico')</option>                    
                        </select>
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('oportunidade.moeda')
                        <select name="moeda" id="" class='form-control' disabled >
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($moedas as $moeda)                        
                            <option value="{{$moeda['valor']}}" @if ($oportunidade['moeda'] == $moeda['valor']) selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                        @endforeach
                        </select>
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('oportunidade.data_inicio')
                        <input name='data_inicio' value="{{$oportunidade['data_inicio']}}" class='form-control' required='true' type='date' id='data_inicio' disabled />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="contrato">@lang('oportunidade.contrato')
                        <select name="contrato" id="" class='form-control' disabled >
                            <option value="novo" @if ($oportunidade['contrato'] == 'novo') selected @endif>@lang('oportunidade.novo')</option>
                            <option value="renovacao" @if ($oportunidade['contrato'] == 'renovacao') selected @endif>@lang('oportunidade.renovacao')</option>                    
                        </select>                        
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="contrato_anterior">@lang('oportunidade.contrato_anterior')
                        <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby="" value="{{$oportunidade['contrato_anterior']}}" disabled />                        
                    </label>
                </div>    

                <div class='form-group col-md-3' >
                    <label for="data_fechamento">@lang('oportunidade.data_fechamento')
                        <input name='data_fechamento' value="{{$oportunidade['data_fechamento']}}" class='form-control' required='true' type='date' id='data_fechamento' disabled />                    
                    </label>
                </div>        

                <div class='form-group col-md-3' >
                    <label for="data_entrega">@lang('oportunidade.data_entrega')
                        <input name='data_entrega' value="{{$oportunidade['data_entrega']}}" class='form-control' required='true' type='date' id='data_entrega' disabled />
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <input class="form-control" id="montante" name="montante" type="number" aria-describedby="" value="{{$oportunidade['montante']}}" disabled />
                </div>

                <div class="form-group col-md-3">
                    <label for="margem_bruta">@lang('oportunidade.margem_bruta')
                        <input class="form-control" id="margem_bruta" name="margem_bruta" type="number" aria-describedby="" value="{{$oportunidade['margem_bruta']}}" disabled />
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="numero_equipamentos">@lang('oportunidade.numero_equipamentos')
                        <input class="form-control" id="numero_equipamentos" name="numero_equipamentos" type="number" aria-describedby="" value="{{$oportunidade['numero_equipamentos']}}" disabled />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.deletar')</button>
                    <a class="btn btn-outline-dark" href="{{route('oportunidade.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection