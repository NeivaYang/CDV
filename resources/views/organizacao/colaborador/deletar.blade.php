@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('colaborador.excluir_colaborador')
@endsection

@section('conteudo')
    <form action="{{route('colaborador.exclui')}}" id='form_submit' method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name='id' value="{{$colaborador['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="enome">@lang('colaborador.nome')
                        <input class="form-control" id="enome" name="enome" type="text" aria-describedby="" value="{{$colaborador['nome']}}" disabled>
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="codigo_idioma">@lang('colaborador.idioma')
                        <select class="form-control" name="codigo_idioma" id="codigo_idioma" disabled>
                            @foreach($idiomas as $idioma)
                                <option value="{{$idioma['chave']}}" @if ($idioma['chave'] == $colaborador['codigo_idioma']) selected @endif>{{$idioma["valor"]}}</option>
                            @endforeach
                        </select> 
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_funcao">@lang('colaborador.funcao')
                        <select name="id_funcao" id="" class='form-control' disabled>
                            <option value="">@lang('comum.seleciona_item')</option>                            
                            @foreach ($funcoes as $funcao)
                                <option value="{{$funcao->id}}" @if ($funcao->id == $colaborador['id_funcao']) selected @endif>{{$funcao->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
    
                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('colaborador.cdc')
                        <select name="id_cdc" id="" class='form-control' disabled>
                            <option value="">@lang('comum.seleciona_item')</option>
                            @foreach ($cdcs as $cdc)
                                <option value="{{$cdc->id}}" @if ($cdc->id == $colaborador['id_cdc']) selected @endif >{{$cdc->cdc}} - {{$cdc->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="celular">@lang('colaborador.celular')
                        <input class="form-control" id="celular" name="celular" type="text" aria-describedby="" value="{{$colaborador['celular']}}" disabled>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="email">@lang('colaborador.email')
                        <input class="form-control" id="email" name="email" type="email" aria-describedby="" value="{{$colaborador['email']}}" disabled>
                    </label>
                </div>                
            </div>

            <div class="form-row">
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.deletar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('colaborador.listar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>            
        </div>
    </form>
@endsection

@section('scripts')
@endsection