@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerenciar_proposta_produto')
@endsection

@section('conteudo')
    <div class="row mb-3">
        <div class="col-9">
            <div class="card border-light">
                <div class="card-header"><h4>@lang('proposta.informacao_oportunidade')</h4></div>
                <div class="card-body">
                    <div class="row border-bottom">
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.codigo') <br>
                                <small class="text-muted">{{$oportunidade['codigo']}}</small>
                            </h4>
                        </div>    
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.colaborador') <br>
                                <small class="text-muted">{{$oportunidade['colaborador']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.cliente') <br>
                                <small class="text-muted">{{$oportunidade['cliente']}}</small>
                            </h4>
                        </div>    
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.data_inicio') <br>
                                <small class="text-muted">{{$oportunidade['data_oportunidade']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.contrato') <br>
                                <small class="text-muted">{{$oportunidade['contrato']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.moeda') <br>
                                <small class="text-muted">@lang('moeda.'.$oportunidade['moeda'])</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-3 align-self-start text-right">
            <a class="btn btn-primary btn-lg" href="{{route('proposta.produto.cadastrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.nova_proposta')">
                <i class="fas fa-fw fa-lg fa-plus"></i> @lang('proposta.nova_proposta')
            </a>
            <a class="btn btn-warning btn-lg" href="{{route('oportunidade.encerrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.cancela_oportunidade')">
                <i class="fas fa-fw fa-lg fa-ban"></i> @lang('proposta.cancela_oportunidade')
            </a>
        </div>        
    </div>
        
    @if (count($propostas))
        @php
        $itens = 0;
        @endphp
        
        @foreach ($propostas as $proposta)
            @if (($itens == 0) || (fmod($itens,3) == 0))
            <div class="row">
            @endif    
                <div class="col-4">
                    <div class="card text-white border-light bg-card-proposta">
                        <div class="card-body">
                            <div class="row border-bottom">
                                <div class="col-md-6">
                                    <h4>
                                        @lang('oportunidade.produto') <br>
                                        <small>{{$proposta['produto']}}</small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.data_proposta') <br>
                                        <small>{{$proposta['data_proposta']}}</small>
                                    </h4>
                                </div>    
                            </div>
                            <div class="row border-bottom pt-3">
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.area_manejada') <br>
                                        <small>{{$proposta['area_manejada']}}</small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.quantidade_equipamento') <br>
                                        <small>{{$proposta['quantidade_equipamento']}}</small>
                                    </h4>
                                </div>    
                            </div>
                            <div class="row border-bottom pt-3">
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.area_abrangida') <br>
                                        <small>{{$proposta['area_abrangida']}}</small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.quantidade_lance') <br>
                                        <small>{{$proposta['quantidade_lance']}}</small>
                                    </h4>
                                </div>    
                            </div>
                            <div class="row border-bottom pt-3">
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.valor_total') <br>
                                        <small>{{$proposta['valor_total']}}</small>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.desconto_concedido') <br>
                                        <small>{{$proposta['desconto_concedido']}}</small>
                                    </h4>
                                </div>    
                            </div>
                            <div class="row border-bottom pt-3">
                                <div class="col-md-6">
                                    <h4>
                                        @lang('proposta.valor_final') <br>
                                        <small>{{$proposta['valor_final']}}</small>
                                    </h4>
                                </div>
                            </div>
                            <div class="row pt-3">
                                <div class="col-12">
                                    <a class="btn btn-light m-1" href="{{route('proposta.produto.duplicar', $proposta['id'])}}" role="button">
                                        <i class="fas fa-fw fa-lg fa-clone"></i> @lang('proposta.duplicar_proposta')
                                    </a>
                                    <a class="btn btn-light m-1" href="{{route('proposta.produto.gerarcontrato', $proposta['id'])}}" role="button">
                                        <i class="fas fa-fw fa-lg fa-file-signature"></i> @lang('proposta.gerar_contrato')
                                    </a>                                
                                </div>        
                            </div>
                        </div>
                    </div>
                </div>

            @php
            $itens += 1;
            @endphp

            @if ((fmod($itens,3) == 0) || (count($propostas) == $itens))
            </div>
            @endif    

        @endforeach
    @else
    <div class="row">
        <div class="col-8">
            <div class="alert alert-warning" role="alert">@lang('proposta.nao_existe')</div>
        </div>    
    </div>
    @endif
        
    </div> 
    
@endsection

@section('scripts')
@endsection