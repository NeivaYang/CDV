<!-- Sidebar -->
<div class="navbar-toggler" id="sidebar-wrapper">
    <!--<div class="sidebar-heading text-light" >
        <img src="{{asset('img/logos/logo_irriger.png')}}" alt="" class="img-fluid" style="max-width: 10rem">
    </div>-->

    <div class="perfil">
        @if (Auth::user()->admin == 1)
        <i class="fas fa-fw fa-5x fa-user-tie" style="margin-bottom: 8px; opacity: 0.7;"></i>
        <p>{{Auth::user()->nome}}</p>
        @else
        <i class="fas fa-fw fa-5x fa-user-circle" style="margin-bottom: 8px; opacity: 0.7;"></i>
        <p>{{Auth::user()->nome}}</p>
        <p>{{Session::get('empresa')}}</p>
        <p>{{Session::get('cdc')}}</p>
        <p>{{Session::get('funcao')}}</p>
        <p>{{Session::get('codigo')}}</p>
        @endif
    </div>

    <ul class="list-group list-group-flush">
        <li>
            @if(Auth::user()->admin == 1)
            <a class="dropdown-item dropdown-toggle list-group-item list-group-item-action list-group-sidenav text-light" data-toggle="collapse" aria-expanded="false" href="#sidenav_organizacao">
                @lang('sidenav.organizacao')
            </a>
            <ul class="collapse list-group list-group-flush" id="sidenav_organizacao">               
            @endif

            @if ((Session::get('cdcFilhos') <> 0) || (Auth::user()->admin == 1))
            <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('colaborador.listar')}}"> 
                <i class="fas fa-fw fa-lg fa-users mr-2"></i> @lang('sidenav.colaboradores')
            </a>                
            @endif

            <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('cliente.gerenciar')}}">
                <i class="fas fa-fw fa-lg fa-address-card mr-2"></i> @lang('sidenav.clientes')
            </a>

            <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('oportunidade.gerenciar')}}"> 
                <i class="fas fa-fw fa-lg fa-crosshairs mr-2"></i> @lang('sidenav.oportunidade')
            </a>            

            <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('contrato.gerenciar')}}"> 
                <i class="fas fa-fw fa-lg fa-file-contract mr-2"></i>  @lang('sidenav.contratos')
            </a>            

            @if(Auth::user()->admin == 1)
            </ul>
            @endif

            @if(Auth::user()->admin == 1)
            <a class="dropdown-item dropdown-toggle list-group-item list-group-item-action list-group-sidenav text-light" data-toggle="collapse" aria-expanded="false" href="#sidenav_configuracao">
                @lang('sidenav.configuracao')
            </a>
            <ul class="collapse list-group list-group-flush" id="sidenav_configuracao">               
                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('funcao.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-id-badge mr-2"></i> @lang('sidenav.funcao')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('concorrente.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-user-secret mr-2"></i> @lang('sidenav.concorrentes')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('cultura.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-seedling mr-2"></i> @lang('sidenav.cultura')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('empresa.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-industry mr-2"></i> @lang('sidenav.empresas')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('motivo.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-bullhorn mr-2"></i> @lang('sidenav.motivos')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('produto.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-cubes mr-2"></i> @lang('sidenav.produtos')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('servico.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-paper-plane mr-2"></i> @lang('sidenav.servicos')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('pais.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-flag mr-2"></i> @lang('sidenav.pais')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('estado.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-tree mr-2"></i> @lang('sidenav.estados')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('cidade.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-city mr-2"></i> @lang('sidenav.cidade')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('cdc.gerenciar')}}"> 
                    <i class="fas fa-fw fa-lg fa-shield-alt mr-2"></i> @lang('sidenav.cdc')
                </a>

                <a class="dropdown-item list-group-item list-group-item-action list-group-sidenav text-light" href="{{route('usuarios.listar')}}"> 
                    <i class="fas fa-fw fa-lg fa-user-tie mr-2"></i> @lang('sidenav.administradores')
                </a>

            </ul>
            @endif

        </li>
    </ul>
</div>
<!-- /#sidebar-wrapper -->
