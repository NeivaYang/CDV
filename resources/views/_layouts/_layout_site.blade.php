<html lang="{{ app()->getLocale() }}">
    <head>
        @include('_layouts._includes._head')
        @yield('head')
    </head>

    <body  id='body'>
        <div id="app">
            <div class="d-flex" id="wrapper">
                <div id="page-content-wrapper">
                    @include('_layouts._includes._navbar')
                    <div class="container-fluid">
                        <div id="" class='mt-4' style="overflow-y: auto; overflow-x:auto">
                            <div class="">
                                <div class='col-12 mb-3'>
                                    <h1 style="color: #013856" class="text-left" >@yield('titulo')</h1>
                                    @if(View::hasSection('subtitulo'))
                                    <h4 style="color: #013856" class="text-left">@yield('subtitulo')</h4>
                                    @endif
                                    <hr style="background-color: #013856">
                                </div>
                            </div> 
                            <div class='col-12'>
                            @include('_layouts._includes._alert')
                            </div>
                            <div class='col-12'>
                                @yield('conteudo')
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </body>
    @include('_layouts._includes._footer')
    @include('_layouts._includes._scripts')
    @yield('scripts')	
           

    @include('_layouts._includes._modal')
</html>