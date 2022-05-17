


    <h1>Votre planning du {{ $formatedStDate }} au {{ $formatedEndDate }}</h1>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div id="calendar" class="a-box-shadow"></div>
        </div>
    </div>




<script>
    var config = {
            routes: {
                getAllResources: '{{ route('ajax.getAllEmployee') }}',
                getAllEvents:'{{ route('ajax.getAllEvents') }}'
            },
            data: {
                start: '{{ $startDate }}',
                end: '{{ $endDate }}'
            }
        }
</script>

<script src="{{ env('DIRLIB') }}fontawesome-5.13.0/js/fontawesome.min.js" defer></script>
<script src="{{ env('DIRLIB') }}FontAwesome.Pro.5.15.1/js/all.min.js" defer></script>
<script src="{{ env('DIRLIB') }}AdminLTE/plugins/jquery/jquery.min.js"></script>
<script src="{{ env('DIRLIB') }}AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomFiles.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomCollapse.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomFormHandler.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomShuffle.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomSpinner.min.js"></script>
<script src="{{ env('DIRLIB') }}atom/v1.0/js/atomNotify.min.js"></script>
<script src="{{ env('DIRLIB') }}bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ env('DIRLIB') }}bootstrap-datepicker/dist/locales/bootstrap-datepicker.fr.min.js"></script>
{{-- <script src="{{ env('DIRLIB') }}atom/v1.0/css/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="{{ env('DIRLIB') }}AdminLTE/dist/js/adminlte.min.js" defer></script> --}}
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link href="{{ asset('css/app.min.css') }}" rel="stylesheet">
<link href="{{ env('DIRLIB') }}fontawesome-5.13.0/css/all.min.css" rel="stylesheet">
<link href="{{ env('DIRLIB') }}FontAwesome.Pro.5.15.1/css/all.min.css" rel="stylesheet">
<link href="{{ env('DIRLIB') }}bootstrap-4.4.1/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ env('DIRLIB') }}atom/v1.0/css/atom.css" rel="stylesheet">
<link href="{{ env('DIRLIB') }}bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

{{-- <script src="{{ env('DIRLIB') }}/fullcalendar/main.min.js"></script> --}}
<script src="{{ env('DIRLIB') }}/fullcalendar-scheduler-5.10.1/lib/main.js"></script>
{{-- <script lang="ts" type="module" src="{{ env('DIRLIB') }}/fullcalendar-scheduler-master/bundle/src/main.ts"></script> --}}
<script src="{{ env('DIRLIB') }}/fullcalendar/locales/fr.js"></script>
<script src="{{ env('DIRLIB') }}/moment/moment.min.js"></script>
<script src="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.js"></script>
<script src="{{ asset('js/planningGlobal.js') }}"></script>
<link href="{{ env('DIRLIB') }}/fullcalendar/main.min.css" rel="stylesheet">
<link href="{{ env('DIRLIB') }}/jquery-ui/jquery-ui.min.css" rel="stylesheet">
<link href="{{ asset('css/planning.css') }}" rel="stylesheet">
{{-- <script src="{{ env('DIRLIB') }}AdminLTE/plugins/moment/moment-with-locales.min.js" defer></script> --}}

