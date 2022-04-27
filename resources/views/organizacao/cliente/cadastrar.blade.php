@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.cadastrar_cliente')
@endsection

@section('conteudo')
    <form action="{{route('cliente.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome">@lang('cliente.nome')<em class="label-required"> *</em>
                        <input type="text" class="form-control" id="nome" name="nome" maxlength="50" aria-describedby="" value="{{ old('nome') }}" required/>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label for="email">@lang('cliente.email')
                        <input type="email" class="form-control" id="email" name="email" maxlength="190" aria-describedby="" value="{{ old('email') }}"/>
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo_pessoa">@lang('cliente.tipo_pessoa')<em class="label-required"> *</em>
                        <select name="tipo_pessoa" id="tipo_pessoa" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                            <option value="fisica" {{ (old('tipo_pessoa') == 'fisica') ? 'selected' : '' }}>@lang('cliente.pessoa_fisica')</option>
                            <option value="juridica" {{ (old('tipo_pessoa') == 'juridica') ? 'selected' : '' }}>@lang('cliente.pessoa_juridica')</option>
                        </select>    
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="corporacao">@lang('cliente.corporacao')<em class="label-required"> *</em>
                        <select name="corporacao" id="corporacao" class='form-control' value="{{ old('corporacao') }}" required >
                            <option value="0" {{ (old('corporacao') == 0) ? 'selected' : '' }}>@lang('comum.nao')</option>
                            <option value="1" {{ (old('corporacao') == 1) ? 'selected' : '' }}>@lang('comum.sim')</option>
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="documento">@lang('cliente.documento')
                        <input type="text" class="form-control" id="documento" name="documento" maxlength="20" aria-describedby="" value="{{ old('documento') }}"/>
                    </label>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="id_pais">@lang('cliente.pais')<em class="label-required"> *</em>
                        <select name="id_pais" id="id_pais" class='form-control' onchange=listaEstadosCidades(1,this.value); required >
                            <option value="">@lang('comum.seleciona_item')</option>
                            
                            @foreach ($paises as $pais)
                            <option value="{{$pais->id}}" {{ (old('id_pais') == $pais->id) ? 'selected' : '' }}>{{$pais->nome}}</option>
                            @endforeach
        
                        </select>    
                    </label>
                </div>    

                <div class="form-group col-md-3">
                    <label for="telefone">@lang('cliente.telefone')<em class="label-required"> *</em>
                        <input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" aria-describedby="" value="{{ old('telefone') }}" required/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="id_cdc">@lang('cliente.cdc')<em class="label-required"> *</em>
                        <select name="id_cdc" id="id_cdc" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($cdcs as $cdc)
                            <option value="{{$cdc->id}}" {{ (old('id_cdc') == $cdc->id) ? 'selected' : '' }}>{{$cdc->cdc}} - {{$cdc->nome}}</option>
                        @endforeach
                        </select>                            
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="area_total">@lang('cliente.area_total')
                        <input type="text" class="form-control pr-5" id="area_total" name="area_total" min="0" max="99999999" value="{{ old('area_total') }}"/>
                        <em class="input-unidade">ha</em>    
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="area_irrigada">@lang('cliente.area_irrigada')<em class="label-required"> *</em>
                        <input type="text" class="form-control pr-5" id="area_irrigada" name="area_irrigada" min="1" max="99999999" value="{{ old('area_irrigada') }}" required/>
                        <em class="input-unidade">ha</em>    
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="fazenda">@lang('cliente.fazenda')
                        <input type="text" class="form-control" id="fazenda" name="fazenda" maxlength="100" value="{{ old('fazenda') }}"/>   
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="estado">@lang('cliente.uf_fazenda')
                        <select id="estados" name="estado" class="form-control selectpicker" data-live-search="true" onchange=listaEstadosCidades(2,this.options[estados.selectedIndex].innerHTML); title="@lang('cidade.selecionar_pais')">
                            <option value="">@lang('comum.seleciona_item')</option>
                        </select>
                    </label>
                </div>
                
    
                <div class="form-group col-md-3">
                    <label for="fazenda">@lang('cliente.cidade_fazenda')<em class="label-required"> *</em>
                        <select class="selectpicker form-control" id="cidades" name="cidade" data-live-search="true"  value="{{ old('cidade') }}" required>
                            <option value="">@lang('comum.seleciona_item')</option>
                        </select>
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="latitude">@lang('cliente.latitude_fazenda')
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}"/>   
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="longitude">@lang('cliente.longitude_fazenda')
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}"/>   
                    </label>
                </div>
            </div>
    
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="cultura">@lang('cliente.cultura')<em class="label-required"> *</em>
                        <select name="cultura[]" id="cultura" class='form-control selectpicker' multiple title="@lang('comum.seleciona_item')" required>
                            @foreach ($culturas as $cultura)
                                <option value="{{$cultura->id}}">{{$cultura->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="aspersor_qtd">@lang('cliente.aspersorQtd')
                        <input type="number" class="form-control" id="aspersor" name="aspersor_qtd" value="{{ old('aspersor_qtd') }}"/>
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="aspersor">@lang('cliente.microaspersorQtd')
                        <input type="text" class="form-control" id="microaspersor" name="microaspersor_qtd" value="{{ old('microaspersor_qtd') }}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="gotejador">@lang('cliente.gotejadorQtd')
                        <input type="text" class="form-control" id="gotejador" name="gotejador_qtd" value="{{ old('gotejador_qtd') }}"/>
                    </label>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="pivo_central">@lang('cliente.pivoCentralQtd')
                        <input type="text" class="form-control" id="pivo_central" name="pivo_central_qtd" value="{{ old('pivo_central_qtd') }}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="linear">@lang('cliente.linearQtd')
                        <input type="text" class="form-control" id="linear" name="linear_qtd" value="{{ old('linear_qtd') }}"/>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="autopropelido">@lang('cliente.autopropelidoQtd')
                        <input type="text" class="form-control" id="autopropelido" name="autopropelido_qtd" value="{{ old('autopropelido_qtd') }}"/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('cliente.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>        
        </div>

    </form>
@endsection

@section('scripts')
    <script>
        $(function(){
            $('#tipo_pessoa').change(function(){    if($(this).val() == 'fisica')   $('#corporacao').val(0);})
            $('#corporacao').change(function(){    if($(this).val() == 1)   $('#tipo_pessoa').val('juridica');})

            $('#cultura').selectpicker({
                style: '',
                styleBase: 'form-control'
            });            
        })

        function listaEstadosCidades(busca, id_busca){

            // Limpa as opções de cidades
            if (busca == 2 && id_busca != '' && id_busca != 0 && id_busca != null){               
                
                $('#cidades option').each(function(){
                    $(this).remove();
                });
                $('#cidades').selectpicker('refresh');
            }

            if (id_busca != '' && id_busca != 0 && id_busca != null){
                $.ajax({
                    url: "{{route('cliente.buscaCEP', '')}}/"+id_busca,
                    method: "GET",
                    data: { busca: busca, id_busca: id_busca },
                    success:function(result) {

                        if ('estados' in result){
                            result['estados'].map(function(array){                                
                                $('#estados').append($('<option>', {
                                    value: array.id,
                                    text: array.nome
                                }));                                
                            });
                            $('#estados').selectpicker('refresh');
                        }                       

                        if ('cidades' in result){
                            result['cidades'].map(function(array){                                
                                $('#cidades').append($('<option>', {
                                    value: array.id,
                                    text: array.nome
                                }));
                            });
                            $('#cidades').selectpicker('refresh');
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