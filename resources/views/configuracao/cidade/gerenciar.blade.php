@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('cidade.titulo')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("cidade.id")','@lang("cidade.ibge")','@lang("cidade.nome")','@lang("cidade.estado")','@lang("cidade.pais")','@lang("cidade.cdc")']"
        v-bind:itens="{{json_encode($cidades)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('cidade.cadastra')}}"
        modal_criar="sim"
        titulo_criar="@lang('comum.titulo_criar')"
        editar="{{route('cidade.editar', '')}}/"
        modal_editar="sim"
        titulo_editar="@lang('comum.titulo_editar')"
        deletar="{{route('cidade.remover', '')}}/"
        modal_deletar="sim"
        titulo_deletar="@lang('comum.titulo_deletar')"
        token="{{ csrf_token() }}"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$cidades}}
    </div>
    
    <modal nome="adicionar" titulo="@lang('cidade.cadastro')" css=''>
        <formulario id="formAdicionar" css="row" action="{{route('cidade.cadastra')}}" method="post" enctype="" token="{{ csrf_token() }}">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ibge">@lang('cidade.ibge')
                            <input class="form-control" id="ibge" name="ibge" type="text" aria-describedby="" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="nome">@lang('cidade.nome')
                            <input class="form-control" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="estado">@lang('cidade.estado')
                            <input class="form-control" id="estado" name="estado" type="text" aria-describedby="" >
                        </label>
                    </div>        
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="id_pais">@lang('cidade.pais')
                            <select name="id_pais" id="" class='form-control'>
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nome}}</option>
                                @endforeach
                            </select>                            
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="id_cdc">@lang('cidade.cdc')
                            <select name="id_cdc" id="" class='form-control'>
                                @foreach ($cdcs as $cdc)
                                    <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>        
                </div>
            </div> 
        </formulario>
        <span slot="botoes">
            <button form='formAdicionar' class="btn btn-lg btn-info btn-block text-center text-light" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
        </span>    
    </modal>
    
    <modal nome="editar" titulo="@lang('cidade.edicao')" css=''>
        <formulario id="formEditar" v-bind:action="'{{route('cidade.edita')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">
            <input type="text" name='id' hidden v-model="$store.state.item.id">
            <div class="col-12">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="ibge">@lang('cidade.ibge')
                            <input class="form-control" v-model="$store.state.item.ibge" id="ibge" name="ibge" type="text" aria-describedby="" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="nome">@lang('cidade.nome')
                            <input class="form-control" v-model="$store.state.item.nome" id="nome" name="nome" type="text" aria-describedby="" required>
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="estado">@lang('cidade.estado')
                            <input class="form-control" v-model="$store.state.item.estado" id="estado" name="estado" type="text" aria-describedby="">
                        </label>
                    </div>        
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="id_pais">@lang('cidade.pais')
                            <select readonly disabled name="id_pais" id="" aria-readonly="true"  v-model="$store.state.item.id_pais"  class='form-control'>
                                @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}">{{$pais->nome}}</option>
                                @endforeach
                            </select>    
                        </label>
                    </div>
        
                    <div class="form-group col-md-4">
                        <label for="id_cdc">@lang('cidade.cdc')
                            <select readonly disabled name="id_cdc" id="" aria-readonly="true"  v-model="$store.state.item.id_cdc"  class='form-control'> 
                                @foreach ($cdcs as $cdc)
                                    <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                                @endforeach
                            </select>    
                        </label>
                    </div>        
                </div>
            </div>
        </formulario>
        <span slot="botoes">
          <button form="formEditar" class="btn btn-info">@lang('buttons.atualizar')</button>
        </span>
    </modal>
@endsection

@section('scripts')
    @include('_layouts._includes._validators_jquery')
@endsection