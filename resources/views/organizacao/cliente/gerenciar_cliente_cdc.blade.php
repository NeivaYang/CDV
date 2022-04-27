@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.cdc_cliente')
@endsection

@section('subtitulo')
    @lang('cliente.nome_do_cliente'){{$cliente['nome']}}
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("cliente.id")','@lang("cliente.cdc")','@lang("cliente.area_total")','@lang("cliente.area_irrigada")','@lang("cliente.fazenda")', '@lang('cliente.cidade_fazenda')', '@lang('cliente.uf_fazenda')', '@lang('cliente.latitude_fazenda')', '@lang('cliente.longitude_fazenda')']"
        v-bind:itens="{{json_encode($cliente_cdcs)}}"
        titulo_acoes="@lang('comum.acoes')"
        ordem="desc"
        ordemcol="1"
        @if (count($cdcsLivres) > 0)
        criar="{{route('cliente.cdc.cadastra')}}"
        modal_criar = "sim"
        titulo_criar="@lang('comum.titulo_criar')"
        @endif
        editar="{{route('cliente.cdc.editar', '')}}/"
        modal_editar = "sim"
        titulo_editar="@lang('comum.titulo_editar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$cliente_cdcs}}
    </div>

    @if (count($cdcsLivres) > 0)
    <modal nome="adicionar" titulo="@lang('cliente.cadastrar_cliente_cdc')" css=''>
        <formulario id="formAdicionar" css="row" action="{{route('cliente.cdc.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id_cliente' hidden value="{{$cliente['id']}}">

            <div class="form-group col-md-12">
                <label for="id_cdc">@lang('fazenda.cdc')<em class="label-required"> *</em>
                    <select name="id_cdc" id="id_cdc" class='form-control' required>
                    @foreach ($cdcs as $cdc)
                        <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                    @endforeach
                    </select>                    
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="area_total">@lang('fazenda.area_total')
                    <input type="number" class="form-control pr-5" id="area_total" name="area_total" min="0" max="99999999" step="any"/>
                    <em class="input-unidade">ha</em>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="area_irrigada">@lang('fazenda.area_irrigada')<em class="label-required"> *</em>
                    <input type="number" class="form-control" id="area_irrigada" name="area_irrigada" min="1" max="99999999" step="any" required/>
                    <em class="input-unidade">ha</em>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="fazenda">@lang('cliente.fazenda')
                    <input type="text" class="form-control" id="fazenda" name="fazenda" maxlength="100"/>   
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="estados">@lang('cliente.uf_fazenda')
                    <select id="estados" name="estado" class="form-control selectpicker" data-live-search="true" onchange=listaEstadosCidades(2,this.options[estados.selectedIndex].innerHTML); title="@lang('comum.seleciona_item')">
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach($lista_estados as $estado)
                            <option value="{{$estado->id}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </label>
            </div>            

            <div class="form-group col-md-4">
                <label for="cidades">@lang('cliente.cidade_fazenda')<em class="label-required"> *</em>
                    <select class="selectpicker form-control" id="cidades" name="cidade" data-live-search="true" required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach($lista_cidades as $cidades)
                            <option value="{{$cidades->id}}">{{$cidades->nome}}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="latitude">@lang('cliente.latitude_fazenda')
                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" value="{{ old('latitude') }}"/>   
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="longitude">@lang('cliente.longitude_fazenda')
                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" value="{{ old('longitude') }}"/>   
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="cultura">@lang('cliente.cultura')<em class="label-required"> *</em>
                    <select name="cultura[]" class='form-control selectpicker' multiple required>
                        @foreach ($culturas as $cultura)
                            <option value="{{$cultura->id}}">{{$cultura->nome}}</option>
                        @endforeach
                    </select>                    
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="aspersor">@lang('cliente.aspersorQtd')
                    <input type="number" class="form-control" id="aspersor" name="aspersor_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="microaspersor">@lang('cliente.microaspersorQtd')
                    <input type="text" class="form-control" id="microaspersor" name="microaspersor_qtd"/>                    
                </label>
            </div>
        
            <div class="form-group col-md-4">
                <label for="gotejador">@lang('cliente.gotejadorQtd')
                    <input type="text" class="form-control" id="gotejador" name="gotejador_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="pivo_central">@lang('cliente.pivoCentralQtd')
                    <input type="text" class="form-control" id="pivo_central" name="pivo_central_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="linear">@lang('cliente.linearQtd')
                    <input type="text" class="form-control" id="linear" name="linear_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="autopropelido">@lang('cliente.autopropelidoQtd')
                    <input type="text" class="form-control" id="autopropelido" name="autopropelido_qtd"/>
                </label>
            </div>

            <div class="col-12 mt-2">
                <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
            </div>
        </formulario>
        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    @endif
    
    <modal nome="editar" titulo="@lang('cliente.editar_cliente_cdc')" css=''>
        <formulario id="formEditar" v-bind:action="'{{route('cliente.cdc.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <input type="text" name='id_cdc' hidden v-model="$store.state.item.id_cdc">
            <input type="text" name='id_cliente' hidden value="{{$cliente['id']}}">

            <div class="form-group col-md-12">
                <label for="id_cdc2">@lang('cliente.cdc')
                    <select disabled name="id_cdc2" id="" aria-readonly="true"  v-model="$store.state.item.id_cdc"  class='form-control' >
                        @foreach ($cdcs as $cdc)
                        <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                        @endforeach
                    </select>                    
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="area_total">@lang('cliente.area_total')
                    <input type="number" class="form-control" id="area_total" name="area_total" min="0" max="99999999" step="any" v-model="$store.state.item.area_total" />
                    <em class="input-unidade">ha</em>    
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="area_irrigada">@lang('cliente.area_irrigada')<em class="label-required"> *</em>
                    <input type="number" class="form-control" id="area_irrigada" name="area_irrigada" min="1" max="99999999" step="any" v-model="$store.state.item.area_irrigada" required/>
                    <em class="input-unidade">ha</em>                    
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="fazenda">@lang('cliente.fazenda')
                    <input type="text" class="form-control" id="fazenda" name="fazenda" maxlength="100" v-model="$store.state.item.fazenda"/>                
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="estados">@lang('cliente.uf_fazenda')
                    <select id="edit_estados" name="estado" class="form-control selectpicker" data-live-search="true" onchange=listaEstadosCidades(2,(this.options[edit_estados.selectedIndex].innerHTML),"edit_"); title="@lang('comum.seleciona_item')">
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach($lista_estados as $estado)
                            <option value="{{$estado->id}}">{{$estado->nome}}</option>
                        @endforeach
                    </select>
                </label>
            </div>            

            <div class="form-group col-md-4">
                <label for="cidades">@lang('cliente.cidade_fazenda')<em class="label-required"> *</em>
                    <select class="selectpicker form-control" id="edit_cidades" name="cidade" data-live-search="true" required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        @foreach($lista_cidades as $cidades)
                            <option value="{{$cidades->id}}">{{$cidades->nome}}</option>
                        @endforeach
                    </select>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="latitude">@lang('cliente.latitude_fazenda')
                    <input type="number" step="any" class="form-control" id="latitude" name="latitude" v-model="$store.state.item.latitude"/>   
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="longitude">@lang('cliente.longitude_fazenda')
                    <input type="number" step="any" class="form-control" id="longitude" name="longitude" v-model="$store.state.item.longitude"/>   
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="cultura">@lang('cliente.cultura')<em class="label-required"> *</em>
                    <select name="cultura[]" id="cultura" class='form-control selectpicker' multiple required>
                        @foreach ($culturas as $cultura)
                            <option value="{{$cultura->id}}" >{{$cultura->nome}}</option>
                        @endforeach                        
                    </select>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="aspensor">@lang('cliente.aspersorQtd')
                    <input type="number" class="form-control" id="aspersor" name="aspersor_qtd" v-model="$store.state.item.aspersor_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="microaspersor">@lang('cliente.microaspersorQtd')
                    <input type="text" class="form-control" id="microaspersor" name="microaspersor_qtd" v-model="$store.state.item.microaspersor_qtd"/>
                </label>
            </div>
        
            <div class="form-group col-md-4">
                <label for="gotejador">@lang('cliente.gotejadorQtd')
                    <input type="text" class="form-control" id="gotejador" name="gotejador_qtd" v-model="$store.state.item.gotejador_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="pivo_central">@lang('cliente.pivoCentralQtd')
                    <input type="text" class="form-control" id="pivo_central" name="pivo_central_qtd" v-model="$store.state.item.pivo_central_qtd"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="linear">@lang('cliente.linearQtd')
                    <input type="text" class="form-control" id="linear" name="linear_qtd" v-model="$store.state.item.linear_qt"/>
                </label>
            </div>

            <div class="form-group col-md-4">
                <label for="autopropelido">@lang('cliente.autopropelidoQtd')
                    <input type="text" class="form-control" id="autopropelido" name="autopropelido_qtd" v-model="$store.state.item.autopropelido_qtd"/>
                </label>
            </div>

            <div class="col-12 mt-2">
                <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
            </div>
        </formulario>
        <span slot="botoes">
            <button form="formEditar" class="btn btn-info">@lang('buttons.atualizar')</button>
        </span>
    </modal>

@endsection

@section('scripts')
<script>
    $(".edit").click(function(){

        var id_cdc_regiao = $(this).attr('value');        
        var dependente = $(this).data('dependente');
        var _token = $('input[name="_token"').val();

        $.ajax({
            url: "{{route('cliente.cdc.buscaSelects')}}",
            method: "POST",
            data: { id_cdc_regiao: id_cdc_regiao, dependente:dependente, _token: _token},
            success:function(result) {
                // Culturas.
                $("#cultura > option").each(function() {
                    $(this).attr("selected", false);
                });
                $('#cultura').selectpicker('refresh');

                $("#cultura > option").each(function() {
                    if (jQuery.inArray(this.value, result['culturas']) !== -1){
                        $(this).attr('selected','selected');
                    }
                });

                // Cidades.
                $("#edit_cidades > option").each(function() {
                    $(this).attr("selected", false);
                });
                $('#edit_cidades').selectpicker('refresh');

                $("#edit_cidades > option").each(function() {                    
                    if (this.value == result['cidade']){
                        $(this).attr('selected','selected');
                    }
                });

                // Estados.
                $("#edit_estados > option").each(function() {
                    $(this).attr("selected", false);
                });
                $('#edit_estados').selectpicker('refresh');

                $("#edit_estados > option").each(function() {
                    if (this.value == result['estado']){
                        $(this).attr('selected','selected');
                    }
                });

                // Refresh dos selects.
                $('#cultura').selectpicker('refresh');
                $('#edit_cidades').selectpicker('refresh');
                $('#edit_estados').selectpicker('refresh');
            }, 
            error : function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            }
        });
    });

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