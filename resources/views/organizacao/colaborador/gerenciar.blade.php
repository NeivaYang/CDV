@extends('_layouts._layout_site')

@section('titulo')
    @lang('colaborador.titulo')
@endsection

@section('conteudo')
    
    <tabela-lista-new
        v-bind:titulos="['@lang("colaborador.id")','@lang("colaborador.codigo")','@lang("colaborador.nome")','@lang("colaborador.celular")', '@lang("colaborador.email")', '@lang("colaborador.situacao")', '@lang("colaborador.funcao")', '@lang("colaborador.cdc")']"
        v-bind:itens="{{json_encode($listaUsuarios)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="0" 
        criar="{{route('colaborador.cadastrar')}}"  
        titulo_criar="@lang('comum.titulo_criar')"

        editar="{{route('colaborador.editar', '')}}" 
        titulo_editar="@lang('comum.titulo_editar')"

        deletar="{{route('colaborador.remover', '')}}" 
        titulo_deletar="@lang('comum.titulo_deletar')"

        token="{{ csrf_token() }}"
    ></tabela-lista-new>

    <div align="center" class='row'>
        {{$listaUsuarios}}
    </div>


    <!-- Telas de Modal -->
    <!--<modal nome="editar" titulo="@lang('colaborador.editar_colaborador')">
        <formulario id="formEditar" v-bind:action="'{{route('colaborador.atualizar')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="hidden" name='id' v-model="$store.state.item.id">
            <input type="hidden" name="nome" v-model="$store.state.item.nome">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="enome">@lang('colaborador.nome')</label>
                        <input class="form-control" id="enome" name="enome" type="text" v-model="$store.state.item.nome" aria-describedby="" placeholder="@lang('colaborador.nome')" disabled>
                        <div class="line_disabled"></div>
                    </div>
        
                    <div class="form-group col-md-3">
                        <label for="ecelular">@lang('colaborador.celular')</label>
                        <input class="form-control" id="ecelular" name="celular" type="text" v-model="$store.state.item.celular" aria-describedby="" placeholder="@lang('colaborador.celular')" required>
                        @component('_layouts._components._inputLabel', ['texto'=>'', 'id' => ''])@endcomponent                                                                                                
                    </div>
        
                    <div class="form-group col-md-3">
                        <label for="ecodigo_idioma">@lang('colaborador.codigo_idioma')</label>
                        <select class="form-control" name="codigo_idioma"  v-model="$store.state.item.codigo_idioma" id="ecodigo_idioma" required>
                            @foreach($idiomas as $idioma)
                                <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                            @endforeach
                        </select> 
                        <div class="line"></div>
                    </div>        
                </div>
            </div>

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="id_funcao">@lang('colaborador.funcao')</label>
                        <select name="id_funcao" id="" v-model="$store.state.item.id_funcao"  class='form-control' >
                            
                            @foreach ($funcoes as $funcao)
                                <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                            @endforeach
        
                        </select>
                        <div class="line"></div>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="id_cdc">@lang('colaborador.cdc')</label>
                        <select name="id_cdc" id="" v-model="$store.state.item.id_cdc"  class='form-control' >
                   
                            @foreach ($cdcs as $cdc)
                                <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                            @endforeach
        
                        </select>
                        <div class="line"></div>
                    </div>        
                </div>
            </div>

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="eemail" >@lang('colaborador.email')</label>
                        <input class="form-control" id="eemail" name="email" type="email" aria-describedby="" v-model="$store.state.item.email" placeholder="@lang('colaborador.email')" required>
                        @component('_layouts._components._inputLabel', ['texto'=>'', 'id' => ''])@endcomponent                                                                                                
                    </div>
                    
                    <div class="form-group  col-md-4">
                        <label for="epassword">@lang('colaborador.senha')</label>
                        <input class="form-control" id="epassword" minlength="6" name="password" type="password"  placeholder="@lang('colaborador.informe_senha_alt')" >
                        @component('_layouts._components._inputLabel', ['texto'=>'', 'id' => ''])@endcomponent                                                                                                                
                    </div>

                    <div class="form-group col-md-4">
                        <label for="econfirmpassword">@lang('colaborador.confirmar_senha')</label>
                        <input class="form-control" id="econfirmpassword" name="confirm_password" type="password" placeholder="@lang('colaborador.confirmar_senha')" >
                        @component('_layouts._components._inputLabel', ['texto'=>'', 'id' => ''])@endcomponent                                                                                                
                    </div>        
                </div>
            </div>            
        </formulario>
        <span slot="botoes">
            <button form="formEditar" class="btn btn-info" >@lang('buttons.atualizar')</button>
        </span>
    </modal>

    <modal nome="deletar" titulo="@lang('colaborador.excluir_colaborador')" css=''>
        <formulario id="formExcluir" v-bind:action="'{{route('colaborador.exclui')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id' hidden v-model="$store.state.item.id">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="xnome">@lang('colaborador.nome')</label>
                        <input class="form-control" id="xnome" name="xnome" type="text" v-model="$store.state.item.nome" aria-describedby="" placeholder="@lang('usuarios.nome')" disabled/>
                        <div class="line_disabled"></div>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="xcelular">@lang('colaborador.celular')</label>
                        <input class="form-control" id="xcelular" name="xcelular" type="text" v-model="$store.state.item.celular" aria-describedby="" placeholder="@lang('usuarios.celular')" disabled/>
                        <div class="line_disabled"></div>
                    </div>                                    

                    <div class="form-group col-md-4">
                        <label for="xcodigo_idioma">@lang('usuarios.codigo_idioma')</label>
                        <select class="form-control" name="xcodigo_idioma"  v-model="$store.state.item.codigo_idioma" id="xcodigo_idioma" disabled>
                            @foreach($idiomas as $idioma)
                                <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                            @endforeach
                        </select> 
                        <div class="line_disabled"></div>
                    </div>                   
                </div>
            </div>
    
            <div class='col-12'>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="xemail" >@lang('usuarios.email')</label>
                        <input class="form-control" id="xemail" name="xmail" type="email" aria-describedby="" v-model="$store.state.item.email" placeholder="@lang('usuarios.email')" disabled>
                        <div class="line_disabled"></div>
                    </div>
                </div>
            </div>            
        </formulario>
        <span slot="botoes">
            <button form="formExcluir" class="btn btn-info">@lang('buttons.deletar')</button>
        </span>
    </modal>-->   
@endsection

@section('scripts')
    <!-- Includes to combobox style -->
<script type="text/javascript">

    $( document ).ready(function() {
        $("#formAdicionar").submit(function(e){
            if (!checkIfPasswordsMatch()){
                alert("{{__('colaborador.senhasNaoBatem')}}");
                return false;
            }
        });

        $("#formEditar").submit(function(e){
            if (!checkIfPasswordsEditMatch()){
                alert("{{__('colaborador.senhasNaoBatem')}}");
                return false;
            }
        });
    });    


    function checkIfPasswordsMatch(){
        let senha1 = $("#password").val();
        let senha2 = $("#confirmpassword").val();
        if(senha1 !== "" && senha1 === senha2){
            return true;
        }else{
            return false;
        }
    }

    function checkIfPasswordsEditMatch(){
        let senha1 = $("#epassword").val();
        let senha2 = $("#econfirmpassword").val();
        if(senha1 === "" || senha1 === senha2){
            return true;
        }else{
            return false;
        }
    }
</script>

<script type="text/javascript">
        window.onload = function(){
        }
        $('#editar').on('shown.bs.modal', function (e) {
            $("#ecdcs").selectpicker('refresh');
        })
</script>
@endsection