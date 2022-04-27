@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('negociacao.encerrar_negociacao')
@endsection

@section('conteudo')
    <form action="{{route('negociacao.encerra')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id_negociacao" value="{{$negociacao['id']}}">

        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="id_motivo">@lang('negociacao.motivo')</label>
                    <select name="id_motivo" id="" class='form-control' required>
                        <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($motivos as $motivo)
                        <option value="{{$motivo->id}}" >{{$motivo->descricao}}</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_concorrente">@lang('negociacao.cliente')</label>
                    <select name="id_concorrente" id="" class='form-control' required >
                        <option value="">@lang('comum.seleciona_item')</option>
                    @foreach ($concorrentes as $concorrente)
                        <option value="{{$concorrente->id}}">{{$concorrente->nome}}</option>
                    @endforeach
                    </select>
                    <div class="line"></div>
                </div>    
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class='form-group col-md-4' >
                    <label for="data_ocorrido">@lang('negociacao.data_ocorrido')</label>
                    <input name='data_ocorrido' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_ocorrido' required />
                    <div class="line"></div>
                </div>        
            </div>
        </div>

        <div class="col-12 text-left">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.sim')</button>
            <a class="btn btn-outline-dark" href="{{route('negociacao.gerenciar')}}">@lang('buttons.nao')</a>
        </div>
    </form>
@endsection

@section('scripts')
@endsection