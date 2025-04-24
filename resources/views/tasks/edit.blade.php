@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-primary">Editar Tarea</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-3">
            <label for="title" class="form-label">Título de la Tarea</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}" required>
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ $task->description }}</textarea>
        </div>

        <!-- Fecha de vencimiento -->
        <div class="mb-3">
            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $task->due_date }}">
        </div>

        <!-- Estado -->
        <div class="mb-3">
            <label for="status" class="form-label">Estado</label>
            <select class="form-control" id="status" name="status">
                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Por hacer</option>
                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En progreso</option>
                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Hecha</option>
            </select>
        </div>

        <!-- Prioridad -->
        <div class="mb-3">
            <label for="priority" class="form-label">Prioridad</label>
            <select class="form-control" id="priority" name="priority">
                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Baja</option>
                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Media</option>
                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Alta</option>
            </select>
        </div>

        <!-- Proyecto -->
        <div class="mb-3">
            <label for="project_id" class="form-label">Proyecto</label>
            <select class="form-control" id="project_id" name="project_id">
                <option value="" {{ is_null($task->project_id) ? 'selected' : '' }}>Sin Proyecto</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}" {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Asignado a -->
        <div class="mb-3">
            <label for="assigned_to" class="form-label">Asignado a</label>
            <select class="form-control" id="assigned_to" name="assigned_to">
                <option value="" {{ is_null($task->assigned_to) ? 'selected' : '' }}>No asignado</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-warning px-4 py-2">Actualizar Tarea</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary px-4 py-2">Cancelar</a>
        </div>
    </form>
</div>
@endsection
