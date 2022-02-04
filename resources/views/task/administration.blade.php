@extends('layouts.app')

@section('content')
    <h1>Administration</h1>
    @include('partials._message')
    <form action="{{ $route }}" method="POST">
        @csrf
        <div class="a-panel a-panel-warning a-box-shadow">
            <div class="a-panel-header">Administration</div>
            <div class="a-panel-content">
                <div class="row">
                    @foreach ($paramAdmin as $param)
                        <div class="col-md-6 col-md-offset-1 a-input-group">
                            <input class="a-input {{ $param->formVerify }}" name="{{ $param->code }}" value="{{ $param->valeur }}"/>
                            <label>{!! $param->icon . ' ' . $param->libelle !!}</label>
                        </div>
                        <div class="col-md-6 col-md-offset-1">
                            <div class="a-alert alert-info" role="alert">{{ $param->description }}</div>
                        </div>
                    @endforeach

                    <div class="col-md-12 ar">
                        <button class="a-btn a-warning a-form-handler" type="submit"><i class="fal fa-plus-square"></i> Modifier</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
