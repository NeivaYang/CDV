@extends('_layouts._layout_site')
@section('head')@endsection
@section('titulo')@lang('comum.titulo_editar') @lang('comum.itensVenda')@endsection

@section('conteudo')
        {{csrf_field()}}
    <form action="{{ route('itensVenda.editar') }}" class='row' id="form_submit" method="post">
        {{ csrf_field() }}
        <input type="hidden" value="PUT" name="_method">
        <input type="hidden" name="id" value="{{$getInfo['id']}}">

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="nome">@lang('produto.nome')<em class="label-required"> *</em>
                        <input type="text" class="form-control text-capitalize" id="nome" name="nome" maxlength="50" aria-describedby="" value="{{ $getInfo['nome'] }}" />
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-2">
                    <label for="tipo">@lang("comum.tipo_item")<em class="label-required"> *</em>
                        <select name="tipo" id="tipo" class='form-control' >
                            <option value=" ">@lang('comum.seleciona_item')</option>
                            <option value="produto" @if($getInfo['tipo'] == 'produto') selected @endif>@lang('comum.produto')</option>
                            <option value="servico" @if($getInfo['tipo'] == 'servico') selected @endif>@lang('comum.servico')</option>
                        </select>
                    </label>
                </div>

                <div class="form-group col-md-2">
                    <label for="unidade">@lang("comum.unidade")<em class="label-required"> *</em>
                        <input type="unidade" class="form-control" id="unidade" name="unidade" maxlength="190" aria-describedby="" value="{{ $getInfo['unidade'] }}"/>
                    </label>
                </div>
            </div>

            <div class="form-row">
                <div class="col-12 mb-2">
                    <em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em>
                </div>
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('itensVenda.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@include('_layouts._includes._validators_jquery')
    <script>
        $(document).ready(function(){
            //
        });
    </script>
@endsection
