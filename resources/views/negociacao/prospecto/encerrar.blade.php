@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('prospecto.confirma_encerrar')
@endsection

@section('conteudo')
    <form action="{{route('prospecto.encerra')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id_prospecto" value="{{$prospecto['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_motivo">@lang('prospecto.motivo')</label>
                    <select name="id_motivo" id="" class='form-control' >
                        
                        @foreach ($motivos as $motivo)
                            <option value="{{$motivo->id}}">{{$motivo->descricao}}</option>
                        @endforeach
        
                    </select>
                    <div class="line"></div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="data_encerramento">@lang('prospecto.data_encerramento')</label>
                    <input name='data_encerramento' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_encerramento' />
                    <div class="line"></div>
            </div>    
            </div>
        </div>

        <div class="col-12 text-left">
            <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('prospecto.encerrar')</button>
            <a class="btn btn-outline-dark" href="{{route('prospecto.gerenciar')}}">@lang('buttons.voltar')</a>
        </div>
    </form>
@endsection

@section('scripts')
@endsection