@extends('layouts.app')

@section('content')
    <h1>Gestion des tâches</h1>
    @include('partials._message')
    <form action="{{ $route }}" method="POST">
        @csrf
        <div class="a-panel a-panel-warning a-box-shadow">
            <div class="a-panel-header">Ajouter une tâche</div>
            <div class="a-panel-content">
                <div class="row">
                    <div class="col-md-2 col-md-offset-1 a-input-group">
                        <input class="a-input color" name="color" type="color" placeholder="" value="{{ $task->color ?? '' }}"/>
                        <label><i class="fad fa-paint-brush-alt"></i> Couleur</label>
                    </div>

                    <div class="col-md-3 col-md-offset-1 a-input-group">
                        <select class="a-input" name="fkLetterColor" required>
                            <option value="" disabled selected>Sélectionnez une couleur</option>
                            @foreach ($letterColor as $item)
                                <option value="{{ $item->id }}" @if(isset($task)){{ $task->fkLetterColor == $item->id ? 'selected' : '' }}@endif>{{ $item->libelleColor }}</option>
                            @endforeach
                        </select>
                        <label><i class="fad fa-paint-brush-alt"></i> Couleur écriture</label>
                    </div>

                    <div class="col-md-5 col-md-offset-1 a-input-group">
                        <input class="a-input" name="libelle" placeholder="Saisie nom tâche" value="{{ $task->libelle ?? '' }}"/>
                        <label><i class="fad fa-tags"></i> Libellé</label>
                    </div>

                    @if(isset($task))
                        <input type="hidden" value="{{ $task->id }}" name="fkTask">
                    @endif

                    <div class="col-md-2">
                        @if(isset($task))
                            <button class="a-btn a-warning a-form-handler" name="edit" type="submit"><i class="fal fa-plus-square"></i> Modifier</button>
                        @else
                            <button class="a-btn a-tertiary a-form-handler" type="submit"><i class="fal fa-plus-square"></i> Ajouter</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>

    <table class="a-table a-table-hover a-box-shadow">
        <thead class="a-table-header-light">
            <tr>
                <th>Libellé</th>
                <th>Couleur</th>
                <th class="centered">Modifier</th>
                <th class="centered">Supprimer</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allTask as $oneTask)
                <tr>
                    <td>{{ $oneTask->libelle }}</td>
                    <td><div class="divColor" style="background-color: {{ $oneTask->color }};"><div class="microDivColor" style="background-color:{{ $oneTask->letterColor }}"></div></div></td>
                    <td><a href="{{ route('task.index', ['fkTask' => $oneTask->id]) }}" class="a-btn-sm a-warning"><i class="fa fa-edit"></i></a></td>
                    <td><a href="{{ route('task.deleteTask', ['fkTask' => $oneTask->id]) }}" class="a-btn-sm a-danger"><i class="fa fa-trash"></i></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('task')
    <script src="{{ asset('js/task.js') }}"></script>
@endsection
