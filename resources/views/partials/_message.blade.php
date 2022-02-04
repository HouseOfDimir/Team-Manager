{{-- @if (session()->has('confirmMessage'))
    <script>
        $.notify("{!! session()->get('confirmMessage') !!}", "success");
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $.notify('{!! $error !!}', "error");
        </script>
    @endforeach
@endif --}}

<div class="container">
    @if($message = Session::get('success'))
        <div class="a-alert alert-success alert-block row" id="toCollapseSuccess">
            <div class="col-md-8">
                <strong>{{ $message }}</strong>
            </div>
            <div class="d-flex flex-row-reverse col-md-4">
                <i class="fas fa-times collapser closeAlerte" colapse-target="#toCollapseSuccess"></i>
            </div>
        </div>
    @endif

    @if($message = Session::get('error'))
        <div class="a-alert alert-danger alert-block row" id="toCollapseError">
            <div class="col-md-8">
                <strong>{{ $message }}</strong>
            </div>
            <div class="d-flex flex-row-reverse col-md-4">
                <i class="fas fa-times collapser closeAlerte" colapse-target="#toCollapseError"></i>
            </div>
        </div>
    @endif

    @if($message = Session::get('warning'))
        <div class="col-md-8">
            <strong>{{ $message }}</strong>
        </div>
        <div class="d-flex flex-row-reverse col-md-4">
            <button type="button" class="close" data-dismiss="alert">{{-- <i class="fas fa-times text-right"></i> --}}</button>
        </div>
    @endif

    @if($message = Session::get('info'))
        <div class="col-md-8">
            <strong>{{ $message }}</strong>
        </div>
        <div class="d-flex flex-row-reverse col-md-4">
            <button type="button" class="close" data-dismiss="alert">{{-- <i class="fas fa-times text-right"></i> --}}</button>
        </div>
    @endif

    @if($errors->any())
        <div class="a-alert alert-danger row">
            <div class="col-md-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>

            <div class="d-flex flex-row-reverse col-md-4">
                <button type="button" class="close" data-dismiss="alert">{{-- <i class="fas fa-times text-right"></i> --}}</button>
            </div>
        </div>
    @endif
</div>

<script>
        $('.collapser').atomCollapse();
</script>
