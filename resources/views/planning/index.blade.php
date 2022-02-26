@extends('layouts.app')

@section('content')
    <h1>Planning</h1>
    @include('partials._message')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">
                    <div class="a-panel a-panel-warning a-box-shadow">
                        <div class="a-panel-header">Tâches</div>
                        <div class="a-panel-content">
                            <div class="center">
                                <div class="row" id="external-events">
                                    @foreach ($alltask as $task)
                                        <div class="external-event col-md-10" id="task_{{ $task->id }}" style="background-color:{{ $task->color }};color:{{ $task->letterColor }}">{{ $task->libelle }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.col -->
                <div class="col-md-10">
                    <div id="calendar" class="a-box-shadow"></div>
            </div><!-- /.container-fluid -->
        </div>
@stop

@section('addCalendar')

    <script>
        var config = {
                routes: {
                    getAllResources: '{{ route('ajax.getAllEmployee') }}',
                    deleteEvent:'{{ route('planning.delete') }}',
                    addEvent:'{{ route('planning.create') }}',
                    updateEvent:'{{ route('planning.delete') }}',
                    getAllEvents:'{{ route('ajax.getAllEvents') }}'
                },
                modelFunc: {
                    add: '{{ config('app.switch.add') }}',
                    update: '{{ config('app.switch.update') }}',
                    delete: '{{ config('app.switch.delete') }}',
                }
            }
    </script>

    {{-- <script src="{{ env('DIRLIB') }}/fullcalendar/main.min.js"></script> --}}
    <script src="{{ env('DIRLIB') }}/fullcalendar-scheduler-5.10.1/lib/main.js"></script>
    {{-- <script lang="ts" type="module" src="{{ env('DIRLIB') }}/fullcalendar-scheduler-master/bundle/src/main.ts"></script> --}}
    <script src="{{ env('DIRLIB') }}/fullcalendar/locales/fr.js"></script>
    <script src="{{ env('DIRLIB') }}/moment/moment.min.js"></script>
    <script src="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('js/planning.js') }}"></script>
    <link href="{{ env('DIRLIB') }}/fullcalendar/main.min.css" rel="stylesheet">
    <link href="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.css" rel="stylesheet">
    <link href="{{ asset('css/planning.css') }}" rel="stylesheet">
    {{-- <script src="{{ env('DIRLIB') }}AdminLTE/plugins/moment/moment-with-locales.min.js" defer></script> --}}
@endsection
