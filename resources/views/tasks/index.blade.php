@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Tablero de Tareas</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-success shadow-sm">Nueva Tarea</a>
    </div>

    <div class="row">
        @foreach(['todo' => 'Pendiente', 'in_progress' => 'En Progreso', 'done' => 'Completada'] as $status => $label)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light fw-bold text-center">
                        {{ $label }}
                    </div>
                    <div class="card-body kanban-column" data-status="{{ $status }}">
                        @foreach($tasks->where('status', $status) as $task)
                            <div class="card mb-3 shadow-sm task-card" draggable="true" data-id="{{ $task->id }}"
                                 style="border-left: 6px solid {{ $task->priority == 'high' ? '#dc3545' : ($task->priority == 'medium' ? '#fd7e14' : '#198754') }};">
                                <div class="card-body p-2">
                                    <h6 class="fw-semibold">{{ $task->title }}</h6>
                                    <small class="text-muted">{{ Str::limit($task->description, 60) }}</small><br>
                                    <small class="text-muted">Límite: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') : 'N/A' }}</small><br>
                                    <small class="text-muted">
                                        Asignada a: 
                                        <span class="badge bg-secondary">
                                            @if ($task->assigned_to)
                                                {{ $task->assignedUser->name }}
                                            @else
                                                {{ $task->createdUsers->name }}
                                            @endif
                                        </span>
                                    </small>
                                    <div class="mt-2 text-end">
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@push('scripts')
<script>
    let dragged;

    const validTransitions = {
        todo: ['in_progress'],
        in_progress: ['done'],
        done: []
    };

    document.querySelectorAll('.task-card').forEach(card => {
        card.addEventListener('dragstart', (e) => {
            dragged = card;
            e.dataTransfer.setData('text/plain', card.dataset.id);
        });
    });

    document.querySelectorAll('.kanban-column').forEach(column => {
        column.addEventListener('dragover', (e) => e.preventDefault());

        column.addEventListener('drop', (e) => {
            e.preventDefault();
            const taskId = dragged.dataset.id;
            const newStatus = column.dataset.status;
            const currentStatus = dragged.closest('.kanban-column').dataset.status;

            if (!validTransitions[currentStatus].includes(newStatus)) {
                alert('No puedes mover esta tarea directamente a este estado.');
                return;
            }

            column.appendChild(dragged);

            fetch("{{ route('tasks.update-status') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ id: taskId, status: newStatus })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) alert('Error al actualizar');
            });
        });
    });
</script>
@endpush

@endsection
