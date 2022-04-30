@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Gestion des employés</h1>

        @include('partials._message')
        @if(isset($allEmployee) && filled($allEmployee))
            <div class="row">
                <div class="a-panel a-panel-warning a-box-shadow">
                    <div class="a-panel-header">Panel envoi de plannings</div>
                    <div class="a-panel-content">
                        <form method="POST" action="{{ route('employee.planningAndMail') }}" novalidate>
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-md-offset-1 a-input-group">
                                    <input class="a-input verifyDate" name="startDate" value=""/>
                                    <label><i class="fad fa-hourglass-start"></i> Début de semaine</label>
                                </div>
                                <div class="col-md-6 col-md-offset-1 a-input-group">
                                    <input class="a-input verifyDate" name="endDate" value=""/>
                                    <label><i class="fad fa-hourglass-end"></i> Fin de semaine</label>
                                </div>
                                <div class="col-md-6 col-md-offset-1 a-input-group">
                                    <select class="a-input verifySelect" required name="planningType">
                                        <option value="" disabled selected>Sélectionnez un planning</option>
                                        @foreach ($allPlanningType as $planning)
                                            <option value="{{ $planning->id }}">{{ $planning->libelle }}</option>
                                        @endforeach
                                    </select>
                                    <label><i class="fad fa-user"></i> Type de planning</label>
                                </div>
                                <div class="col-md-12">
                                    <label><i class="fad fa-user"></i> Employé(e)s</label>
                                    <div class="row">
                                        @foreach ($allEmployee as $employee)
                                            <div class="col-md-3 col-md-offset-1 a-input-group">
                                                <label><input type="checkbox" class="a-check" value="{{ $employee->id }}" name="fkEmployee[]"><span class="a-btn a-info" role="button" >{{ $employee->name . ' ' . $employee->firstName }}</span></label>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                            <div class="ar">
                                <button class="a-btn a-info a-form-handler" type="submit"><i class="fal fa-paper-plane"></i> Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-1 a-input-group mt-1">
                    <input class="a-input" value="" id="a-input-shuffle"/>
                    <label><i class="far fa-search"></i> Recherche employé</label>
                </div>
            </div>
            <div class="row">
                @foreach($allEmployee as $employee)
                    <div class="col-md-6">
                        <div class="a-panel a-panel-light a-box-shadow shufflingItem" data-title="{{ $employee->firstName . ' ' . $employee->name }}">
                            <div class="a-panel-header">
                                <div class="row">
                                    <div class="col-md-6">{{ $employee->firstName . ' ' . $employee->name }}</div>
                                    <div class="col-md-6 ar">
                                        @if(isset($employee->contract))
                                            <a href="{{ route('file.download', ['fkFile' => $employee->contract['id']]) }}" class="small-link"><i class="fas fa-paperclip"></i>Télécharger {{ $employee->contract['libelle'] }}</a>
                                            <a target="_blank" rel="noopener noreferrer" class="small-link" href="{{ route('file.display', ['fkFile' => $employee->contract['id']]) }}"><i class="far fa-eye"></i></a>
                                        @else
                                            {{ 'Pas de contrat en cours.' }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="a-panel-content">
                                <div class="row">
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->birthDate }}" disabled />
                                        <label><i class="fad fa-birthday-cake"></i> Né(e) le:</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->birthPlace }}" disabled />
                                        <label><i class="fad fa-map-marked-alt"></i> A:</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->greenNumber }}" disabled />
                                        <label><i class="fad fa-scanner-touchscreen"></i> Numéro sécurité sociale</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->adress }}" disabled />
                                        <label><i class="fad fa-map"></i> Adresse</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->city }}" disabled />
                                        <label><i class="fad fa-home"></i> Ville</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->zipCode }}" disabled />
                                        <label><i class="fad fa-map-pin"></i> Code postal</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->mail }}" disabled />
                                        <label><i class="fad fa-at"></i> Mail</label>
                                    </div>
                                    <div class="col-md-6 col-md-offset-1 a-input-group">
                                        <input class="a-input" value="{{ $employee->phone }}" disabled />
                                        <label><i class="fad fa-phone-rotary"></i> Téléphone</label>
                                    </div>

                                    @if(isset($employee->fileEmployee) && filled($employee->fileEmployee))
                                        @foreach($employee->fileEmployee as $file)
                                            <div class="col-md-12 center">
                                                <a href="{{ route('file.download', ['fkFile' => $file->id]) }}" class="small-link"><i class="fas fa-paperclip"></i>{{ $file->libelle }}</a>
                                                <a target="_blank" rel="noopener noreferrer" class="small-link" href="{{ route('file.display', ['fkFile' => $file->id]) }}"><i class="far fa-eye"></i></a>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-md-12">
                                            <div class="a-alert alert-info" role="alert">Pas de documents liés à cet employé.</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="a-panel-footer center">
                                @if(!isset($employee->contract))
                                    <a class="a-btn a-info" href="{{ route('sendMail', ['fkEmployee' => $employee->salt]) }}" type="submit"><i class="fal fa-paper-plane"></i> Données au N+1</a>
                                @endif
                                <a class="a-btn a-danger" href="{{ route('employee.deleteEmployee', ['fkEmployee' => $employee->salt]) }}" type="submit"><i class="fal fa-trash-alt"></i> Supprimer</a>
                                <a href="{{ route('employee.toModifyEmployee', ['fkEmployee' => $employee->salt]) }}" class="a-btn a-warning"><i class="fad fa-edit"></i> Editer</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
        <div class="a-alert alert-info"><i class="fas fa-info-circle"></i> Pas d'employés ajoutés pour le moment. Cliquer <a target="_blank" rel="noopener noreferrer" class="small-link" href="{{ route('employee.creationEmployee') }}">ici <i class="fad fa-align-justify"></i></a> pour aller à la page d'ajout. </div>
        @endif
    </div>
@stop

@section('addJS')
    <script src="{{ asset('js/listEmployee.js') }}"></script>
@endsection
