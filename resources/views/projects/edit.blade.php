@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-warning text-white fw-bold">
            Editar Proyecto
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projects.update', $project) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Proyecto:</label>
                    <input type="text" name="name" id="name" class="form-control shadow-sm" 
                           value="{{ $project->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción:</label>
                    <textarea name="description" id="description" class="form-control shadow-sm" rows="4">{{ $project->description }}</textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning text-white">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
