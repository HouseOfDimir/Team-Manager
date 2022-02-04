@extends('layouts.app')

@section('content')
    <h1>Votre planning du {{ $formatedStDate }} au {{ $formatedEndDate }}</h1>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div id="calendar" class="a-box-shadow"></div>
            </div>
        </div>
@stop

@section('addCalendar')

    <script>
        var config = {
                routes: {
                    getAllEvents:'{{ route('ajax.getAllEventsById') }}',
                    getEmployeeById:'{{ route('ajax.getOneEmployeeById', ['fkEmployee' => $id]) }}'
                },
                data: {
                    start: '{{ $startDate }}',
                    end: '{{ $endDate }}',
                    fkEmployee: '{{ $id }}',
                }
            }
    </script>

    {{-- <script src="{{ env('DIRLIB') }}/fullcalendar/main.min.js"></script> --}}
    <script src="{{ env('DIRLIB') }}/fullcalendar-scheduler-5.10.1/lib/main.js"></script>
    {{-- <script lang="ts" type="module" src="{{ env('DIRLIB') }}/fullcalendar-scheduler-master/bundle/src/main.ts"></script> --}}
    <script src="{{ env('DIRLIB') }}/fullcalendar/locales/fr.js"></script>
    <script src="{{ env('DIRLIB') }}/moment/moment.min.js"></script>
    <script src="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('js/planningSolo.js') }}"></script>
    <link href="{{ env('DIRLIB') }}/fullcalendar/main.min.css" rel="stylesheet">
    <link href="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link href="{{ asset('css/planning.css') }}" rel="stylesheet">
    {{-- <script src="{{ env('DIRLIB') }}AdminLTE/plugins/moment/moment-with-locales.min.js" defer></script> --}}
@endsection
