@component('mail::messageAdmin', [
                                     'exception'      => $exception,
                                     'request'        => $request,
                                     'code'           => $code,
                                     'exceptionStack' => $exceptionStack,
                                     'session'        => $session
                                    ])

{{ $title }}   : Erreur {{ $code }}<br /><br />
{!! $exception !!}<br /><br />
@foreach($request as $item)
    {{ $item }}<br />
@endforeach
<br />
{{-- @foreach($exceptionStack as $item)
    {{ $item }}<br />
@endforeach
<br /> --}}

@if(count($session->get('url')) > 0)
    @foreach($session->get('url') as $url)
        {{ $url }}
    @endforeach
@else
    Pas d'informations sur l'url
@endif
<br />
@if(count($session->get('_previous')) > 0)
    @foreach($session->get('_previous') as $url)
        {{ $url }}
    @endforeach
@else
    Pas d'informations sur l'url précédente
@endif
<br />
@if(count($session->get('_flash.old')) > 0)
    @foreach($session->get('_flash.old') as $key => $value)
        {{ $key .' : '. $value }}
    @endforeach
@else
    Pas d'informations sur les données de session
@endif
<br />
@if(count($session->get('_flash.new')) > 0)
    @foreach($session->get('_flash.new') as $key => $value)
        {{ $key .' : '. $value }}
    @endforeach
@else
    Pas d'informations sur les données de session
@endif

@endcomponent
