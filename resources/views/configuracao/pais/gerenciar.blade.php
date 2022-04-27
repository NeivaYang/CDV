@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('pais.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("pais.id")','@lang("pais.nome")','@lang("pais.codigo_ddi")','@lang("pais.codigo_iso")']"
        v-bind:itens="{{json_encode($paises)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc"
        ordemcol="1"
        criar="{{route('pais.cadastra')}}"
        modal_criar="sim"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('pais.editar', '')}}/"
        modal_editar="sim"
        titulo_editar="@lang('comum.titulo_editar')"
        deletar="{{route('pais.remover', '')}}/"
        modal_deletar="sim"
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$paises}}
    </div>

    <modal nome="adicionar" titulo="@lang('pais.cadastro')" css=''>
        <formulario id="formAdicionar" css="row" action="{{route('pais.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('pais.nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>        
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="codigo_ddi">@lang('pais.codigo_ddi')
                            <input class="form-control" id="codigo_ddi" name="codigo_ddi" type="text" aria-describedby="" >                            
                        </label>
                    </div>
                            
                    <div class="form-group col-md-6">
                        <label for="codigo_iso">@lang('pais.codigo_iso')
                            <input class="form-control" id="codigo_iso" name="codigo_iso" type="text" aria-describedby="" >
                        </label>
                    </div>        
                </div>
            </div>
        </formulario>
        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    
    <modal nome="editar" titulo="@lang('pais.edicao')" css=''>
        <formulario id="formEditar" v-bind:action="'{{route('pais.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('pais.nome')
                            <input class="form-control" v-model="$store.state.item.nome" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>        
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="codigo_ddi">@lang('pais.codigo_ddi')
                            <input class="form-control" v-model="$store.state.item.codigo_ddi" id="codigo_ddi" name="codigo_ddi" type="text" aria-describedby="" >
                        </label>
                    </div>
        
                    <div class="form-group col-md-6">
                        <label for="codigo_iso">@lang('pais.codigo_iso')
                            <input class="form-control" v-model="$store.state.item.codigo_iso" id="codigo_iso" name="codigo_iso" type="text" aria-describedby="" >
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