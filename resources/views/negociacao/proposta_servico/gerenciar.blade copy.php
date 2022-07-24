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
        <div class="col-3 align-self-end text-right">
            <a class="btn btn-primary btn-lg" href="{{route('proposta.servico.cadastrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.nova_proposta')">
                <i class="fas fa-fw fa-lg fa-plus"></i> @lang('proposta.btn_proposta')
            </a>
            <a class="btn btn-warning btn-lg" href="{{route('oportunidade.encerrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.cancela_oportunidade')">
                <i class="fas fa-fw fa-lg fa-ban"></i> @lang('proposta.btn_oportunidade')
            </a>
        </div>        
    </div>        
    
    <nav>
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
                                        @lang('oportunidade.servico') <br>
                                        <small>{{$proposta['servicos']}}</small>
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
                                        @lang('proposta.sistema_irrigacao') <br>
                                        <small>{{$proposta['sistema_irrigacao']}}</small>
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
                                        @lang('proposta.valor_area') <br>
                                        <small>{{$proposta['valor_area']}}</small>
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
    
@endsection

@section('scripts')
@endsection