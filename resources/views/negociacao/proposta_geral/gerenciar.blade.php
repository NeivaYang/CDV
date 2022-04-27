<link href="{{asset('css/tables.css')}}" rel="stylesheet" type="text/css">

@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('proposta.gerenciar_propostas')
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
            <a class="btn btn-primary btn-lg" href="{{route('proposta.geral.cadastrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.nova_proposta')">
                <i class="fas fa-fw fa-lg fa-plus"></i> @lang('proposta.btn_proposta')
            </a>
            <a class="btn btn-warning btn-lg" href="{{route('oportunidade.encerrar', $id_oportunidade)}}" role="button" data-toggle="tooltip" title="@lang('proposta.cancela_oportunidade')">
                <i class="fas fa-fw fa-lg fa-ban"></i> @lang('proposta.btn_oportunidade')
            </a>
        </div>        
    </div>

    @if (count($propostas))
    <div class="row">
        <div class="col-md-12">
        @php
        $itens = 0;
        $ativo = ' active';
        $selecao = 'true';
        @endphp
        
        @foreach ($propostas as $key => $proposta2)
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
                    <div class="col-12">
                        <div class="card text-white border-light bg-card-proposta mt-4 ml-4 mb-4 mr-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-start">
                                        <h4 style="color:white;">@lang('proposta.data_proposta'):<br/>
                                            <small>{{$proposta['data_proposta']}}</small>
                                        </h4>
                                    </div>
                                    
                                    <div class="col-6 text-right">
                                        <a class="btn btn-light m-1" href="{{route('proposta.geral.duplicar', $proposta['id_proposta_venda'])}}" role="button">
                                            <i class="fas fa-fw fa-lg fa-clone"></i> @lang('proposta.duplicar_proposta')
                                        </a>
                                        <a class="btn btn-light m-1" href="{{route('proposta.geral.gerarcontrato', $proposta['id_proposta_venda'])}}" role="button">
                                            <i class="fas fa-fw fa-lg fa-file-signature"></i> @lang('proposta.gerar_contrato')
                                        </a>               
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table" id="tabela_itens_gerenciar">
                                            <thead style="background-color: transparent !important;">
                                                <tr style="color:white;">
                                                <th scope="col" style="width: 25%">@lang('proposta.item_venda')</th>
                                                <th scope="col" style="width: 15%">@lang('proposta.sistema_irrigacao')</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.unidade')</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.quantidade')</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.valor_unitario') R$</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.valor_total') R$</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.desconto_concedido') %</th>
                                                <th scope="col" style="width: 10%">@lang('proposta.valor_final') R$</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($proposta['venda_itens'] as $proposta_itens)
                                                <tr>
                                                    <td>
                                                    @foreach($itens_venda as $item)
                                                        @php if($item->id == $proposta_itens['id_item_venda']){ echo $item->nome; } @endphp
                                                    @endforeach
                                                    </td>  
                                                    <td>@lang('sistemaIrrigacao.'.$proposta_itens['sistema_irrigacao'])</td>
                                                    <td>{{$proposta_itens['unidade']}}</td>
                                                    <td>{{$proposta_itens['quantidade']}}</td>
                                                    <td>{{number_format($proposta_itens['valor_unitario'], 2, ',', '.')}}</td>
                                                    <td>{{number_format($proposta_itens['valor_total'], 2, ',', '.')}}</td>
                                                    <td>{{number_format($proposta_itens['desconto_concedido'], 2, ',', '.')}}</td>
                                                    <td>{{number_format($proposta_itens['valor_final'], 2, ',', '.')}}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
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
<script>
</script>
@endsection