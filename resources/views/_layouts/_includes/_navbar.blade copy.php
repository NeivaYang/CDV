<nav id="navbar" class="navbar navbar-expand-lg navbar-light">
    <button class="btn" id="menu-toggle"><i class='fas fa-fw fa-2x fa-bars text-light'></i></button>

    <div class="navbar-brand text-center">
        <a class="navbar-brand text-light hidden-sm" href="{{route('dashboard')}}" ><img src="{{ asset('img/logos/Logo_Topo.png') }}" alt=""></a>
    </div>

    <button class="text-light navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-ellipsis-v"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                Colaborador
            </li>

            <!-- Admin option -->
            <!--<li class='nav-item  text-center my-auto'>
                <div class="text-light dropdown">
                    <button class="btn btn-default btn-lg dropdown-toggle text-light" type="button" data-toggle="dropdown" id='dropAdmin' aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" data-placement="bottom" >
                    <i class="fas fa-fw fa-lg fa-user-circle"></i> @lang('sidenav.admin')
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropAdmin">
                        <li class="container">
                            <a href="{{route('usuarios.listar')}}" class='dropdown-item nav-link'> <i class='fa fa-fw fa-users'></i> @lang('sidenav.usuarios')</a>
                            <a href="{{route('usuarios.listar')}}" class='dropdown-item nav-link'> <i class='fa fa-fw fa-users'></i> @lang('sidenav.usuarios')</a>
                            <a href="{{route('usuarios.listar')}}" class='dropdown-item nav-link'> <i class='fa fa-fw fa-users'></i> @lang('sidenav.usuarios')</a>
                        </li>
                    </ul>
                </div>
            </li>-->

            <!-- Language Options -->
            <li class='nav-item  text-center my-auto'>
                <div class="text-light dropdown">
                    <button class="btn btn-default btn-lg dropdown-toggle text-light" type="button" data-toggle="dropdown" id='dropLang' aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" data-placement="bottom" title="@lang('comum.idioma')">
                    <i class="fas fa-fw fa-lg fa-language"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropLang">
                        @if(session()->has('idiomas'))
                        @foreach (Session::get('idiomas') as $idioma)
                        <li class='container' >
                        <a class='dropdown-item nav-link' href="{{route('alterarIdioma', $idioma['valor'])}}"> 
                            <img src="{{asset('img/flags/' . $idioma['valor'] . ".png")}}" alt=""> {{strtoupper ($idioma['valor'])}}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </li>

            <li class="nav-item text-center" >
                <a class="nav-link text-light" href="{{route('sair')}}" data-toggle="tooltip" data-placement="bottom" title="@lang('comum.sair')">
                <i class="fas fa-fw fa-lg fa-sign-out-alt"></i>
                </a>
            </li>

        </ul>
    </div>
</nav>