@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerar_contrato')
@endsection

@section('conteudo')
    <form action="{{route('proposta.servico.salvarcontrato')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <input type="hidden" name="id_oportunidade" value="{{$oportunidade['id_oportunidade']}}">
        <input type="hidden" name="id_proposta" value="{{$proposta['id']}}"/>
        <input type="hidden" name="tipo" value="serviço"/>

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="cliente">@lang('oportunidade.cliente')
                        <input name='cliente' value="{{$oportunidade['cliente']}}" class='form-control' type="text" id='cliente' disabled />
                    </label>
                </div>
                <div class="form-group col-md-3">
                    <label for="id_servico">@lang('oportunidade.servico')
                        <select name="id_servico[]" id="id_servico" class='form-control selectpicker' multiple title="@lang('comum.seleciona_item')" disabled>
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($servicos as $servico)
                            <option value="{{$servico->id}}" @if (in_array($servico->id, $proposta_servico)) selected @endif>{{$servico->nome}}</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_proposta">@lang('proposta.data_proposta')
                        <input name='data_proposta' value="{{$proposta['data_proposta']}}" class='form-control' type='date' id='data_proposta' disabled />                    
                    </label>
                </div>        
                
                <div class="form-group col-md-3">
                    <label for="sistema_irrigacao">@lang('proposta.sistema_irrigacao')
                        <select name="sistema_irrigacao[]" id="" class='form-control selectpicker' multiple="multiple" title="@lang('comum.seleciona_item')" required>
                            @foreach ($sistemas_irrigacao as $sistema)                        
                                <option value="{{$sistema['valor']}}" @if (in_array($sistema['valor'], $proposta['sistema_irrigacao'])) selected @endif>@lang('sistemaIrrigacao.'.$sistema['valor'])</option>
                            @endforeach
                        </select>
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="quantidade_equipamento">@lang('proposta.quantidade_equipamento')
                        <input class="form-control" id="quantidade_equipamento" name="quantidade_equipamento" type="number" aria-describedby="" min="1" max="99999" disabled value="{{$proposta['quantidade_equipamento']}}" />                    
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="area_abrangida">@lang('proposta.area_abrangida')
                        <input class="form-control pr-5" id="area_abrangida" name="area_abrangida" type="number" aria-describedby="" min="1" max="99999999" disabled value="{{$proposta['area_abrangida']}}" />                    
                        <em class="input-unidade">ha</em>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="valor_are">@lang('proposta.valor_area')
                        <input class="form-control maskMoney" id="valor_area" name="valor_area" type="text" aria-describedby="" min="0" max="999999999" disabled value="{{$proposta['valor_area']}}"/>                    
                    </label>
                </div>
               
                <div class="form-group col-md-3">
                    <label for="valor_total">@lang('proposta.valor_total')
                        <input class="form-control maskMoney" id="valor_total" name="valor_total" type="text" aria-describedby="" disabled value="{{$proposta['valor_total']}}" />                    
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="desconto_concedito">@lang('proposta.desconto_concedido')
                        <input class="form-control pr-5 maskMoney" id="desconto_concedido" name="desconto_concedido" type="text" aria-describedby="" min="0" max="100" disabled value="{{$proposta['desconto_concedido']}}" />
                        <em class="input-unidade">%</em>
                    </label>
                </div>
               
                <div class="form-group col-md-3">
                    <label for="valor_final">@lang('proposta.valor_final')
                        <input class="form-control maskMoney" id="valor_final" name="valor_final" type="text" aria-describedby="" disabled value="{{$proposta['valor_final']}}" />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="descricao">@lang('proposta.descricao')
                        <textarea name="descricao" class="form-control" id="descricao" rows="3" cols="100" disabled>{{$proposta['descricao']}}</textarea>
                    </label>
                </div>        
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
            <a class="btn btn-outline-dark" href="{{route('proposta.gerenciar', $oportunidade['id_oportunidade'])}}">@lang('buttons.voltar')</a>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $('#id_servico').selectpicker({
        style: '',
        styleBase: 'form-control'
    }); 
</script>
@endsection