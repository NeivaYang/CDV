@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cliente.cadastrar_cliente')
@endsection

@section('conteudo')
    <form action="{{route('cliente.salvar')}}" class='row' id="form_submit" method="post">
        {{csrf_field()}}

        <div class="col-12">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="nome" name="nome" aria-describedby="" required/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.nome'), 'id' => ''])@endcomponent
                </div>

                <div class="form-group col-md-6">
                    <input type="email" class="form-control" id="email" name="email" aria-describedby=""/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.email'), 'id' => ''])@endcomponent
                </div>    
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="telefone" name="telefone" aria-describedby=""/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.telefone'), 'id' => ''])@endcomponent
                </div>
    
                <div class="form-group col-md-3">
                    <label for="id_pais">@lang('cliente.pais')</label>
                    <select name="id_pais" id="id_pais" class='form-control' required >
                        <option value="">@lang('comum.seleciona_item')</option>
                        
                        @foreach ($paises as $pais)
                        <option value="{{$pais->id}}">{{$pais->nome}}</option>
                        @endforeach
    
                    </select>
                    <div class="line"></div>
                </div>    

                <div class="form-group col-md-3">
                    <label for="tipo_pessoa">@lang('cliente.tipo_pessoa')</label>
                    <select name="tipo_pessoa" id="tipo_pessoa" class='form-control' required>
                        <option value="">@lang('comum.seleciona_item')</option>
                        <option value="fisica">@lang('cliente.pessoa_fisica')</option>
                        <option value="juridica">@lang('cliente.pessoa_juridica')</option>
                    </select>
                    <div class="line"></div>
                </div>

                <div class="form-group col-md-3">
                    <input type="text" class="form-control" id="documento" name="documento" aria-describedby=""/>
                    @component('_layouts._components._inputLabel', ['texto'=>__('cliente.documento'), 'id' => ''])@endcomponent
                </div>
            </div>

            <div class="form-row">
                <div class="col-6 tex-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('cliente.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>    
        </div>
    </form>
@endsection

@section('scripts')
@endsection