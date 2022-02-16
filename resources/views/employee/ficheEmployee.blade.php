@extends('layouts.app')

@section('content')
    <h1>{{ $h1 }}</h1>

    @include('partials._message')
    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="a-panel a-panel-warning a-box-shadow">
            <div class="a-panel-header">{{ $title }}</div>
            <div class="a-panel-content">
                <div class="row">
                    @foreach ($inputEmployee as $input)
                        @include('employee.partials._inputEmployee')
                    @endforeach
                </div>
{{-- faire le contraire: ramener les fichier employees par fkFiletype: si ça match alors dl etc sinon input --}}
                <div class="row">
                    @if(isset($fileEmployee) && filled($fileEmployee))
                        @foreach($fileType as $type)
                                @if(array_key_exists($type->id, $fileEmployee))
                                    <div class="col-md-6">
                                        <a target="_blank" rel="noopener noreferrer" class="small-link" href="{{ route('file.display', ['fkFile' => $fileEmployee[$type->id]['id']]) }}"><i class="far fa-eye"></i></a>
                                        <a href="{{ route('file.download', ['fkFile' => $fileEmployee[$type->id]['id']]) }}" class="small-link"><i class="fas fa-paperclip"></i>Télécharger {{ $fileEmployee[$type->id]['libelle'] }}</a>
                                        <a href="{{ route('file.delete', ['fkFile' => $fileEmployee[$type->id]['id']]) }}" class="blue"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                @else
                                    @include('employee.partials._fileInput')
                                @endif
                        @endforeach
                    @else
                        @foreach($fileType as $type)
                            @include('employee.partials._fileInput')
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="a-panel-footer">
                <div class="ar">
                    @if(isset($employee))
                        <input type="hidden" name="fkEmployee" value="{{ $employee->salt }}">
                        <a class="a-btn a-danger" href="{{ route('employee.deleteEmployee', ['fkEmployee' => $employee->salt]) }}" type="submit"><i class="fal fa-trash-alt"></i> Supprimer</a>
                        <button class="a-btn a-warning a-form-handler" type="submit"><i class="fal fa-edit"></i> Modifier</button>
                    @else
                        <button class="a-btn a-tertiary a-form-handler" type="submit"><i class="fal fa-plus-square"></i> Ajouter</button>
                    @endif
                </div>
            </div>
        </div>
    </form>
@stop

@section('ficheEmployeeJS')
    <script src="{{ asset('js/ficheEmployee.js') }}"></script>
@endsection
