@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerenciar_proposta_servico')
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
                                <small class="text-muted">@lang('oportunidade.'.$oportunidade['contrato'])</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
        <div class="col-3 align-self-start text-right">
            <a class="btn btn-primary btn-lg" href="{{route('proposta.servico.cadastrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.nova_proposta')">
                <i class="fas fa-fw fa-lg fa-plus"></i> @lang('proposta.btn_proposta')
            </a>
            <a class="btn btn-warning btn-lg" href="{{route('oportunidade.encerrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.cancela_oportunidade')">
                <i class="fas fa-fw fa-lg fa-ban"></i> @lang('proposta.btn_oportunidade')
            </a>
        </div>        
    </div>        
    
    <!--<nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
    </div>-->

    @if (count($propostas))
    <div class="row">
        <div class="col-9">
        @php
        $itens = 0;
        $ativo = ' active';
        $selecao = 'true';
        @endphp
        
        @foreach ($propostas as $proposta2)
            @if ($itens == 0)
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @else
            @php
                $ativo = '';
                $selecao = 'false';
            @endphp
            @endif    

            @php
                $itens += 1;
            @endphp

                    <a class="nav-item nav-link {{$ativo}}" id="nav-proposta-{{str_pad($itens,2,"0",STR_PAD_LEFT)}}-tab" data-toggle="tab" href="#nav-proposta-{{str_pad($itens,2,"0",STR_PAD_LEFT)}}" role="tab" aria-controls="nav-proposta-{{str_pad($itens,2,"0",STR_PAD_LEFT)}}" aria-selected="{{$selecao}}">
                        <h5>@lang('proposta.data_proposta_2') {{str_pad($itens,2,"0",STR_PAD_LEFT)}}</h5>
                    </a>

            @if (count($propostas) == $itens)
                </div>
            </nav>
            @endif    
        @endforeach

        @php
        $itens = 0;
        $ativo = ' show active';
        @endphp

        @foreach ($propostas as $proposta)
            @if ($itens == 0)
            <div class="tab-content bg-white border-light border-top-0 mb-5" id="nav-tabContent">
            @else
            @php
                $ativo = '';
            @endphp
            @endif    

            @php
                $itens += 1;
            @endphp
            
            <div class="tab-pane fade {{$ativo}}" id="nav-proposta-{{str_pad($itens,2,"0",STR_PAD_LEFT)}}" role="tabpanel" aria-labelledby="nav-proposta-{{str_pad($itens,2,"0",STR_PAD_LEFT)}}-tab">
                <div class="row">
                    <div class="col-8">
                        <div class="card text-white border-light bg-card-proposta mt-4 ml-4 mb-4">
                            <div class="card-body">
                                <div class="row border-bottom">
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.data_proposta') <br>
                                            <small>{{$proposta['data_proposta']}}</small>
                                        </h4>
                                    </div>    
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('oportunidade.servico') <br>
                                            <small>{{$proposta['servicos']}}</small>
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.sistema_irrigacao') <br>
                                            <small>{{$proposta['sistema_irrigacao']}}</small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="row border-bottom pt-3">
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.quantidade_equipamento') <br>
                                            <small>{{$proposta['quantidade_equipamento']}}</small>
                                        </h4>
                                    </div>    
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.area_abrangida') <br>
                                            <small>{{$proposta['area_abrangida']}} ha</small>
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.valor_area') <br>
                                            <small>R$ {{number_format($proposta['valor_area'], 2, ',', '.')}}</small>
                                        </h4>
                                    </div>    
                                </div>
                                <div class="row border-bottom pt-3">
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.valor_total') <br>
                                            <small>R$ {{number_format($proposta['valor_total'], 2, ',', '.')}}</small>
                                        </h4>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.desconto_concedido') <br>
                                            <small>{{number_format($proposta['desconto_concedido'],2,',','.')}} %</small>
                                        </h4>
                                    </div>    
                                    <div class="col-md-4">
                                        <h4>
                                            @lang('proposta.valor_final') <br>
                                            <small>R$ {{number_format($proposta['valor_final'], 2, ',', '.')}}</small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="row border-bottom pt-3">
                                    <div class="col-md-12">
                                        <h4>
                                            @lang('proposta.descricao') <br>
                                            <small>{{$proposta['descricao']}}</small>
                                        </h4>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-12">
                                        <a class="btn btn-light m-1" href="{{route('proposta.servico.duplicar', $proposta['id'])}}" role="button">
                                            <i class="fas fa-fw fa-lg fa-clone"></i> @lang('proposta.duplicar_proposta')
                                        </a>
                                        <a class="btn btn-light m-1" href="{{route('proposta.servico.gerarcontrato', $proposta['id'])}}" role="button">
                                            <i class="fas fa-fw fa-lg fa-file-signature"></i> @lang('proposta.gerar_contrato')
                                        </a>                                
                                    </div>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>

            @if (count($propostas) == $itens)
            </div>
            @endif    
        @endforeach
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-8">
            <div class="alert alert-warning" role="alert">@lang('proposta.nao_existe')</div>
        </div>    
    </div>
    @endif
    
@endsection

@section('scripts')
@endsection