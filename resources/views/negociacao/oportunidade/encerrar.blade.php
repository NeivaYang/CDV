@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('oportunidade.encerrar_oportunidade')
@endsection

@section('conteudo')
    <form action="{{route('oportunidade.encerra')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id_oportunidade" value="{{$oportunidade['id']}}">
        <input type="hidden" name="tipo" value="{{$tipo_encerramento}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_motivo">@lang('oportunidade.motivo')<em class="label-required"> *</em>
                        <select name="id_motivo" id="" class='form-control' required>
                            <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($motivos as $motivo)
                            <option value="{{$motivo->id}}" >{{$motivo->descricao}}</option>
                        @endforeach
                        </select>                        
                    </label>
                </div>
                
                <div class="form-group col-md-4">
                    <label for="id_concorrente">@lang('oportunidade.concorrente')
                        <select name="id_concorrente" id="" class='form-control' >
                            <option value="">@lang('comum.seleciona_item')</option>
                        @foreach ($concorrentes as $concorrente)
                            <option value="{{$concorrente->id}}">{{$concorrente->nome}}</option>
                        @endforeach
                        </select>                        
                    </label>
                </div>                        
            </div>

            <div class="form-row">
                <div class='form-group col-md-4 align-self-start' >
                    <label for="data_ocorrido">@lang('oportunidade.data_ocorrido')<em class="label-required"> *</em>
                        <input name='data_ocorrido' value="{{date('Y-m-d')}}" class='form-control' type='date' id='data_ocorrido' required />                    
                    </label>
                </div>        
                <div class="form-group col-md-6">
                    <label for="observacao">@lang('oportunidade.observacao')
                        <textarea name="observacao" class="form-control" id="observacao" rows="3" cols="100"></textarea>                    
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-12 text-left">
                    <button class="btn btn-outline-info" style="margin: 0 auto" type="submit">@lang('buttons.sim')</button>
                    <a class="btn btn-outline-dark" href="{{route('oportunidade.gerenciar')}}">@lang('buttons.nao')</a>
                </div>    
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection