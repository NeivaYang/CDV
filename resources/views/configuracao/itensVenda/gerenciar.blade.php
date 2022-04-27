@extends('_layouts._layout_site')
@section('head')@endsection
@section('titulo')@lang('comum.itensVenda')@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("produto.id")', '@lang("produto.nome")', '@lang("comum.tipo_item")', '@lang("comum.unidade")']"
        v-bind:itens="{{ json_encode($itensVenda) }}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="asc"
        ordemcol="1"

        criar="{{ route('itensVenda.cadastra') }}"
        titulo_criar="@lang('comum.titulo_criar')"

        editar="{{ route('itensVenda.edita', '') }}"
        titulo_editar="@lang('comum.titulo_editar')"

        deletar="{{ route('itensVenda.exclui', '') }}/"
        titulo_deletar="@lang('comum.titulo_deletar')"
        modal_deletar="sim"

        token="{{ csrf_token() }}">
    </tabela-lista-new>

    <div align="center" class='row'>
        {{ $itensVenda }}
    </div>

    <modal nome="deletar" titulo="@lang('cliente.confirma_remover')" css=''>
        <formulario id="formExcluir" v-bind:action="'{{ route('itensVenda.excluir') }}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">@lang('produto.nome')<em class="label-required"> *</em>
                            <input type="text" class="form-control text-capitalize" id="nome" name="nome" maxlength="50" v-model="$store.state.item.nome"readonly/>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="tipo">@lang('comum.tipo_item')
                            <input type="text" class="form-control" id="tipo" name="tipo" v-model="$store.state.item.tipo" readonly/>
                        </label>
                    </div>
    
                    <div class="form-group col-md-4">
                        <label for="unidade">@lang("comum.unidade")<em class="label-required"> *</em>
                            <input type="unidade" class="form-control text-capitalize" id="unidade" name="unidade" maxlength="50" v-model="$store.state.item.unidade" readonly/>
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
@include('_layouts._includes._validators_jquery')
    <script>
        $(document).ready(function(){
            //
        });
    </script>
@endsection
