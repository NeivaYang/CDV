@extends('_layouts._layout_site')

@section('head')
    <style>
        .progress {
            font-size: 1.125rem !important;
        }
        .progress-bar-altura {
            height: 36px;
        }
    </style>
@endsection

@section('titulo')
    @lang('oportunidade.editar_oportunidade')
@endsection

@section('conteudo')
    <form action="{{route('oportunidade.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$oportunidade['id']}}">
        <input type="hidden" name="id_user" value="{{$oportunidade['id_user']}}">
        <input type="hidden" name="estagio" id="estagio" value="{{$oportunidade['estagio']}}">

        <div class="col-12">
            @php 
                $array_bg = array('bg-primary','bg-primary','bg-success','bg-warning');
                $valor_inicial_pb = ($oportunidade['estagio'] + 1) * 25; 
                $bg_inicial_pb = $array_bg[$oportunidade['estagio']];
            @endphp

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="codigo">@lang('oportunidade.codigo')
                        <input class="form-control" id="codigo" name="codigo" type="text" aria-describedby="" value="{{$oportunidade['codigo']}}" disabled/>
                    </label>
                </div>

                <div class="form-group col-md-9">
                    <label for="funil-de-vendas">@lang('oportunidade.funil_de_vendas')</label>
                    <div class="progress progress-bar-altura">
                        <div class="progress-bar progress-bar-striped progress-bar-animated {{$bg_inicial_pb}}" role="progressbar" style="width: {{$valor_inicial_pb}}%;" aria-valuenow="{{$valor_inicial_pb}}" aria-valuemin="0" aria-valuemax="100">{{$valor_inicial_pb}}%</div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="pretty p-default p-round">
                        <input type="checkbox" value="0" id="check-00" data-texto="@lang('oportunidade.prospecto')" @if ($oportunidade['estagio'] < 3) checked disabled @endif />
                        <div class="state p-primary">
                            <label data-toggle="tooltip" title="{{$dias_estagio[0]}}">@lang('oportunidade.prospecto')</label>
                        </div>
                    </div>
                    <div class="pretty p-default p-round">
                        <input type="checkbox" value="1" id="check-01" data-texto="@lang('oportunidade.reuniao')" @if ($oportunidade['estagio'] >= '1') checked disabled @endif />
                        <div class="state p-primary">
                            <label data-toggle="tooltip" title="{{$dias_estagio[1]}}">@lang('oportunidade.reuniao')</label>
                        </div>
                    </div>
                    <div class="pretty p-default p-round">
                        <input type="checkbox" value="2" id="check-02" data-texto="@lang('oportunidade.negociacao')" @if ($oportunidade['estagio'] == '2') checked disabled @endif />
                        <div class="state p-success">
                            <label data-toggle="tooltip" title="{{$dias_estagio[2]}}">@lang('oportunidade.negociacao')</label>
                        </div>
                    </div>
                    <div class="pretty p-default p-round">
                        <input type="checkbox" value="3" id="check-03" data-texto="@lang('oportunidade.abandono')" />
                        <div class="state p-warning">
                            <label data-toggle="tooltip" title="{{$dias_estagio[3]}}">@lang('oportunidade.abandono')</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_user2">@lang('oportunidade.colaborador')
                        <select name="id_user2" id="id_user2" class='form-control' required disabled>
                        @foreach ($colaboradores as $colaborador)
                            <option value="{{$colaborador->id}}" @if ($colaborador->id == $oportunidade['id_user']) selected @endif>
                                {{$colaborador->nome}} ({{$colaborador->funcao}})
                            </option>
                        @endforeach
                        </select>
                    </label>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('oportunidade.cliente')
                        <select name="id_cliente" id="id_cliente" class='form-control dynamic' data-dependente='id_cdc' >
                        @foreach ($clientes as $cliente)
                            <option value="{{$cliente->id}}" @if ($cliente->id == $oportunidade['id_cliente']) selected @endif>
                                {{$cliente->nome}}
                            </option>
                        @endforeach
                        </select>                    
                    </label>
                </div>    

                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('cliente.cdc')
                        <select name="id_cdc" id="id_cdc" class='form-control'>
                            @foreach ($cdcs as $cdc)
                                <option value="{{$cdc->id_cdc}}" @if ($cdc->id_cliente == $oportunidade['id_cliente'] && $cdc->id_cdc == $oportunidade['id_cdc']) selected @endif>
                                    {{$cdc->cdc}} - {{$cdc->nome}} ({{$cdc->area_total}}/{{$cdc->area_irrigada}} )
                                </option>
                            @endforeach
                        </select>                        
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="moeda">@lang('oportunidade.moeda')<em class="label-required"> *</em>
                        <select name="moeda" id="" class='form-control' required>
                        @foreach ($moedas as $moeda)                        
                            <option value="{{$moeda['valor']}}" @if ($oportunidade['moeda'] == $moeda['valor']) selected @endif>@lang('moeda.'.$moeda['valor'])</option>
                        @endforeach
                        </select>                    
                    </label>
                </div>

                <div class='form-group col-md-3' >
                    <label for="data_inicio">@lang('oportunidade.data_inicio')<em class="label-required"> *</em>
                        <input name='data_inicio' value="{{$oportunidade['data_inicio']}}" class='form-control' type='date' id='data_inicio' required/>                    
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="contrato">@lang('oportunidade.contrato')<em class="label-required"> *</em>
                        <select name="contrato" id="" class='form-control' required>
                            <option value="novo" @if ($oportunidade['contrato'] == 'novo') selected @endif>@lang('oportunidade.novo')</option>
                            <option value="renovacao" @if ($oportunidade['contrato'] == 'renovacao') selected @endif>@lang('oportunidade.renovacao')</option>                    
                        </select>
                    </label>
                </div>
                
                <div class="form-group col-md-3">
                    <label for="contrato_anterior">@lang('negociacao.contrato_anterior')
                        <input class="form-control" id="contrato_anterior" name="contrato_anterior" type="text" aria-describedby="" value="{{$oportunidade['contrato_anterior']}}" />
                    </label>
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="montante">@lang('oportunidade.montante')
                        <input class="form-control maskMoney" id="montante" name="montante" type="text" aria-describedby="" value="{{$oportunidade['montante']}}" />
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="numero_equipamentos">@lang('oportunidade.numero_equipamentos')
                        <input class="form-control" id="numero_equipamentos" name="numero_equipamentos" type="number" maxlength="3" min="0" max="999" aria-describedby="" value="{{$oportunidade['numero_equipamentos']}}" />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-dark" href="{{route('oportunidade.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $('.maskMoney').maskMoney({allowNegative: false, thousands:'.', decimal:','});

        $('.maskMoney').each(function(){ // function to apply mask on load!
            $(this).maskMoney('mask', $(this).val());
        })

        $('.dynamic').change(function () {
            if ($(this).val() != '') {
                var valor = $(this).val();
                var dependente = $(this).data('dependente');
                var _token = $('input[name="_token"').val();
                $.ajax({
                    url: "{{route('oportunidade.preencheSelecao')}}",
                    method: "POST",
                    data: { valor: valor, dependente:dependente, _token: _token},
                    success:function(result) {
                        $('#'+dependente).html(result);
                        if (dependente == 'id_cliente') {
                            $('#id_cdc').html('');
                        }
                    }, 
                    error : function (jqXHR, textStatus, errorThrown){
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    }
                });
            }
        });

        $("input[type='checkbox']").change(function() {
            var valor = parseInt($(this).val());
            var texto = $(this).data('texto');
            var indice = 0;
            var valor_faixa = 0;
            var status = false;
            var bg_progress_bar = ['bg-primary','bg-primary','bg-success','bg-warning'];
            for (var i=0; i<4; i++) {
                if ($('.progress-bar').hasClass(bg_progress_bar[i])) {
                    $('.progress-bar').removeClass(bg_progress_bar[i]);
                }
            }

            if ($(this).is(':checked')) {
                indice = valor + 1;
                status = true;
            } else {
                indice = valor;
            }            
            var valor_faixa = indice * 25;

            $("#check-00").prop("checked", false);
            $("#check-01").prop("checked", false);
            $("#check-02").prop("checked", false);
            $("#check-03").prop("checked", false);

            if (valor <= 3) {
                if ((status) || ((!status) && (valor != 0))) {
                    $("#check-00").prop('checked', true);
                }
            }
            if (valor >= 1) {
                if ((status) || ((!status) && (valor != 1))) {
                    $("#check-01").prop('checked', true);
                }
            }
            if (valor >= 2) {
                if ((status) || ((!status) && (valor != 2))) {
                    $("#check-02").prop('checked', true);
                }
            }
            if ((valor == 3) && (status)) {
                $("#check-03").prop('checked', true);
            }

            $('#estagio-funil-de-vendas').html(texto); 
            $('.progress-bar').addClass(bg_progress_bar[(indice-1)]);
            $('.progress-bar').css('width', valor_faixa+'%').attr('aria-valuenow', valor_faixa).text(valor_faixa.toString()+'%');
            $('#estagio').val(indice-1);
        })


        /*$('.estagio-opt').click(function () {
            var valor = $(this).data('opcao');
            var texto = $(this).html();
            var btn = ['btn-info','btn-light','btn-primary','btn-warning'];

            for (var index = 0; index < 4; index++) {
                var name_id = "estagio"+index;

                for (var x = 0; x < 4; x++) {
                    if ($('#'+name_id).hasClass(btn[x])) {
                        $('#'+name_id).removeClass(btn[x]);
                    }
                }

                if (index > valor) {
                    $('#'+name_id).addClass(btn[1]);
                } else {
                    var btnOn = (valor >= 2) ? btn[valor] : btn[0];
                    $('#'+name_id).addClass(btnOn);
                }
            }

            $('#estagio').val(valor);
        });*/

        $('#estagio-novo').change(function() {
            var valor = this.value;
            var valor_faixa = valor * 25;

            $('#estagio-funil-de-vendas').html(this.text); 

            $('.progress-bar').css('width', valor_faixa+'%').attr('aria-valuenow', valor_faixa);
        });

        /*$('input').on('click', function(){
            var valeur = 0;
            $('input:checked').each(function(){
                if ( $(this).attr('value') > valeur ) {
                    valeur =  $(this).attr('value');
                }
            });
            $('.progress-bar').css('width', valeur+'%').attr('aria-valuenow', valeur);    
        });*/

        /*var delay = 500;
        $(".progress-bar").each(function(i) {
            $(".progress-bar").delay(delay * i).animate({
                width: $(".progress-bar").attr('aria-valuenow') + '%'
            }, delay);

            $(".progress-bar").prop('Counter', 0).animate({
                Counter: $(".progress-bar").text()
            }, 
            {
                duration: delay,
                // easing: 'swing',
                step: function(now) {
                    $(".progress-bar").text(Math.ceil(now) + '%');
                }
            });
        });*/

    });
</script>
@endsection