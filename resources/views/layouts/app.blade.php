<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

       <!-- Scripts -->
       <script src="{{ env('DIRLIB') }}fontawesome-5.13.0/js/fontawesome.min.js" defer></script>
       <script src="{{ env('DIRLIB') }}FontAwesome.Pro.5.15.1/js/all.min.js" defer></script>
       <script src="{{ env('DIRLIB') }}AdminLTE/plugins/jquery/jquery.min.js"></script>
       <script src="{{ env('DIRLIB') }}AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomFiles.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomCollapse.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomFormHandler.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomShuffle.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomSpinner.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomNotify.min.js"></script>
       <script src="{{ env('DIRLIB') }}atom/v1.0/js/atomDatatable.min.js"></script>
       <script src="{{ env('DIRLIB') }}bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
       <script src="{{ env('DIRLIB') }}bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js"></script>
       {{-- <script src="{{ env('DIRLIB') }}atom/v1.0/css/bootstrap.bundle.min.js"></script> --}}
       {{-- <script src="{{ env('DIRLIB') }}AdminLTE/dist/js/adminlte.min.js" defer></script> --}}
       <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
       @yield('addCalendar')
       @yield('ficheEmployeeJS')
       @yield('contractJS')
       @yield('task')
       @yield('addJS')

       <!-- Styles -->
       <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       <link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
       <link href="{{ env('DIRLIB') }}fontawesome-5.13.0/css/all.min.css" rel="stylesheet">
       <link href="{{ env('DIRLIB') }}FontAwesome.Pro.5.15.1/css/all.min.css" rel="stylesheet">
       <link href="{{ env('DIRLIB') }}bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">
       <link href="{{ env('DIRLIB') }}atom/v1.0/css/atom.css" rel="stylesheet">
       <link href="{{ env('DIRLIB') }}bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
       {{-- <link href="{{ env('DIRLIB') }}AdminLTE/dist/css/adminlte.min.css" rel="stylesheet"> --}}
</head>
<body>
    @csrf
    <div id="app">
        @include('layouts.partials.navBars')

        <main class="container" {{-- @if(isset($fullScreen))style="min-width: 100%;"@endif --}}>
            @yield('content')
        </main>
    </div>
</body>
</html>
