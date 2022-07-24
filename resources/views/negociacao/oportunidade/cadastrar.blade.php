@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('oportunidade.cadastrar_oportunidade')
@endsection

@section('conteudo')
    <form action="{{route('oportunidade.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="estagio">@lang('oportunidade.estagio_inicial')<em class="label-required"> *</em>
                        <select name="estagio" id="" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            <option value="0">@lang('oportunidade.prospecto')</option>
                            <option value="1">@lang('oportunidade.reuniao')</option>
                            <option value="2">@lang('oportunidade.negociacao')</option>
                        </select>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user">@lang('oportunidade.colaborador')<em class="label-required"> *</em>
                        @if (count($colaboradores) > 1)
                        <select name="id_user" id="" class='form-control dynamic' data-dependente='id_cliente' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                        @else
                        <select name="id_user" id="" class='form-control' required>
                        @endif
                        @foreach ($colaboradores as $colaborador)
                            <option value="{{$colaborador->id}}">{{$colaborador->nome}} ({{$colaborador->funcao}})</option>
                        @endforeach
                        </select>                        
                    </label>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('oportunidade.cliente')<em class="label-required"> *</em>
                        <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' required>
                        @if (count($colaboradores) == 1)
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($clientes as $cliente)                        
                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                        @endforeach
                        @endif
                        </select>
                    </label>
                </div> 
                
                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')<em class="label-required"> *</em>
                        <select name="id_cdc" id="id_cdc" class='form-control' required>
                        </select>    
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('oportunidade.moeda')<em class="label-required"> *</em>
                        <select name="moeda" id="moeda" class='form-control' required>
                        @foreach ($moedas as $moeda)                        
                            <option value="{{$moeda['valor']}}" @if ($moeda['valor'] == 'real') selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('oportunidade.data_inicio')<em class="label-required"> *</em>
                        <input name='data_inicio' value="{{date('Y-m-d')}}" class='form-control' type='date' id='data_inicio' required/>                    
                    </label>
                </div>        

                <div class="form-group col-md-3">
                    <label for="contrato">@lang('oportunidade.contrato')<em class="label-required"> *</em>
                        <select name="contrato" id="" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            <option value="novo">@lang('oportunidade.novo')</option>
                            <option value="renovacao">@lang('oportunidade.renovacao')</option>
                        </select>    
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="contrato_anterior">@lang('negociacao.contrato_anterior')
                        <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby=""/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
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

    });
</script>
@endsection