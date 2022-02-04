@extends('layouts.app')

@section('content')
    <h1>Edition de contrats</h1>

    @include('partials._message')
    <form action="{{ $route }}" method="POST">
        @csrf
        <div class="a-panel a-panel-warning a-box-shadow">
            <div class="a-panel-header">{{ $title }}</div>
            <div class="a-panel-content">
                <div class="row">
                    @if(isset($contract))
                        <input type="hidden" value="{{ $contract->id }}" name="fkContract">
                    @endif

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <select class="a-input verifySelect" required name="fkEmployee">
                            <option value="" disabled selected>Sélectionnez un(e) employé(e)</option>
                            @foreach ($allEmployee as $employee)
                                <option value="{{ $employee->id }}" {{ isset($contract) && $contract->fkEmployee == $employee->id ? 'selected' : ''  }}>{{ $employee->name . ' ' . $employee->firstName }}</option>
                            @endforeach
                        </select>
                        <label><i class="fad fa-user"></i> Employé(e)</label>
                    </div>

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <select class="a-input verifySelect" required name="fkContractType">
                            <option value="" disabled selected>Sélectionnez un contrat</option>
                            @foreach ($allContractType as $contractType)
                                <option value="{{ $contractType->id }}" {{ isset($contract) && $contract->fkContractType == $contractType->id ? 'selected' : '' }}>{{ $contractType->name }}</option>
                            @endforeach
                        </select>
                        <label><i class="fad fa-file-contract"></i> Type de contrat</label>
                    </div>

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input verifyInt" name="dureeHebdo" value="{{ $contract->dureeHebdo ?? '' }}" placeholder="Saisie temps de travail (en heures)" data-min-length="1" maxlength="2"/>
                        <label><i class="fad fa-briefcase"></i> Temps de travail hebdomadaire</label>
                    </div>

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input verifyInt" name="dureeAnnuelle" value="{{ $contract->dureeAnnuelle ?? '' }}" placeholder="Saisie temps de travail (en heures)" data-min-length="1" maxlength="4"/>
                        <label><i class="fad fa-briefcase"></i> Temps de travail annuel</label>
                    </div>

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input verifyDate" name="startPeriod" value="{{ $contract->startPeriod ?? '' }}" placeholder="Saisie date début contrat"/>
                        <label><i class="fad fa-hourglass-start"></i> Début contrat</label>
                    </div>

                    <div class="col-md-6 col-md-offset-1 a-input-group">
                        <input class="a-input verifyDate" name="endPeriod" value="{{ $contract->endPeriod ?? '' }}" placeholder="Saisie date fin contrat"/>
                        <label><i class="fad fa-hourglass-end"></i> Fin contrat</label>
                    </div>

                    <div class="col-md-12 ar">
                        @if(isset($contract))
                            <button class="a-btn a-warning a-form-handler" name="edit" type="submit"><i class="fal fa-plus-square"></i> Editer</button>
                        @else
                            <button class="a-btn a-tertiary a-form-handler" type="submit"><i class="fal fa-plus-square"></i> Créer</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    @if(isset($allEmployeeContract) && filled($allEmployeeContract))
        <table class="a-table a-table-hover a-box-shadow">
            <thead class="a-table-header-light">
                <tr>
                    <th>Employé</th>
                    <th>Type contrat</th>
                    <th>Durée hebdo</th>
                    <th>Durée annuelle</th>
                    <th class="centered">Modifier</th>
                    <th class="centered">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allEmployeeContract as $item)
                    <tr>
                        <td>{{ $item->firstName.' '.$item->eName }}</td>
                        <td>{{ $item->libelleContrat }}</td>
                        <td>{{ $item->dureeHebdo.' h' }}</td>
                        <td>{{ $item->dureeAnnuelle.' h' }}</td>
                        <td><a href="{{ route('contract.index', ['fkContract' => $item->id]) }}" class="a-btn-sm a-warning"><i class="fa fa-edit"></i></a></td>
                        <td><a href="{{ route('contract.deleteContract', ['fkContract' => $item->id]) }}" class="a-btn-sm a-danger"><i class="fa fa-trash"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="col-md-12">
            <div class="a-alert alert-info" role="alert"><i class="far fa-2x fa-info-circle"></i> Pas de contrats enregistrés pour le moment.</div>
        </div>
    @endif
@stop

@section('contractJS')
    <script src="{{ asset('js/contract.js') }}"></script>
@endsection
