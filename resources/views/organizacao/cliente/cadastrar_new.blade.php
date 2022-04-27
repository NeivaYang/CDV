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
        </div>

        <div class="col-12">
            <div class="form-row mt-3">
                <div class="col-md-3"><h2>CDCs do Cliente</h2></div>
                <div class="col-md-3">
                    <a class="add_button btn btn-confirmacao" href="javascript:void(0);" title="Adicionar CDC"><i class="fas fa-fw fa-lg fa-plus"></i> Novo CDC</a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="field_wrapper mb-3">
                <div class="form-row">
                    <div class="col-10">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="id_cdc">@lang('fazenda.cdc')</label>
                                <select name="id_cdc[]" id="id_cdc" class="form-control selectpicker">
                                @foreach ($cdcs as $cdc)
                                    <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
                                @endforeach
                                </select>    
                                <div class="line"></div>
                            </div>
            
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" id="area_total" name="area_total[]"/>
                                @component('_layouts._components._inputLabel', ['texto'=>__('fazenda.area_total'), 'id' => 'area_total'])@endcomponent
                                <em class="input-unidade">ha</em>
                            </div>
                
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" id="area_irrigada" name="area_irrigada[]"/>
                                @component('_layouts._components._inputLabel', ['texto'=>__('fazenda.area_irrigada'), 'id' => 'area_irrigada'])@endcomponent
                                <em class="input-unidade">ha</em>
                            </div>
                
                            <div class="form-group col-md-3">
                                <input type="text" class="form-control" id="nome_fazenda" name="nome_fazenda[]"/>   
                                @component('_layouts._components._inputLabel', ['texto'=>'Nome da fazenda', 'id' => 'nome_fazenda'])@endcomponent
                            </div>
                        </div>    
                    </div>
                </div>
            </div>
    
            <div class="form-row">
                <div class="col-6 text-left">
                    <button class="btn btn-outline-confirmacao" style="margin: 0 auto" type="submit">@lang('buttons.salvar')</button>
                    <a class="btn btn-outline-secondary" href="{{route('cliente.gerenciar')}}">@lang('buttons.voltar')</a>
                </div>
            </div>        
        </div>

    </form>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrappe
        var lbl_cdc = $('label[for="id_cdc"]').text();
        var lbl_area_total = $('label[for="area_total"]').text();
        var lbl_area_abrangida = $('label[for="area_irrigada"]').text();
        var lbl_nome_fazenda = $('label[for="nome_fazenda"]').text();
        var Content = '';
        var fieldHTML = ''; //New input field html 
        var ContentOptions = '';
        var indice = 1; //Initial field counter is 1
        
        $("#id_cdc option").each(function () {
            ContentOptions = '<option value="'+$(this).val()+'">'+$(this).text()+'</option>'+'\n';
        });

        //Once add button is clicked
        $(addButton).click(function(){
            Content = '';

            Content += '                <div class="form-row" id="row-'+indice+'">'+'\n';
            Content += '                    <div class="col-10">'+'\n';
            Content += '                        <div class="form-row">'+'\n';
            Content += '                            <div class="form-group col-md-3">'+'\n';
            Content += '                                <label for="id_cdc'+indice+'">'+lbl_cdc+'</label>'+'\n';
            Content += '                                <select name="id_cdc[]" id="id_cdc'+indice+'" class="form-control selectpicker">'+'\n';
            Content += ContentOptions;
            Content += '                                </select>'+'\n';  
            Content += '                                <div class="line"></div>'+'\n';
            Content += '                            </div>'+'\n';
            Content += '                            <div class="form-group col-md-3">'+'\n';
            Content += '                                <input type="text" class="form-control" id="area_total'+indice+'" name="area_total[]"/>'+'\n';
            Content += '                                <label class="float-label" for="area_total'+indice+'">'+lbl_area_total+'</label>'+'\n';
            Content += '                                <div class="line"></div>'+'\n';
            Content += '                                <em class="input-unidade">ha</em>'+'\n';
            Content += '                            </div>'+'\n';
            Content += '                            <div class="form-group col-md-3">'+'\n';
            Content += '                                <input type="text" class="form-control" id="area_irrigada'+indice+'" name="area_irrigada[]"/>'+'\n';
            Content += '                                <label class="float-label" for="area_irrigada'+indice+'">'+lbl_area_abrangida+'</label>'+'\n';
            Content += '                                <div class="line"></div>'+'\n';
            Content += '                                <em class="input-unidade">ha</em>'+'\n';
            Content += '                            </div>'+'\n';
            Content += '                            <div class="form-group col-md-3">'+'\n';
            Content += '                                <input type="text" class="form-control" id="nome_fazenda'+indice+'" name="nome_fazenda[]"/> '+'\n';  
            Content += '                                <label class="float-label" for="nome_fazenda'+indice+'">'+lbl_nome_fazenda+'</label>'+'\n';
            Content += '                                <div class="line"></div>'+'\n';
            Content += '                            </div>'+'\n';
            Content += '                        </div>'+'\n';    
            Content += '                    </div>'+'\n';
            Content += '                    <div class="col-2">'+'\n';
            Content += '                        <a href="javascript:void(0);" data-parent="row-'+indice+'" class="btn btn-confirmacao remove_button" style="margin-top: 37;"><i class="fas fa-fw fa-lg fa-times"></i></a>'+'\n';
            Content += '                    </div>'+'\n';
            Content += '                </div>'+'\n';

            indice++; //Increment field counter
            $(wrapper).append(Content); //Add field html
        });
        
        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            document.getElementById($(this).data('parent')).remove;
            //$(this).parent('div').remove(); //Remove field html
            indice--; //Decrement field counter
        });


        //                            <option value="{{$cdc->id}}">{{$cdc->cdc}} - {{$cdc->nome}}</option>
    });
</script>
@endsection