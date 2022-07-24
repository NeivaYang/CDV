@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('negociacao.cadastrar_negociacao')
@endsection

@section('conteudo')
    <form action="{{route('negociacao.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        @if ($id_user > 0)
        <input type="hidden" name="id_user" value="{{$id_user}}">                        
        @endif

        @if($id_cliente > 0)
        <input type="hidden" name="id_cliente" value="{{$id_cliente}}">                        
        @endif

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user">@lang('negociacao.colaborador')</label>
                @if ($id_user > 0)
                    <select name="id2_user" id="" class='form-control' disabled>
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{$colaborador->id}}" @if ($colaborador->id == $id_user) selected @endif>{{$colaborador->nome}} ({{$colaborador->funcao}})</option>
                    @endforeach
                    </select>
                    <div class="line_disabled"></div>
                @else
                    <select name="id_user" id="" class='form-control dynamic' data-dependente='id_cliente' required>                            
                    <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($colaboradores as $colaborador)
                        <option value="{{$colaborador->id}}">{{$colaborador->nome}} ({{$colaborador->funcao}})</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                @endif
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('negociacao.cliente')</label>
                @if ($id_cliente > 0)
                    <select name="id2_cliente" id="id_cliente" class='form-control' required>
                    @foreach ($clientes as $cliente)                        
                        <option value="{{$cliente->id}}" @if ($cliente->id == $id_cliente) selected @endif>{{$cliente->nome}}</option>
                    @endforeach
                    </select>
                    <div class="line_disabled"></div>
                @else
                    @if ($id_cliente == 0 && $id_user > 0)
                    <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' required>
                    <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($clientes as $cliente)                        
                        <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                    @endforeach
                    </select>
                    <div class="line"></div>                        
                    @else
                    <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' required>
                    </select>
                    <div class="line"></div>                        
                    @endif
                @endif
                </div> 
                
                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')</label>
                    @if ($id_cliente > 0)
                    <select name="id_cdc" id="id_cdc" class='form-control' required>
                        @foreach ($cdcs as $cdc)
                            <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}} ({{$cdc->area_total}}/{{$cdc->area_irrigada}} )</option>
                        @endforeach
                    </select>    
                    <div class="line"></div>                            
                    @else
                    <select name="id_cdc" id="id_cdc" class='form-control' required>
                    </select>    
                    <div class="line"></div>                        
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo">@lang('negociacao.tipo')</label>
                    <select name="tipo" id="" class='form-control' required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        <option value="produto">@lang('negociacao.produto')</option>
                        <option value="serviço">@lang('negociacao.servico')</option>
                    </select>
                    <div class="line"></div>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('negociacao.data_inicio')</label>
                    <input name='data_inicio' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_inicio' required />
                    <div class="line"></div>
                </div>        
                
                <div class="form-group col-md-3">
                    <label for="contrato">@lang('negociacao.contrato')</label>
                    <select name="contrato" id="" class='form-control' required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        <option value="novo">@lang('negociacao.novo')</option>
                        <option value="renovação">@lang('negociacao.renovacao')</option>
                    </select>
                    <div class="line"></div>
                </div>
                
                <div class="form-group col-md-3">
                    <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby=""  >
                    @component('_layouts._components._inputLabel', ['texto'=>__('negociacao.contrato_anterior'), 'id' => ''])@endcomponent
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('negociacao.moeda')</label>
                    <select name="moeda" id="" class='form-control' required>
                    <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($moedas as $moeda)                        
                        <option value="{{$moeda['valor']}}">@lang('moeda.'.$moeda['valor'])</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
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