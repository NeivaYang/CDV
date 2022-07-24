@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('concorrente.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("concorrente.id")','@lang("concorrente.nome")']"
        v-bind:itens="{{json_encode($concorrentes)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('concorrente.cadastra')}}"
        modal_criar="sim"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('concorrente.editar', '')}}/"
        modal_editar="sim"
        titulo_editar="@lang('comum.titulo_editar')"
        deletar="{{route('concorrente.remover', '')}}/"
        modal_deletar="sim"
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>

    <div class="d-flex justify-content-center pb-5">
        {{$concorrentes}}
    </div>

    <modal nome="adicionar" titulo="@lang('concorrente.cadastro')" css='modal-lg'>
        <formulario id="formAdicionar" css="row" action="{{route('concorrente.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('concorrente.nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>        
                </div>
            </div>
        </formulario>
        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    
    <modal nome="editar" titulo="@lang('concorrente.edicao')" css='modal-lg'>
        <formulario id="formEditar" v-bind:action="'{{route('concorrente.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="nome">@lang('concorrente.nome')
                            <input class="form-control" v-model="$store.state.item.nome" id="nome" name="nome" type="text" aria-describedby="" required>
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