@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Mis Tareas</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-success shadow-sm">
            Nuevo Tarea
        </a>
    </div>

    @if($tasks->isEmpty())
        <div class="alert alert-info">No tienes tareas asignadas o creadas.</div>
    @else
        <div class="row">
            @foreach($tasks as $task)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm" style="border-left: 5px solid {{ $task->priority == 'high' ? 'red' : ($task->priority == 'medium' ? 'orange' : 'green') }};">
                        <div class="card-body">
                            <h5 class="card-title">{{ $task->title }}</h5>
                            <p class="card-text">{{ Str::limit($task->description, 100) }}</p>
                            <span class="badge bg-{{ $task->status == 'done' ? 'success' : ($task->status == 'in_progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($task->status) }}
                            </span>
                            <div class="mt-2">
                                <small><strong>Fecha límite:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'N/A' }}</small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning btn-sm">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
