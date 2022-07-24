@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.cdc_cliente')
@endsection

@section('subtitulo')
    @lang('cliente.nome_do_cliente'){{$cliente['nome']}}
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("cliente.id")','@lang("cliente.cdc")','@lang("cliente.area_total")','@lang("cliente.area_irrigada")','@lang("cliente.fazenda")', '@lang('cliente.cidade_fazenda')', '@lang('cliente.uf_fazenda')', '@lang('cliente.latitude_fazenda')', '@lang('cliente.longitude_fazenda')']"
        v-bind:itens="{{json_encode($cliente_cdcs)}}"
        titulo_acoes="@lang('comum.acoes')"
        ordem="desc"
        ordemcol="1"
        
    @if (count($cdcsLivres) > 0)
        criar="{{route('cdc.cliente.cadastrar', $cliente['id'] )}}"
        titulo_criar="@lang('comum.titulo_criar')"
    @endif

        editar="{{route('cdc.cliente.editar', '')}}"
        titulo_editar="@lang('comum.titulo_editar')"

        token="{{ csrf_token() }}"
    ></tabela-lista-new>

    <div class="d-flex justify-content-center pb-5">
        {{$cliente_cdcs}}
    </div>
@endsection

@section('scripts')
@endsection