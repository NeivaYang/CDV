@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cdc.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("cdc.id")','@lang("cdc.nome")','@lang("cdc.cdc")','@lang("cdc.empresa")','@lang("cdc.cdc_pai")','@lang("cdc.situacao")']"
        v-bind:itens="{{json_encode($cdcs)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('cdc.cadastra')}}" 
        modal_criar="sim"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('cdc.editar', '')}}/"
        modal_editar="sim"
        titulo_editar="@lang('comum.titulo_editar')"
        deletar="{{route('cdc.remover', '')}}/"
        modal_deletar="sim"
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$cdcs}}
    </div>
    
    <modal nome="adicionar" titulo="@lang('cdc.cadastro')" css=''>
        <formulario id="formAdicionar" css="row" action="{{route('cdc.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cdc">@lang('cdc.cdc')
                            <input class="form-control" id="cdc" name="cdc" type="text" aria-describedby="" maxlength="10" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="nome">@lang('cdc.nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_empresa">@lang('cdc.empresa')
                            <select name="id_empresa" id="id_empresa" class='form-control' required >
                                <option value="">@lang('comum.seleciona_item')</option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->nome}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="cdc_pai">@lang('cdc.cdc_pai')
                            <select name="cdc_pai" id="cdc_pai" class='form-control' >
                                <option value="">@lang('comum.seleciona_item')</option>
                            </select>
                        </label>
                    </div>
                </div>
            </div> 
        </formulario>
        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    
    <modal nome="editar" titulo="@lang('cdc.edicao')" css=''>
        <formulario id="formEditar" v-bind:action="'{{route('cdc.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="cdc">@lang('cdc.cdc')
                            <input class="form-control" v-model="$store.state.item.cdc" id="cdc" name="cdc" type="text" aria-describedby="" maxlength="10" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="nome">@lang('cdc.nome')
                            <input class="form-control" v-model="$store.state.item.nome" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>        
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_empresa">@lang('cdc.empresa')
                            <select readonly disabled name="id_empresa" id="id_empresa" aria-readonly="true"  v-model="$store.state.item.id_empresa"  class='form-control'>    
                                @foreach ($empresas as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->nome}}</option>
                                @endforeach
                            </select>    
                        </label>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="cdc_pai">@lang('cdc.cdc_pai')
                            <select readonly disabled name="cdc_pai" id="cdc_pai" aria-readonly="true"  v-model="$store.state.item.cdc_pai"  class='form-control' >
                                    <option value="">@lang('cdc.nenhumcdc')</option>
                                    @foreach ($cdcspai as $cdcpai)
                                        <option value="{{$cdcpai->cdc}}">{{$cdcpai->cdc}} - {{$cdcpai->nome}}</option>
                                    @endforeach
                            </select>
                        </label>
                    </div>        
                </div>
            </div>
        </formulario>
        <span slot="botoes">
          <button form="formEditar" class="btn btn-info">@lang('buttons.atualizar')</button>
        </span>
    </modal>    
@endsection

@section('scripts')
    @include('_layouts._includes._validators_jquery')

    <script type="text/javascript">        
        $('#id_empresa').change(function(){
            if ($(this).val() != '' && $(this).val() != null){
                var dependente = $(this).data('dependente');
                var _token = $('input[name="_token"').val();
                $.ajax({
                    url: "{{route('cdc.buscar')}}",
                    method: "POST",
                    data: { id: $(this).val(), dependente:dependente, _token: _token},
                    success:function(result) {
                        $("#cdc_pai").empty();
                        if (result != '' && result != 0){
                            $("#cdc_pai").append($("<option></option>").attr("value", '').text(""));
                            $.each(result, function(key,value) {
                                $("#cdc_pai").append($("<option></option>").attr("value", value['cdc']).text(value['cdc'] + " - " + value['nome']));                                
                            });
                        }else{
                            $("#cdc_pai").append($("<option></option>").attr("value", '').text(""));
                        }
                    },
                    error : function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }else{
                $("#cdc_pai").empty().append($("<option></option>").attr("value", '').text("@lang('comum.seleciona_item')"));
            }
        });
    </script>
@endsection