@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('contrato.visualizar_contrato')
@endsection

@section('conteudo')
    <div class="row mb-3">
        <div class="col-10">
            <div class="card border-light">
                <div class="card-body text-info">
                    <div class="row border-bottom">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.numero') <br>
                                <small class="text-secondary">{{$contrato_venda['numero']}}</small>
                            </h4>
                        </div>    
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.data_inicio') <br>
                                <small class="text-secondary">{{$contrato_venda['data_inicio']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.data_termino') <br>
                                <small class="text-secondary">{{$contrato_venda['data_termino']}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.observacao') <br>
                                <small class="text-secondary">{{$contrato_venda['observacao']}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.cliente') <br>
                                <small class="text-secondary">{{$oportunidade['cliente']}}</small>
                            </h4>
                        </div>    
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.contrato') <br>
                                <small class="text-secondary">@lang('oportunidade.'.$oportunidade['contrato'])</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('oportunidade.moeda') <br>
                                <small class="text-secondary">@lang('moeda.'.$oportunidade['moeda'])</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.assinatura_empresa') <br>
                                <small class="text-secondary">{{$contrato_venda['assinante_empresa']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('contrato.assinatura_cliente') <br>
                                <small class="text-secondary">{{$contrato_venda['assinante_cliente']}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.servico') <br>
                                <small class="text-secondary">{{$servicos}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.sistema_irrigacao') <br>
                                <small class="text-secondary">{{$proposta['sistema_irrigacao']}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.quantidade_equipamento') <br>
                                <small class="text-secondary">{{$proposta['quantidade_equipamento']}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row border-bottom pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.area_abrangida') <br>
                                <small class="text-secondary">{{$proposta['area_abrangida']}} ha</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.valor_area') <br>
                                <small class="text-secondary">R$ {{number_format($proposta['valor_area'],2,",",".")}}</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.valor_total') <br>
                                <small class="text-secondary">R$ {{number_format($proposta['valor_total'],2,",",".")}}</small>
                            </h4>
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.desconto_concedido') <br>
                                <small class="text-secondary">{{number_format($proposta['desconto_concedido'],2,",","")}} %</small>
                            </h4>
                        </div>
                        <div class="col-md-4">
                            <h4>
                                @lang('proposta.valor_final') <br>
                                <small class="text-secondary">R$ {{number_format($proposta['valor_final'],2,",",".")}}</small>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    
    <div class="col-12 text-left">
        <a class="btn btn-outline-dark" href="{{route('contrato.gerenciar')}}">@lang('buttons.voltar')</a>
    </div>    
@endsection

@section('scripts')
@endsection