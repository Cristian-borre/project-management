@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Mis Tareas</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-success shadow-sm">
            Nueva Tarea
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="alert alert-info">No tienes tareas asignadas o creadas.</div>
    @else
        <div class="row g-3">
            @foreach($tasks as $task)
                <div class="col-md-3">
                    <div class="card shadow-sm h-100" style="border-left: 6px solid {{ $task->priority == 'high' ? '#dc3545' : ($task->priority == 'medium' ? '#fd7e14' : '#198754') }};">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-dark fw-semibold">{{ $task->title }}</h5>
                            <p class="card-text text-muted small mb-2">{{ Str::limit($task->description, 100) }}</p>

                            <span class="badge rounded-pill bg-{{ 
                                $task->status == 'done' ? 'success' : 
                                ($task->status == 'in_progress' ? 'warning text-dark' : 'secondary') 
                            }}">
                                {{ ucfirst($task->status) }}
                            </span>

                            <ul class="list-unstyled small mt-3 mb-4 text-muted">
                                <li><strong>Fecha límite:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'N/A' }}</li>
                                <li><strong>Proyecto:</strong> {{ Str::limit($task->project->name ?? 'Libre', 25) }}</li>
                            </ul>

                            <div class="mt-auto d-flex justify-content-end">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
