@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('colaborador.cadastrar_colaborador')
@endsection

@section('conteudo')
    <form action="{{route('colaborador.salvar')}}" id='form_submit' method="post">
        {{csrf_field()}}

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="nome">@lang('colaborador.nome')<em class="label-required"> *</em>
                        <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" maxlength="20" required>
                    </label>
                </div>
    
                <div class="form-group col-md-4">
                    <label for="codigo_idioma">@lang('colaborador.idioma')<em class="label-required"> *</em>
                        <select class="form-control" name="codigo_idioma" id="codigo_idioma" required>
                            @foreach($idiomas as $idioma)
                                <option value="{{$idioma['chave']}}">{{$idioma["valor"]}}</option>
                            @endforeach
                        </select> 
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="id_funcao">@lang('colaborador.funcao')<em class="label-required"> *</em>
                        <select name="id_funcao" id="" class='form-control' >
                            <option value="">@lang('comum.seleciona_item')</option>                            
                            @foreach ($funcoes as $funcao)
                                <option value="{{$funcao->id}}">{{$funcao->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
    
                <div class="form-group col-md-4">
                    <label for="id_cdc">@lang('colaborador.cdc')<em class="label-required"> *</em>
                        <select name="id_cdc" id="" class='form-control' >
                            <option value="">@lang('comum.seleciona_item')</option>
                            @foreach ($cdcs as $cdc)
                                <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="celular">@lang('colaborador.celular')<em class="label-required"> *</em>
                        <input class="form-control" id="celular" name="celular" type="text" aria-describedby="" maxlength="15" required>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="email">@lang('colaborador.email')<em class="label-required"> *</em>
                        <input class="form-control" id="email" name="email" type="email" aria-describedby="" maxlength="190" required>
                    </label>
                </div>
                
                <div class="form-group  col-md-4">
                    <label for="password">@lang('colaborador.senha')<em class="label-required"> *</em>
                        <input class="form-control" id="password" minlength="6" name="password" type="password" maxlength="25" required>
                    </label>
                </div>

                <div class="form-group col-md-4">
                    <label for="confirmpassword">@lang('colaborador.confirmar_senha')<em class="label-required"> *</em>
                        <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" maxlength="25" required>
                    </label>
                </div>        
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('colaborador.listar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>            
        </div>
    </form>
@endsection

@section('scripts')
@endsection