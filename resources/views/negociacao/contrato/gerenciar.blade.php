@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('contrato.gerenciar_contratos')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("contrato.id")','@lang("contrato.numero")','@lang("oportunidade.colaborador")','@lang("oportunidade.cliente")','@lang("contrato.data_inicio")','@lang("contrato.data_termino")']"
        v-bind:itens="{{json_encode($contratos)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        detalhe="{{route('contrato.visualizar', '')}}"
        titulo_detalhe="@lang('comum.titulo_detalhe')"
    ></tabela-lista-new>

    <div class="d-flex justify-content-center pb-5">
        {{$contratos}}
    </div> 
@endsection

@section('scripts')
@endsection