@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.editar_cliente')
@endsection

@section('subtitulo')
    @lang('cliente.nome_do_cliente'){{$cliente['nome']}}
@endsection

@section('conteudo')
    <form action="{{route('cdc.cliente.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name='id' value="{{$clienteCdc['id']}}">
        <input type="hidden" name='id_cdc' value="{{$clienteCdc['id_cdc']}}">
        <input type="hidden" name="id_cliente" value="{{$cliente['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="id_cdc">@lang('fazenda.cdc')<em class="label-required"> *</em>
                        <select disabled name="id_cdc" id="id_cdc" class='form-control' required>
                        @foreach ($cdcs as $cdc)
                            <option value="{{$cdc->id}}" {{$clienteCdc['id_cdc'] == $cdc->id ? 'selected' : '' }}>{{$cdc->cdc}} - {{$cdc->nome}}</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label for="fazenda">@lang('cliente.fazenda')<em class="label-required"> *</em>
                        <input type="text" class="form-control" id="fazenda" name="fazenda" value="{{$clienteCdc['fazenda']}}" maxlength="100" required/>   
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="estados">@lang('cliente.uf_fazenda')<em class="label-required"> *</em>
                        <select id="estados" name="estado" class="form-control selectpicker" data-live-search="true" onchange=listaEstadosCidades(2,this.options[estados.selectedIndex].innerHTML); title="@lang('cidade.selecionar_est')" required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            @foreach($lista_estados as $estado)
                                <option value="{{$estado->id}}" {{$clienteCdc['id_estado'] == $estado->id ? 'selected' : '' }}>{{$estado->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>            

                <div class="form-group col-md-3">
                    <label for="cidades">@lang('cliente.cidade_fazenda')<em class="label-required"> *</em>
                        <select class="selectpicker form-control" id="cidades" name="cidade" data-live-search="true" required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            @foreach($lista_cidades as $cidades)
                                <option value="{{$cidades->id}}" {{$clienteCdc['id_cidade'] == $cidades->id ? 'selected' : '' }}>{{$cidades->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="latitude">@lang('cliente.latitude_fazenda')
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{$clienteCdc['latitude']}}"/>   
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="longitude">@lang('cliente.longitude_fazenda')
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{$clienteCdc['longitude']}}"/>   
                    </label>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="area_total">@lang('fazenda.area_total')
                        <input type="number" class="form-control pr-5" id="area_total" name="area_total" min="0" max="99999999" step="any" value="{{$clienteCdc['area_total']}}"/>
                        <em class="input-unidade">ha</em>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="area_irrigada">@lang('fazenda.area_irrigada')<em class="label-required"> *</em>
                        <input type="number" class="form-control" id="area_irrigada" name="area_irrigada" min="1" max="99999999" step="any" required value="{{$clienteCdc['area_irrigada']}}"/>
                        <em class="input-unidade">ha</em>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="cultura">@lang('cliente.cultura')<em class="label-required"> *</em>
                        <select name="cultura[]" class='form-control selectpicker' multiple required>
                            @foreach ($culturas as $cultura)
                                <option value="{{$cultura->id}}" {{ (array_search($cultura->id, $culturas_cdc) !== FALSE) ? "selected='selected'" : '' }}>{{$cultura->nome}}</option>
                            @endforeach
                        </select>                    
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="aspersor">@lang('cliente.aspersorQtd')
                        <input type="number" class="form-control" id="aspersor" name="aspersor_qtd" value="{{$clienteCdc['aspersor_qtd']}}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="microaspersor">@lang('cliente.microaspersorQtd')
                        <input type="text" class="form-control" id="microaspersor" name="microaspersor_qtd" value="{{$clienteCdc['microaspersor_qtd']}}"/>                    
                    </label>
                </div>
            
                <div class="form-group col-md-3">
                    <label for="gotejador">@lang('cliente.gotejadorQtd')
                        <input type="text" class="form-control" id="gotejador" name="gotejador_qtd" value="{{$clienteCdc['gotejador_qtd']}}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="pivo_central">@lang('cliente.pivoCentralQtd')
                        <input type="text" class="form-control" id="pivo_central" name="pivo_central_qtd" value="{{$clienteCdc['pivo_central_qtd']}}"/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="linear">@lang('cliente.linearQtd')
                        <input type="text" class="form-control" id="linear" name="linear_qtd" value="{{$clienteCdc['linear_qtd']}}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="autopropelido">@lang('cliente.autopropelidoQtd')
                        <input type="text" class="form-control" id="autopropelido" name="autopropelido_qtd" value="{{$clienteCdc['autopropelido_qtd']}}"/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-secondary" href="{{ route('cdc.cliente.gerenciar', $cliente['id']) }}">@lang('buttons.voltar')</a>
                </div>
            </div>        

        </div>

    </form>
@endsection

@section('scripts')
<script>
    function listaEstadosCidades(busca, id_busca, edit = ''){
        // Limpa as opções de cidades
        if (busca == 2 && id_busca != '' && id_busca != 0 && id_busca != null){                           
            $('#'+edit+'cidades option').each(function(){
                $(this).remove();
            });
            $('#'+edit+'cidades').selectpicker('refresh');
        }

        if (id_busca != '' && id_busca != 0 && id_busca != null){
            $.ajax({
                url: "{{route('cliente.buscaCEP', '')}}/"+id_busca,
                method: "GET",
                data: { busca: busca, id_busca: id_busca },
                success:function(result) {

                    if ('estados' in result){
                        result['estados'].map(function(array){                                
                            $('#'+edit+'estados').append($('<option>', {
                                value: array.id,
                                text: array.nome
                            }));                                
                        });
                        $('#'+edit+'estados').selectpicker('refresh');
                    }                       

                    if ('cidades' in result){
                        result['cidades'].map(function(array){
                            $('#'+edit+'cidades').append($('<option>', {
                                value: array.id,
                                text: array.nome
                            }));
                        });
                        $('#'+edit+'cidades').selectpicker('refresh');
                    }
                }, 
                error : function (jqXHR, textStatus, errorThrown){
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                }
            });
        }
    }
    
</script>
@endsection