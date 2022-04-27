@extends('_layouts._layout_site')

@section('titulo')
    @lang('usuarios.titulo')
@endsection

@section('conteudo')
    
    <tabela-lista-new
        v-bind:titulos="['@lang("usuarios.id")','@lang("usuarios.codigo")','@lang("usuarios.nome")','@lang("usuarios.telefone")', '@lang("usuarios.email")', '@lang("usuarios.situacao")']"
        v-bind:itens="{{json_encode($listaUsuarios)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"        
        ordem="desc" ordemcol="0" 
        criar="{{route('usuario.cadastra')}}"  
        titulo_criar="@lang('comum.titulo_criar')"
        modal_criar = "sim"
        editar="{{route('usuario.ver', '')}}/"
        titulo_editar="@lang('comum.titulo_editar')"
        modal_editar = "sim" 
        deletar="{{route('usuario.remover', '')}}/" 
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>

    <div align="center" class='row'>
        {{$listaUsuarios}}
    </div>


    <!-- Telas de Modal -->
    <modal nome="adicionar" titulo="@lang('usuarios.cadastro')">
        <formulario id="formAdicionar" css="row" action="{{route('usuario.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">
    
            <div class='col-12'>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="nome">@lang('usuarios.primeiro_nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="sobrenome">@lang('usuarios.ultimo_nome')
                            <input class="form-control" id="sobrenome" name="sobrenome" type="text" aria-describedby="" required>
                        </label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="codigo_idioma">@lang('usuarios.idioma')
                            <select class="form-control" name="codigo_idioma" id="codigo_idioma" required>
                                @foreach($idiomas as $idioma)
                                    <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                                @endforeach
                            </select>    
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="celular">@lang('usuarios.celular')
                            <input class="form-control" id="celular" name="celular" type="text" aria-describedby=""  required>
                        </label>
                    </div>
                </div>
                <div class="form-row">                    
                    <div class="form-group col-md-4">
                        <label for="email">@lang('usuarios.email')
                            <input class="form-control" id="email" name="email" type="email" aria-describedby="" required>
                        </label>
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="password">@lang('usuarios.senha')
                            <input class="form-control" id="password" minlength="6" name="password" type="password" required>
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="confirmpassword">@lang('usuarios.confirmar_senha')
                            <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" required>
                        </label>
                    </div>                            
                </div>
            </div>
        </formulario>

        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    
    <modal nome="editar" titulo="@lang('usuarios.edicao')">
        <formulario id="formEditar" v-bind:action="'{{route('usuario.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="hidden" name='id' v-model="$store.state.item.id">
            <input type="hidden" name="nome" v-model="$store.state.item.nome">

            <div class='col-12'>
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="enome">@lang('usuarios.nome')
                            <input class="form-control" id="enome" name="enome" type="text" v-model="$store.state.item.nome" aria-describedby="" disabled>
                        </label>
                    </div>        
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ecodigo_idioma">@lang('usuarios.idioma')
                            <select class="form-control" name="codigo_idioma"  v-model="$store.state.item.codigo_idioma" id="ecodigo_idioma" required>
                                @foreach($idiomas as $idioma)
                                    <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                                @endforeach
                            </select>                            
                        </label>
                    </div>    
                    <div class="form-group col-md-4">
                        <label for="ecelular">@lang('usuarios.celular')
                            <input class="form-control" id="ecelular" name="celular" type="text" v-model="$store.state.item.celular" aria-describedby="" required>
                        </label>
                    </div>                                    
                </div>
                <div class="form-row">                    
                    <div class="form-group col-md-4">
                        <label for="eemail" >@lang('usuarios.email')
                            <input class="form-control" id="eemail" name="email" type="email" aria-describedby="" v-model="$store.state.item.email" required>
                        </label>
                    </div>
                    <div class="form-group  col-md-4">
                        <label for="epassword">@lang('usuarios.senha')
                            <input class="form-control" id="epassword" minlength="6" name="password" type="password"  placeholder="@lang('usuarios.informe_senha_alt')" >                        
                        </label>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="econfirmpassword">@lang('usuarios.confirmar_senha')
                            <input class="form-control" id="econfirmpassword" name="confirm_password" type="password" placeholder="@lang('usuarios.confirmar_senha')" >                        
                        </label>
                    </div>                                    
                </div>
            </div>            
        </formulario>

        <span slot="botoes">
          <button form="formEditar" class="btn btn-info" >@lang('buttons.atualizar')</button>
        </span>
    </modal>
    
    <modal nome="deletar" titulo="@lang('usuarios.exclusao')" css=''>
        <formulario id="formExcluir" v-bind:action="'{{route('usuario.exclui')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="xnome">@lang('usuarios.nome')
                            <input class="form-control" id="xnome" name="xnome" type="text" v-model="$store.state.item.nome" aria-describedby="" disabled/>
                        </label>
                    </div>        
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="xcodigo_idioma">@lang('usuarios.idioma')
                            <select class="form-control" name="xcodigo_idioma"  v-model="$store.state.item.codigo_idioma" id="xcodigo_idioma" disabled>
                                @foreach($idiomas as $idioma)
                                    <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                                @endforeach
                            </select> 
                        </label>
                    </div>                   
                    <div class="form-group col-md-4">
                        <label for="xcelular">@lang('usuarios.celular')
                            <input class="form-control" id="xcelular" name="xcelular" type="text" v-model="$store.state.item.celular" aria-describedby="" disabled/>
                        </label>
                    </div>                                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="xemail" >@lang('usuarios.email')
                            <input class="form-control" id="xemail" name="xmail" type="email" aria-describedby="" v-model="$store.state.item.email" disabled>
                        </label>
                    </div>
                </div>
            </div>            
        </formulario>
        <span slot="botoes">
            <button form="formExcluir" class="btn btn-info">@lang('buttons.deletar')</button>
        </span>
    </modal>   
@endsection

@section('scripts')
    <!-- Includes to combobox style -->
<script type="text/javascript">

    $( document ).ready(function() {
        $("#formAdicionar").submit(function(e){
            if (!checkIfPasswordsMatch()){
                alert("{{__('usuarios.senhasNaoBatem')}}");
                return false;
            }
        });

        $("#formEditar").submit(function(e){
            if (!checkIfPasswordsEditMatch()){
                alert("{{__('usuarios.senhasNaoBatem')}}");
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