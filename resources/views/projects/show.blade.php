@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="card-title mb-3 text-primary">{{ $project->name }}</h2>
            <p class="card-text">{{ $project->description }}</p>

            <hr>

            <p class="mb-1">
                <strong class="text-muted">Creador:</strong>
                {{ $project->creator->name }}
            </p>
            <p class="mb-4">
                <strong class="text-muted">Fecha de creación:</strong>
                {{ $project->created_at->format('d/m/Y') }}
            </p>

            <a href="{{ route('projects.index') }}" class="btn btn-outline-primary">
                Volver a la lista de proyectos
            </a>
        </div>
    </div>
</div>
@endsection
