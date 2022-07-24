@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('oportunidade.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="{{json_encode($titulos_tabela)}}"
        v-bind:itens="{{json_encode($oportunidades)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"

        criar="{{route('oportunidade.cadastrar')}}"
        titulo_criar="@lang('comum.titulo_criar')"

        editar="{{route('oportunidade.editar', '')}}"
        titulo_editar="@lang('comum.titulo_editar')"

        outro1="{{route('oportunidade.remover', '')}}"
        titulo_outro1="@lang('comum.titulo_deletar')"
        icone_outro1="fas fa-fw fa-sm fa-trash-alt"

        outro2="{{route('proposta.geral.gerenciar', '')}}" 
        icone_outro2="fas fa-fw fa-sm fa-hand-holding-usd"
        titulo_outro2="@lang('comum.proposta')"
    ></tabela-lista-new> 

    <div class="d-flex justify-content-center pb-5">
        {{$oportunidades}}
    </div>     
@endsection

@section('scripts')
@endsection