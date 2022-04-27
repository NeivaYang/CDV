@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('negociacao.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("negociacao.id")','@lang("negociacao.codigo")','@lang("negociacao.colaborador")','@lang("negociacao.cliente")','@lang("negociacao.data_inicio")','@lang("negociacao.contrato")','@lang("negociacao.tipo")','@lang("negociacao.situacao")']"
        v-bind:itens="{{json_encode($negociacao)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('negociacao.cadastrar')}}"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('negociacao.editar', '')}}"
        titulo_editar="@lang('comum.titulo_editar')"
        outro1="{{route('negociacao.encerrar', '')}}"
        titulo_outro1="@lang('comum.encerrar')"
        icone_outro1="fas fa-fw fa-lg fa-ban"
        outro2="{{route('proposta.gerenciar', '')}}" 
        icone_outro2="fas fa-fw fa-lg fa-hand-holding-usd"
        titulo_outro2="@lang('comum.criar_proposta')"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$negociacao}}
    </div>     
@endsection

@section('scripts')
@endsection