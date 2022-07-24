<nav id="navbar" class="navbar navbar-expand-lg navbar-light navbar-dark">
    <!--<button class="btn" id="menu-toggle"><i class='fas fa-fw fa-2x fa-bars text-light'></i></button>-->

    <div class="navbar-brand text-center">
        <a class="navbar-brand text-light hidden-sm" href="{{route('dashboard')}}" ><img src="{{ asset('img/logos/logo3c.png') }}" alt=""></a>
    </div>

    <button class="text-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            {{-- @if ((Session::get('cdcFilhos') <> 0) || (Auth::user()->admin == 1)) --}}
            @if (Session::get('id_funcao') != 4 && Session::get('id_funcao') != 6)
            <li class="nav-item mr-2">
                <a href="{{route('colaborador.listar')}}" class="nav-link"><i class="fas fa-fw fa-sm fa-users"></i> @lang('sidenav.colaboradores')</a>
            </li>
            @endif
            <li class="nav-item mr-2">
                <a href="{{route('cliente.gerenciar')}}" class="nav-link"><i class="fas fa-fw fa-sm fa-address-card"></i> @lang('sidenav.clientes')</a>
            </li>
            <li class="nav-item mr-2">
                <a href="{{route('oportunidade.gerenciar')}}" class="nav-link"><i class="fas fa-fw fa-sm fa-crosshairs"></i> @lang('sidenav.oportunidade')</a>
            </li>
            <li class="nav-item mr-2">
                <a href="{{route('contrato.gerenciar')}}" class="nav-link"><i class="fas fa-fw fa-sm fa-file-contract"></i> @lang('sidenav.contratos')</a>
            </li>
        </ul>

        @if(Auth::user()->admin == 1)
        <div class="text-light dropdown">
            <button class="btn btn-corpadrao btn-lg dropdown-toggle text-light" type="button" data-toggle="dropdown" id='dropAdmin' aria-haspopup="true" aria-expanded="false" data-placement="bottom" >
                <i class="fas fa-fw fa-lg fa-tools"></i> @lang('sidenav.configuracao')
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropAdmin">
                <li class="container"><a class="dropdown-item nav-link" href="{{route('funcao.gerenciar')}}"><i class="fas fa-fw fa-lg fa-id-badge mr-2"></i> @lang('sidenav.funcao')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('concorrente.gerenciar')}}"><i class="fas fa-fw fa-lg fa-user-secret mr-2"></i> @lang('sidenav.concorrentes')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('cultura.gerenciar')}}"><i class="fas fa-fw fa-lg fa-seedling mr-2"></i> @lang('sidenav.cultura')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('empresa.gerenciar')}}"><i class="fas fa-fw fa-lg fa-industry mr-2"></i> @lang('sidenav.empresas')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('motivo.gerenciar')}}"><i class="fas fa-fw fa-lg fa-bullhorn mr-2"></i> @lang('sidenav.motivos')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('produto.gerenciar')}}"><i class="fas fa-fw fa-lg fa-cubes mr-2"></i> @lang('sidenav.produtos')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('servico.gerenciar')}}"><i class="fas fa-fw fa-lg fa-comments-dollar mr-2"></i> @lang('sidenav.servicos')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('itensVenda.gerenciar')}}"><i class="fas fa-fw fa-lg fa-comments-dollar mr-2"></i> @lang('comum.itensVenda')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('pais.gerenciar')}}"><i class="fas fa-fw fa-lg fa-flag mr-2"></i> @lang('sidenav.pais')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('estado.gerenciar')}}"><i class="fas fa-fw fa-lg fa-chess-rook mr-2"></i> @lang('sidenav.estados')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('cidade.gerenciar')}}"><i class="fas fa-fw fa-lg fa-city mr-2"></i> @lang('sidenav.cidade')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('cdc.gerenciar')}}"><i class="fas fa-fw fa-lg fa-shield-alt mr-2"></i> @lang('sidenav.cdc')</a></li>
                <li class="container"><a class="dropdown-item nav-link" href="{{route('usuarios.listar')}}"><i class="fas fa-fw fa-lg fa-user-tie mr-2"></i> @lang('sidenav.administradores')</a></li>
            </ul>
        </div>
        @endif

        <!-- Admin option -->
        <div class="text-light dropdown">
            <button class="btn btn-corpadrao btn-lg dropdown-toggle text-light" type="button" data-toggle="dropdown" id='dropAdmin' aria-haspopup="true" aria-expanded="false" data-placement="bottom" >
                @if (Auth::user()->admin == 1)
                <i class="fas fa-fw fa-lg fa-user-tie"></i> {{Auth::user()->nome}}
                @else
                <i class="fas fa-fw fa-lg fa-user-circle"></i> {{Auth::user()->nome}}
                @endif
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropAdmin">
                    @if (Auth::user()->admin <> 1)
                <li class="container">
                    <p class="container">{{Session::get('empresa')}}</p>
                    <p class="container">{{Session::get('cdc')}} - {{Session::get('funcao')}}</p>
                    <p class="container">{{Session::get('codigo')}}</p>
                </li>
                <li class="container">
                    <a class='dropdown-item nav-link' href="{{ route('usuario.profile', Auth::user()->id ) }}"><i class="fas fa-fw fa-lg fa-id-card"></i> Profile</a>
                </li>
                <li class="dropdown-divider"></li>
                @endif
                <li class="container">
                    <a class='dropdown-item nav-link' href="{{route('sair')}}"><i class="fas fa-fw fa-lg fa-sign-out-alt"></i> @lang('comum.sair')</a>
                </li>
            </ul>
        </div>

        <!-- Language Options -->
        <!--<div class="text-light dropdown">
            <button class="btn btn-default btn-lg dropdown-toggle text-light" type="button" data-toggle="dropdown" id='dropLang' aria-haspopup="true" aria-expanded="false" data-placement="bottom">
                @if (Auth::user()->admin == 1)
                <i class="fas fa-fw fa-lg fa-user-tie"></i> {{Auth::user()->nome}}
                @else
                <i class="fas fa-fw fa-lg fa-user-circle"></i> {{Auth::user()->nome}}
                @endif
            </button>
            <ul class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="dropLang">
                @if (Auth::user()->admin <> 1)
                <div class="text-center">
                    <li class="container">{{Session::get('empresa')}}</li>
                    <li class="container">{{Session::get('cdc')}} - {{Session::get('funcao')}}</li>
                    <li class="container">{{Session::get('codigo')}}</li>
                </div>
                @endif
                <li class="container">
                    <a class='dropdown-item nav-link' href="#"><i class="fas fa-fw fa-lg fa-id-card"></i> Profile</a>
                </li>
                <li class="dropdown-divider"></li>
                <li class="container">
                    <a class='dropdown-item nav-link' href="{{route('sair')}}"><i class="fas fa-fw fa-lg fa-sign-out-alt"></i> @lang('comum.sair')</a>
                </li>
            </ul>
        </div>-->

    </div>
</nav>