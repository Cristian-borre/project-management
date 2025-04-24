@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Crear Nueva Tarea</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div class="mb-4">
            <label for="title" class="form-label">Título:</label>
            <input type="text" class="form-control shadow-sm" id="title" name="title" placeholder="Título de la tarea" required>
        </div>

        <div class="mb-4">
            <label for="description" class="form-label">Descripción:</label>
            <textarea class="form-control shadow-sm" id="description" name="description" placeholder="Descripción detallada de la tarea" rows="4"></textarea>
        </div>

        <div class="mb-4">
            <label for="due_date" class="form-label">Fecha de Vencimiento:</label>
            <input type="date" class="form-control shadow-sm" id="due_date" name="due_date">
        </div>

        <div class="mb-4">
            <label for="status" class="form-label">Estado:</label>
            <select class="form-control shadow-sm" id="status" name="status">
                <option value="todo">Por hacer</option>
                <option value="in_progress">En progreso</option>
                <option value="done">Hecha</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="priority" class="form-label">Prioridad:</label>
            <select class="form-control shadow-sm" id="priority" name="priority">
                <option value="low">Baja</option>
                <option value="medium">Media</option>
                <option value="high">Alta</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="project_id" class="form-label">Asignar a Proyecto (opcional):</label>
            <select class="form-control shadow-sm" id="project_id" name="project_id">
                <option value="" selected>Libre (sin proyecto)</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="assigned_to" class="form-label">Asignar a:</label>
            <select class="form-control shadow-sm" id="assigned_to" name="assigned_to">
                <option value="">-- Sin asignar (yo mismo) --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary shadow-sm">Guardar</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary ms-2 shadow-sm">Cancelar</a>
    </form>
</div>
@endsection
