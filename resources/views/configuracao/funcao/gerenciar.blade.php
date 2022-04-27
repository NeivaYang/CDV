@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('funcao.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("funcao.id")','@lang("funcao.nome")','@lang("funcao.funcao_pai")']"
        v-bind:itens="{{json_encode($funcoes)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('funcao.cadastra')}}"
        modal_criar = "sim"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('funcao.editar', '')}}/"
        modal_editar = "sim"
        titulo_editar="@lang('comum.titulo_editar')"
        deletar="{{route('funcao.remover', '')}}/"
        modal_deletar="sim"
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$funcoes}}
    </div>

    <modal nome="adicionar" titulo="@lang('funcao.cadastro')" css='modal-lg'>
        <formulario id="formAdicionar" css="row" action="{{route('funcao.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('funcao.nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>        
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="id_funcao_pai">@lang('funcao.funcao_pai')
                            <select name="id_funcao_pai" id="" class='form-control'>
                                <option value="">@lang('funcao.nenhumfuncao')</option>
                                @foreach ($funcoespai as $funcaopai)
                                    <option value="{{$funcaopai->id}}">{{$funcaopai->nome}}</option>
                                @endforeach
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
    
    <modal nome="editar" titulo="@lang('funcao.edicao')" css=' modal-lg'>
        <formulario id="formEditar" v-bind:action="'{{route('funcao.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id' hidden v-model="$store.state.item.id">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('funcao.nome')
                            <input class="form-control" v-model="$store.state.item.nome" id="nome" name="nome" type="text" aria-describedby="" placeholder="@lang('funcao.nome')" required>                        
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="id_funcao_pai">@lang('funcao.funcao_pai')
                            <select name="id_funcao_pai" id="" v-model="$store.state.item.id_funcao_pai"  class='form-control' >
                                <option value="">@lang('funcao.nenhumfuncao')</option>
                                @foreach ($funcoespai as $funcaopai)
                                    <option value="{{$funcaopai->id}}">{{$funcaopai->nome}}</option>
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
@endsection