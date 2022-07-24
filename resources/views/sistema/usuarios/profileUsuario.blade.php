@extends('_layouts._layout_site')
@section('head')@endsection
@section('titulo')@lang('comum.profile')@endsection

@section('conteudo')
<div class="col-12">

    <div class="row">
        <div class="col-md-6 p-0">
            <form id="form_submit" action="{{ route('usuario.alterar') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $user['id'] }}">

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="nome">@lang('usuarios.nome')<em class="label-required"> *</em>
                            <input id="nome" class="form-control" maxlength="20" name="nome" required="required" type="text" aria-describedby="" value="{{ $user['nome'] }} "/>
                        </label>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="celular">@lang('usuarios.celular')<em class="label-required"> *</em>
                            <input id="celular" class="form-control" maxlength="15" name="celular" required="required" type="text" aria-describedby="" value="{{ $user['celular'] }} "/>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="email">@lang('usuarios.email')<em class="label-required"> *</em>
                            <input id="email" class="form-control" maxlength="190" name="email" required="required" type="email" aria-describedby="" value="{{ $user['email'] }} "/>
                        </label>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="codigo_idioma">@lang('usuarios.idioma')<em class="label-required"> *</em>
                            <select id="codigo_idioma" class="form-control has-value" name="codigo_idioma" required="required">
                                <option value="0" {{ $user['codigo_idioma'] == '0' ? 'selected' : ''}}>pt-br</option>
                                <option value="1" {{ $user['codigo_idioma'] == '1' ? 'selected' : ''}}>en</option>
                                <option value="2" {{ $user['codigo_idioma'] == '2' ? 'selected' : ''}}>es</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-2"><em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em></div>

                    <div class="col-6 text-left">
                        <button class="btn btn-outline-confirmacao" style="margin: 0px auto;" type="submit">@lang('comum.salvar')</button>
                        <a class="btn btn-outline-secondary" href="{{route('dashboard')}}">@lang('comum.voltar')</a>
                    </div>
                </div>

            </form>
        </div>

        <div class="col-md-6 p-0">
            <form id="form_submit" action="{{ route('alterar.senha') }}" method="post" autocomplete="off">
                @csrf
                <input type="hidden" name="id" value="{{ $user['id'] }}">

                <h3 style="color: rgb(1, 56, 86);">Alterar Senha</h3>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="currentPassword">@lang('usuarios.senha_atual')<em class="label-required"> *</em>
                            <input id="currentPassword" class="form-control" minlength="6" maxlength="20" name="currentPassword" type="password" placeholder="Insira a senha atual" />
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="password">@lang('usuarios.nova_senha')<em class="label-required"> *</em>
                            <input id="newPassword" class="form-control" minlength="6" maxlength="20" name="newPassword" type="password" placeholder="Apenas informe a senha se for altera-la!" />
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-5">
                        <label for="confirmpassword">@lang('usuarios.confirmar_nova_senha')<em class="label-required"> *</em>
                            <input id="confirmNewPassword" class="form-control" minlength="6" maxlength="20" name="confirmNewPassword" type="password" placeholder="Confirme a senha!" />
                        </label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-12 mb-2"><em><em class="label-required">*</em> @lang('comum.campos_obrigatorios')</em></div>
                    <div class="col-6 text-left">
                        <button class="btn btn-outline-confirmacao" style="margin: 0px auto;" type="submit">@lang('usuarios.alterar_senha')</button>
                        <a class="btn btn-outline-secondary" href="{{route('dashboard')}}">@lang('comum.voltar')</a>
                    </div>
                </div>

            </form>                
        </div>
    </div>

</div>
@endsection

@section('_scripts')
@endsection
