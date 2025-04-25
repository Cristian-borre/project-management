@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm border-0 mb-5">
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

        @if ($tasks->isEmpty())
            <div class="alert alert-info mt-4">Este proyecto no tiene tareas asignadas.</div>
        @else
            <h4 class="text-muted mb-3">Tareas del Proyecto</h4>

            <div class="row">
                @foreach ($tasks as $task)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="card-title text-primary mb-1">{{ $task->title }}</h5>
                                    <p class="text-muted mb-2">{{ Str::limit($task->description, 80) }}</p>
                                    <p class="mb-1">
                                        <strong class="text-muted">Estado:</strong>
                                        <span
                                            class="badge bg-{{ $task->status === 'done' ? 'success' : ($task->status === 'in_progress' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </p>
                                    <p class="mb-1">
                                        <strong class="text-muted">Prioridad:</strong>
                                        <span
                                            class="badge bg-{{ $task->priority === 'high' ? 'danger' : ($task->priority === 'medium' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </p>
                                    <p class="mb-1">
                                        <strong class="text-muted">Asignada a:</strong>
                                        {{ $task->assignedUser->name ?? 'No asignada' }}
                                    </p>
                                    <p class="mb-0">
                                        <strong class="text-muted">Vence:</strong>
                                        {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'Sin fecha' }}
                                    </p>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('tasks.edit', $task) }}"
                                        class="btn btn-sm btn-outline-primary">Editar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection
