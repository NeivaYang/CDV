@if(session()->has('alert'))
    <?php
        $alert = Session::get('alert');
        Session::forget('alert');
    ?>
    <div class='col-12'>
        <div class="alert alert-{{$alert['tipo']}}" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h3 class="alert-heading">@lang($alert['titulo'])</h3>
            <h4>@lang($alert['mensagem'])</h4>

            @if(isset($alert['link']))
                <a class="btn btn-{{$alert['tipo']}} center-block" href="{{route($alert['link'])}}">@lang($alert['descLink'])</a>
            @endif
        </div>
    </div>
@endif