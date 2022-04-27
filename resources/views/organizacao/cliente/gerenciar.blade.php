
@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.gerenciar_cliente')
@endsection

@section('conteudo')
@php 
    $cab2 = 'Fazendas no CDC '.Session::get('cdc');
@endphp
    <tabela-lista-new
        v-bind:titulos="['@lang("cliente.id")','@lang("cliente.nome")','@lang("cliente.email")','@lang("cliente.telefone")','@lang("cliente.pais")','@lang("cliente.tipo_pessoa")','@lang("cliente.documento")','@lang("cliente.situacao")', '@lang("cliente.corporacao")', '{{$cab2}}']"
        v-bind:itens="{{json_encode($clientes)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="asc"
        ordemcol="1"
        criar="{{route('cliente.cadastrar')}}" 
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('cliente.editar', '')}}"
        titulo_editar="@lang('comum.titulo_editar')"
        @if (Session::get('id_funcao') != 4 && Session::get('id_funcao') != 6)
            deletar="{{route('cliente.remover', '')}}/"
            titulo_deletar="@lang('comum.titulo_deletar')"
            modal_deletar="sim"
        @else
            deletar=""
            titulo_deletar=""
            modal_deletar=""        
        @endif
        outro1="{{route('cliente.cdc.gerenciar', '')}}"
        titulo_outro1="@lang('cliente.cdc_cliente')"
        icone_outro1="fas fa-fw fa-sm fa-user-shield"

        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$clientes}}
    </div>


    <modal nome="deletar" titulo="@lang('cliente.confirma_remover')" css=''>
        <formulario id="formExcluir" v-bind:action="'{{route('cliente.exclui')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">

            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nome">@lang('cliente.nome')
                            <input type="text" class="form-control" id="nome" name="nome" v-model="$store.state.item.nome" readonly/>
                        </label>
                    </div>
    
                    <div class="form-group col-md-6">
                        <label for="email">@lang('cliente.email')
                            <input type="email" class="form-control" id="email" name="email" v-model="$store.state.item.email" readonly/>
                        </label>
                    </div>    
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="telefone">@lang('cliente.telefone')
                            <input type="text" class="form-control" id="telefone" name="telefone" v-model="$store.state.item.telefone" readonly/>
                        </label>
                    </div>
        
                    <div class="form-group col-md-3">
                        <label for="id_pais">@lang('cliente.pais')
                            <select name="id_pais" id="id_pais" class='form-control' v-model="$store.state.item.id_pais" disabled>
                                @foreach ($paises as $pais)
                                <option value="{{$pais->id}}">{{$pais->nome}}</option>
                                @endforeach
                            </select>    
                        </label>
                    </div>    
    
                    <div class="form-group col-md-3">
                        <label for="tipo_pessoa">@lang('cliente.tipo_pessoa')
                            <select name="tipo_pessoa" id="tipo_pessoa" class='form-control' v-model="$store.state.item.tipo_pessoa" disabled>
                                <option value="fisica">@lang('cliente.pessoa_fisica')</option>
                                <option value="juridica">@lang('cliente.pessoa_juridica')</option>
                            </select>    
                        </label>
                    </div>
    
                    <div class="form-group col-md-3">
                        <label for="documento">@lang('cliente.documento')</label>
                        <input type="text" class="form-control" id="documento" name="documento" v-model="$store.state.item.documento" readonly/>
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
@endsection