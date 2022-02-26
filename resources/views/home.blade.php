@extends('layouts.app')

@section('title_page', 'Index')

@section('content')
<h1 class="">Accueil</h1>

<div class="row">
    <div class="card-deck center w100">
        <div class="col-md-4">
            <div class="card a-box-shadow">
                <img src="{{ asset('image/employee.jpg') }}" alt="A venir" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Employés</h5>
                    <p>

                    </p>
                </div>
                <div class="card-footer">
                    <ul>
                        <li>
                            <a href="{{ route('employee.creationEmployee') }}" class="card-link">
                                <i class="fad fa-keyboard"></i>
                                Accéder à la saisie
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employee.index') }}" class="card-link">
                                <i class="fad fa-users"></i>
                                Liste des employés
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card a-box-shadow">
                <img src="{{ asset('image/administration.jpg') }}" alt="A venir" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Administration</h5>
                    <p>

                    </p>
                </div>
                <div class="card-footer">
                    <ul>
                        <li>
                            <a href="{{ route('task.index') }}" class="card-link">
                                <i class="fad fa-tasks"></i>
                                Tâches
                            </a>
                        </li>
                        <li><a class="card-link" href="{{ route('contract.index') }}"><i class="fad fa-file-contract"></i> Contrats</a></li>
                        <li>
                            <a href="{{ route('task.administration') }}" class="card-link">
                                <i class="fad fa-cogs"></i>
                                Administration
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('task.index') }}" class="card-link">
                                <i class="fas fa-door-open"></i>
                                Contrats
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card a-box-shadow">
                <img src="{{ asset('image/planning.jpg') }}" alt="A venir" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Planning</h5>
                    <p>
                        Accès à la gestion des emplois du temps des employés.
                    </p>
                </div>
                <div class="card-footer">
                    <ul>
                        <li>
                            <a href="{{ route('planning.index') }}" class="card-link">
                                <i class="fad fa-door-open"></i>
                                Accéder
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
