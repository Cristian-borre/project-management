@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded">
        <div class="card-header bg-primary text-white fw-bold">
            Crear Nuevo Proyecto
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projects.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre del Proyecto:</label>
                    <input type="text" class="form-control shadow-sm" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción:</label>
                    <textarea class="form-control shadow-sm" id="description" name="description" rows="4"></textarea>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Guardar Proyecto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
