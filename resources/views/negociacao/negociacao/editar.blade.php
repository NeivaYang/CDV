@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('negociacao.editar_negociacao')
@endsection

@section('conteudo')
    <form action="{{route('negociacao.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$negociacao['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">@lang('negociacao.codigo')</label>
                    <input class="form-control" id="codigo" name="codigo" type="text" aria-describedby="" value="{{$negociacao['codigo']}}" disabled/>
                    <div class="line_disabled"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user">@lang('negociacao.colaborador')</label>
                    <select name="id_user" id="" class='form-control dynamic' data-dependente='id_cliente' >
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{$colaborador->id}}" @if ($colaborador->id == $negociacao['id_colaborador']) selected @endif>{{$colaborador->nome}} ({{$colaborador->funcao}})</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('negociacao.cliente')</label>
                    <select name="id_cliente" id="" class='form-control dynamic' data-dependente='id_cdc' >
                    @foreach ($clientes as $cliente)
                        <option value="{{$cliente->id}}" @if ($cliente->id == $negociacao['id_cliente']) selected @endif>{{$cliente->nome}}</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>    

                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')</label>
                    <select name="id_cdc" id="id_cdc" class='form-control' required>
                        @foreach ($cdcs as $cdc)
                            <option value="{{$cdc->id}}" @if ($cdc->id == $negociacao['id_cdc']) selected @endif>{{$cdc->cdc}} - {{$cdc->nome}} ({{$cdc->area_total}}/{{$cdc->area_irrigada}} )</option>
                        @endforeach
                    </select>    
                    <div class="line"></div>                            
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo">@lang('negociacao.tipo')</label>
                    <select name="tipo" id="" class='form-control' >
                        <option value="produto" @if ($negociacao['tipo'] == 'produto') selected @endif>@lang('negociacao.produto')</option>
                        <option value="serviço" @if ($negociacao['tipo'] == 'serviço') selected @endif>@lang('negociacao.servico')</option>                    
                    </select>
                    <div class="line"></div>
                </div>
                
                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('negociacao.data_inicio')</label>
                    <input name='data_inicio' value="{{$negociacao['data_inicio']}}" class='form-control' required='true' type='date' id='data_inicio' required />
                    <div class="line"></div>
                </div>

                <div class="form-group col-md-3">
                    <label for="contrato">@lang('negociacao.contrato')</label>
                    <select name="contrato" id="" class='form-control' required>
                        <option value="novo" @if ($negociacao['contrato'] == 'novo') selected @endif>@lang('negociacao.novo')</option>
                        <option value="renovação" @if ($negociacao['contrato'] == 'renovação') selected @endif>@lang('negociacao.renovacao')</option>                    
                    </select>
                    <div class="line"></div>
                </div>
                
                <div class="form-group col-md-3">
                    <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby="" value="{{$negociacao['contrato_anterior']}}" >
                    @component('_layouts._components._inputLabel', ['texto'=>__('negociacao.contrato_anterior'), 'id' => ''])@endcomponent
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('negociacao.moeda')</label>
                    <select name="moeda" id="" class='form-control' required>
                    <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($moedas as $moeda)                        
                        <option value="{{$moeda['valor']}}" @if ($negociacao['moeda'] == $moeda['valor']) selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-dark" href="{{route('negociacao.gerenciar')}}">@lang('buttons.voltar')</a>
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
                    url: "{{route('negociacao.preencheSelecao')}}",
                    method: "POST",
                    data: { valor: valor, dependente:dependente, _token: _token},
                    success:function(result) {
                        $('#'+dependente).html(result);
                    }, 
                    error : function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });

    });
</script>
@endsection