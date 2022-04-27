@extends('_layouts._layout_site')

@section('head')
@endsection

@section('titulo')
    @lang('prospecto.gerenciar_prospecto')
@endsection

@section('conteudo')
    <tabela-lista-new
        v-bind:titulos="['@lang("prospecto.id")','@lang("prospecto.colaborador")','@lang("prospecto.cliente")','@lang("prospecto.data_prospecto")','@lang("prospecto.situacao")']"
        v-bind:itens="{{json_encode($prospectos)}}"
        titulo_acoes="@lang('comum.acoes')"
        pesquisa="sim"
        ordem="desc" 
        ordemcol="1"
        criar="{{route('prospecto.cadastrar')}}"  
        titulo_criar="@lang('comum.titulo_criar')"        
        editar="{{route('prospecto.editar', '')}}"
        titulo_editar="@lang('comum.titulo_editar')"
        outro1="{{route('prospecto.encerrar', '')}}" 
        titulo_outro1="@lang('comum.encerrar')"
        icone_outro1="fas fa-fw fa-lg fa-ban"
        outro2="{{route('negociacao.prospecto_negociar', '')}}" 
        icone_outro2="fas fa-fw fa-lg fa-shopping-cart"
        titulo_outro2="@lang('comum.negociar')"
    ></tabela-lista-new>
    <div align="center" class='row'>
        {{$prospectos}}
    </div> 
    
    <!--<modal nome="deletar" titulo="@lang('prospecto.confirma_remover')" css=''>
        <formulario id="formExcluir" v-bind:action="'{{route('prospecto.exclui')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id' hidden v-model="$store.state.item.id">

            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="id_user">@lang('prospecto.colaborador')</label>
                        <select readonly disabled name="id_user" id="" aria-readonly="true" v-model="$store.state.item.id_user" class='form-control' >
                            
                            @foreach ($colaboradores as $colaborador)
                                <option value="{{$colaborador->id}}">{{$colaborador->nome}}</option>
                            @endforeach
            
                        </select>
                        <div class="line"></div>
                    </div>
            
                    <div class="form-group col-md-4">
                        <label for="id_cliente">@lang('prospecto.cliente')</label>
                        <select readonly disabled name="id_cliente" id="" aria-readonly="true" v-model="$store.state.item.id_cliente" class='form-control' >
                            
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
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
                        <input readonly disabled name='data_prospecto' aria-readonly="true" v-model="$store.state.item.data_prospecto" class='form-control' required='true' type='date' id='data_prospecto' />
                        <div class="line"></div>
                    </div>
            
                    <div class="form-group col-md-4">
                        <label for="nome">@lang('cliente.nome')</label>
                        <input readonly disabled class="form-control" aria-readonly="true" v-model="$store.state.item.observacao" id="observacao" name="observacao" type="text" aria-describedby="" placeholder="@lang('prospecto.observacao')" required>
                        <div class="line"></div>
                    </div>    
        
                </div>
            </div>
    
        </formulario>
        <span slot="botoes">
            <button form="formExcluir" class="btn btn-info">@lang('buttons.deletar')</button>
        </span>
    </modal>


    <modal nome="outro1" titulo="@lang('prospecto.confirma_encerrar')" css=''>
        <formulario id="formEncerrar" v-bind:action="'{{route('prospecto.encerra')}}'" css='row' method="put" enctype="" token="{{ csrf_token() }}">

            <input type="text" name='id_prospecto' hidden v-model="$store.state.item.id">

            <div class="col-md-12">
                <div class="row">
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
            </div>
    
            <div class="col-md-12">
                <div class="row">
                    <div class='form-group col-md-4' >
                        <label for="data_encerramento">@lang('prospecto.data_encerramento')</label>
                        <input name='data_encerramento' value="{{date('Y-m-d')}}" class='form-control' required='true' type='date' id='data_encerramento' />
                        <div class="line"></div>
                    </div>        
                </div>
            </div>
    
        </formulario>
        <span slot="botoes">
            <button form="formEncerrar" class="btn btn-info">@lang('prospecto.encerrar')</button>
        </span>
    </modal>-->
@endsection

@section('scripts')
@endsection