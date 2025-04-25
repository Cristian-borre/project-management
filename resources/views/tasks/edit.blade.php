@extends('layouts.app')

@section('content')
    <div class="container mt-5" style="max-width: 700px;">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h2 class="mb-4 text-center text-primary">Editar Tarea</h2>

                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label fw-semibold">Título</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $task->title }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $task->description }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="due_date" class="form-label">Fecha de Vencimiento</label>
                            <input type="date" class="form-control" id="due_date" name="due_date"
                                value="{{ $task->due_date }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="priority" class="form-label">Prioridad</label>
                            <select class="form-control" id="priority" name="priority">
                                <option value="low" {{ $task->priority == 'low' ? 'selected' : '' }}>Baja</option>
                                <option value="medium" {{ $task->priority == 'medium' ? 'selected' : '' }}>Media</option>
                                <option value="high" {{ $task->priority == 'high' ? 'selected' : '' }}>Alta</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-control" id="status" name="status">
                                <option value="todo" {{ $task->status == 'todo' ? 'selected' : '' }}>Por hacer</option>
                                <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>En
                                    progreso</option>
                                <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Hecha</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label for="assigned_to" class="form-label">Asignado a</label>
                            <select class="form-control" id="assigned_to" name="assigned_to">
                                <option value="" {{ is_null($task->assigned_to) ? 'selected' : '' }}>No asignado</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="project_id" class="form-label">Proyecto</label>
                        <select class="form-control" id="project_id" name="project_id">
                            <option value="" {{ is_null($task->project_id) ? 'selected' : '' }}>Sin Proyecto
                            </option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ $task->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="d-flex justify-content-end">
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
