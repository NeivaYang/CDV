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
                    <input type="text" class="form-control" id="nome" name="nome" value="{{$cliente['nome']}}" required/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.nome'), 'id' => ''])@endcomponent
                </div>

                <div class="form-group col-md-6">
                    <input type="email" class="form-control" id="email" name="email" value="{{$cliente['email']}}"/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.email'), 'id' => ''])@endcomponent
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="telefone" name="telefone" value="{{$cliente['telefone']}}"/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.telefone'), 'id' => ''])@endcomponent
                </div>
    
                <div class="form-group col-md-3">
                    <label for="id_pais">@lang('cliente.pais')</label>
                    <select name="id_pais" id="id_pais" class='form-control' required>
                        @foreach ($paises as $pais)
                        <option value="{{$pais->id}}" @if ($pais->id == $cliente['id_pais']) selected @endif>{{$pais->nome}}</option>
                        @endforeach
                    </select>
                    <div class="line"></div>
                </div>    

                <div class="form-group col-md-3">
                    <label for="tipo_pessoa">@lang('cliente.tipo_pessoa')</label>
                    <select name="tipo_pessoa" id="tipo_pessoa" class='form-control' required>
                        <option value="fisica" @if ($cliente['tipo_pessoa'] == 'fisica') selected @endif>@lang('cliente.pessoa_fisica')</option>
                        <option value="juridica" @if ($cliente['tipo_pessoa'] == 'juridica') selected @endif>@lang('cliente.pessoa_juridica')</option>
                    </select>
                    <div class="line"></div>
                </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="documento" name="documento" value="{{$cliente['documento']}}"/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.documento'), 'id' => ''])@endcomponent
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.atualizar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('cliente.gerenciar')}}">@lang('buttons.voltar')</a>    
                </div>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
@endsection