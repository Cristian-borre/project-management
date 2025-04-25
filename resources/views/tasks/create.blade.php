@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 700px;">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <h2 class="mb-4 text-center text-primary">Nueva Tarea</h2>

            <form method="POST" action="{{ route('tasks.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Título</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Título de la tarea" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Descripción detallada..."></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                        <input type="date" id="due_date" name="due_date" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="priority" class="form-label">Prioridad</label>
                        <select id="priority" name="priority" class="form-select">
                            <option value="low">Baja</option>
                            <option value="medium">Media</option>
                            <option value="high">Alta</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Estado</label>
                        <select id="status" name="status" class="form-select">
                            <option value="todo">Por hacer</option>
                            <option value="in_progress">En progreso</option>
                            <option value="done">Hecha</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="assigned_to" class="form-label">Asignar a</label>
                        <select id="assigned_to" name="assigned_to" class="form-select">
                            <option value="">-- Sin asignar (yo mismo) --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="project_id" class="form-label">Proyecto (opcional)</label>
                    <select id="project_id" name="project_id" class="form-select">
                        <option value="" selected>Libre (sin proyecto)</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Crear Tarea</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
