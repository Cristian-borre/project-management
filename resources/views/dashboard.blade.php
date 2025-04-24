@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5 px-4">

    <!-- Resumen General y Progreso -->
    <div class="row">
        <!-- Resumen General -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3" style="height: 200px">
                <div class="card-header bg-gradient bg-primary text-white d-flex align-items-center">
                    <h5 class="mb-0">Resumen General</h5>
                </div>
                <div class="card-body fs-6">
                    <p><strong>Proyectos Activos:</strong> {{ $activeProjects }}</p>
                    <p><strong>Tareas Asignadas:</strong> {{ $assignedTasks }}</p>
                    <p><strong>Tareas Completadas:</strong> {{ $completedTasks }}</p>
                </div>
            </div>
        </div>

        <!-- Progreso de Proyectos -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg border-0 rounded-3" style="height: 200px">
                <div class="card-header bg-gradient bg-secondary text-white d-flex align-items-center">
                    <h5 class="mb-0">Progreso de Proyectos</h5>
                </div>
                <div class="card-body">
                    <canvas id="projectProgressChart" style="max-height: 180px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Tareas Pendientes -->
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-warning text-dark d-flex align-items-center">
                    <h5 class="mb-0">Tareas Pendientes</h5>
                </div>
                <div class="card-body">
                    @if($pendingTasks->isEmpty())
                        <div class="alert alert-light text-muted text-center">
                            ¡Todo al día! No tienes tareas pendientes.
                        </div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($pendingTasks as $task)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $task->title }}
                                    </div>
                                    <span class="badge bg-danger rounded-pill">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d M Y') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
