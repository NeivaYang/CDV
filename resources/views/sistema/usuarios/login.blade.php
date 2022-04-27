<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
<?php
    session_start();
?>
</head>
@include('_layouts._includes._login')

<body class="text-center">
    <div id="app"></div>
    <form action="{{route('login.entrar')}}" method="post" class="form-signin border border-light shadow-sm bg-white px-4">
        <h1 class="mb-5 font-weight-bolder">@lang('login.login')</h1>
        {{csrf_field()}}
        <div class="text-left">
            <div class="form-group">
                <label for="email">@lang('login.email')
                    <input class="form-control" name="email" type="email" id="email" required autofocus />
                </label>
            </div>
            <div class="form-group">
                <label for="password">@lang('login.senha')
                    <input class="form-control" name="password" type="password" id="password" required />
                </label>
            </div>
        </div>

        @if (Session::has('error'))
        <div class="text-danger">
            @lang('login.usuario_ou_senha_invalidos')
        </div>
        @endif
        
        <div hidden class="form-group">
            <div class="text-left">
                <div class="pretty p-default p-round p-has-focus2">
                    <input type="checkbox" />
                    <div class="state p-corpadrao">
                        <label>@lang('login.lembrar_minha_senha')</label>
                    </div>
                </div>                
            </div>
        </div>

        <button class="btn btn-lg btn-signin btn-block mt-5" type="submit">@lang('login.entrar')</button>
    </form>
</body>

@include('_layouts._includes._scripts')

</html>