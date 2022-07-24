@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('prospecto.editar_prospecto')
@endsection

@section('conteudo')
    <form action="{{route('prospecto.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$prospecto['id']}}">

        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="id_user">@lang('prospecto.colaborador')</label>
                    <select name="id_user" id="" class='form-control' >
                        
                        @foreach ($colaboradores as $colaborador)
                            @if ($colaborador->id == $prospecto['id_colaborador'])
                            <option value="{{$colaborador->id}}" selected>{{$colaborador->nome}}</option>
                            @else
                            <option value="{{$colaborador->id}}">{{$colaborador->nome}}</option>
                            @endif
                        @endforeach
        
                    </select>
                    <div class="line"></div>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="id_cliente">@lang('prospecto.cliente')</label>
                    <select name="id_cliente" id="" class='form-control' >
                        
                        @foreach ($clientes as $cliente)
                            @if ($cliente->id == $prospecto['id_cliente'])
                            <option value="{{$cliente->id}}" selected>{{$cliente->nome}}</option>
                            @else
                            <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                            @endif
                        @endforeach
        
                    </select>
                    <div class="line"></div>
                </div>    
            </div>
        </div>

        <div class="col-md-12">
            <div class="row">
                <div class='form-group col-md-4' >
                    <label for="data_prospecto">@lang('prospecto.data_prospecto')</label>
                    <input name='data_prospecto' value="{{ $prospecto['data_prospecto'] }}" class='form-control' required='true' type='date' id='data_prospecto' />
                    <div class="line"></div>
                </div>
        
                <div class="form-group col-md-4">
                    <label for="observacao">@lang('prospecto.observacao')</label>
                <textarea name="observacao" class="form-control" id="observacao" rows="3" cols="100">{{ $prospecto['observacao'] }}</textarea>
                    <div class="line"></div>
                </div>    
    
            </div>
        </div>

        <div class="col-12 text-left">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
            <a class="btn btn-outline-dark" href="{{route('prospecto.gerenciar')}}">@lang('buttons.voltar')</a>
        </div>
    </form>
@endsection

@section('scripts')
@endsection