@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
@lang('dashboard.dashboard')
@endsection

@section('conteudo')
<div class="container col-12">
    @if ($dashboard_data)
    <div class="row">
        <div class="col-md-3">
            <div class="card text-primary shadow mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"><i class="fas fa-fw fa-5x fa-hand-holding-usd"></i></div>
                        <div class="col-9 text-right">
                            <h5 class="mb-3">Propostas Feitas</h5>
                            <h2 class="border-bottom border-primary">
                                {{$dashboard_data['total_proposta_produto']+$dashboard_data['total_proposta_servico']}}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-success shadow mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"><i class="fas fa-fw fa-5x fa-file-invoice-dollar"></i></div>
                        <div class="col-9 text-right">
                            <h5 class="mb-3">Contratos Realizados</h5>
                            <h2 class="border-bottom border-success">
                                {{$dashboard_data['total_contrato']}} 
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>    

        <div class="col-md-3">
            <div class="card text-warning shadow mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"><i class="fas fa-fw fa-5x fa-code"></i></div>
                        <div class="col-9 text-right">
                            <h5 class="mb-3">Proposta/Negociação</h5>
                            <h2 class="border-bottom border-warning">
                                {{$dashboard_data['media_proposta_negociacao']}} 
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-primary shadow mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3"><i class="fas fa-fw fa-5x fa-tint"></i></div>
                        <div class="col-9 text-right">
                            <h5 class="mb-3">Total Área Contratada</h5>
                            <h2 class="border-bottom border-primary">
                                {{$dashboard_data['total_area']}}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($oportunidades_data)
    <div class="row">
        <div class="col-md-6">
            <div class="shadow" id="donutchart"></div>
        </div>
    </div>
    @endif
</div>

@endsection
    
@section('scripts')

<script type="text/javascript">
    var valores = <?php echo $oportunidades_data?>;

    google.charts.load("current", {packages:["corechart"]});

    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(valores);
        var options = {
        title: 'Oportundiades',
        pieHole: 0.4,
        colors:['#007BFF','#28A745','#FFA534'],
        };
    
        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
    }
</script>

@endsection