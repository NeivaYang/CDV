@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.editar_cliente')
@endsection

@section('conteudo')
    <form action="{{route('cliente.atualizar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$cliente['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="nome">@lang('cliente.nome')<em class="label-required"> *</em>
                        <input type="text" class="form-control" id="nome" name="nome" maxlength="50" value="{{$cliente['nome']}}" required/>
                    </label>
                </div>

                <div class="form-group col-md-6">
                    <label for="email">@lang('cliente.email')
                        <input type="email" class="form-control" id="email" name="email" maxlength="190" value="{{$cliente['email']}}"/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="tipo_pessoa">@lang('cliente.tipo_pessoa')<em class="label-required"> *</em>
                        <select name="tipo_pessoa" id="tipo_pessoa" class='form-control' required>
                            <option value="fisica" @if ($cliente['tipo_pessoa'] == 'fisica') selected @endif>@lang('cliente.pessoa_fisica')</option>
                            <option value="juridica" @if ($cliente['tipo_pessoa'] == 'juridica') selected @endif>@lang('cliente.pessoa_juridica')</option>
                        </select>                        
                    </label>
                </div>
    
                <div class="form-group col-md-3">
                    <label for="corporacao">@lang('cliente.corporacao')<em class="label-required"> *</em>
                        <select name="corporacao" id="corporacao" class='form-control' required >
                            <option value="0" @if ($cliente['corporacao'] == '0') selected @endif>@lang('comum.nao')</option>
                            <option value="1" @if ($cliente['corporacao'] == '1') selected @endif>@lang('comum.sim')</option>
                        </select>                    
                    </label>
                </div>    

                <div class="form-group col-md-3">
                    <label for="documento">@lang('cliente.documento')
                        <input type="text" class="form-control" id="documento" name="documento" maxlength="20" value="{{$cliente['documento']}}"/>
                    </label>
                </div>
            </div>

            <div class='form-row'>
                <div class="form-group col-md-3">
                    <label for="id_pais">@lang('cliente.pais')<em class="label-required"> *</em>
                        <select name="id_pais" id="id_pais" class='form-control' required>
                            @foreach ($paises as $pais)
                            <option value="{{$pais->id}}" @if ($pais->id == $cliente['id_pais']) selected @endif>{{$pais->nome}}</option>
                            @endforeach
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-3">
                    <label for="telefone">@lang('cliente.telefone')<em class="label-required"> *</em>
                        <input type="text" class="form-control" id="telefone" name="telefone" maxlength="15" value="{{$cliente['telefone']}}" required/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('cliente.gerenciar')}}">@lang('buttons.voltar')</a>    
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
<script>
    $(function(){
        $('#tipo_pessoa').change(function(){    if($(this).val() == 'fisica')   $('#corporacao').val(0);})
        $('#corporacao').change(function(){    if($(this).val() == 1)   $('#tipo_pessoa').val('juridica');})
    })
</script>
@endsection