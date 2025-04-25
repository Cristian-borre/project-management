@extends('layouts.app')

@section('content')
    <div class="container-fluid px-4 py-5">
        <div class="row g-4">
            <!-- Estadísticas rápidas -->
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-3 p-3">
                    <div class="text-muted">Proyectos Activos</div>
                    <h3 class="fw-bold">{{ $activeProjects }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-3 p-3">
                    <div class="text-muted">Tareas Asignadas</div>
                    <h3 class="fw-bold">{{ $assignedTasks }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-3 p-3">
                    <div class="text-muted">Completadas</div>
                    <h3 class="fw-bold">{{ $completedTasks }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center border-0 shadow-sm rounded-3 p-3">
                    <div class="text-muted">Pendientes</div>
                    <h3 class="fw-bold">{{ $pendingTasks->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row g-4 mt-4">
            <div class="col-md-3">
                <div class="card border-0 shadow rounded-3" style="max-height: 400px">
                    <div class="card-header bg-gradient bg-primary text-white">
                        <h5 class="mb-0">Tareas por Estado</h5>
                    </div>
                    <div class="card-body">
                        <canvas class="pie-chart" id="taskStatusChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow rounded-3" style="max-height: 400px">
                    <div class="card-header bg-gradient bg-secondary text-white">
                        <h5 class="mb-0">Progreso por Proyecto</h5>
                    </div>
                    <div class="card-body">
                        <canvas class="bar-chart" id="projectProgressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tareas Próximas a Vencer -->
        <div class="row g-4 mt-4">
            <div class="col-md-12">
                <div class="card border-0 shadow rounded-3">
                    <div class="card-header bg-gradient bg-danger text-white">
                        <h5 class="mb-0">Tareas Próximas a Vencer</h5>
                    </div>
                    <div class="card-body">
                        @if ($upcomingTasks->isEmpty())
                            <p class="text-muted text-center">No hay tareas próximas a vencer.</p>
                        @else
                            <ul class="list-group list-group-flush">
                                @foreach ($upcomingTasks as $task)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $task->title }}</strong><br>
                                            <small
                                                class="text-muted">{{ $task->project ? $task->project->name : 'Libre' }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark">
                                            {{ \Carbon\Carbon::parse($task->due_date)->diffForHumans() }}
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

    @push('styles')
        <style>
            .pie-chart {
                max-width: 300px;
                max-height: 300px;
                width: 100%;
                height: auto;
                margin: 0 auto;
            }
            .bar-chart {
                max-height: 300px;
                width: 100%;
                height: auto;
                margin: 0 auto;
            }
        </style>
    @endpush


    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const taskStatusChart = new Chart(document.getElementById('taskStatusChart'), {
                type: 'pie',
                data: {
                    labels: ['Pendientes', 'En Progreso', 'Completadas'],
                    datasets: [{
                        label: 'Tareas',
                        data: [
                            {{ $todoCount }},
                            {{ $inProgressCount }},
                            {{ $doneCount }}
                        ],
                        backgroundColor: ['#f59e0b', '#3b82f6', '#10b981'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right', // Aquí movemos la leyenda a la derecha
                            labels: {
                                boxWidth: 20,
                                padding: 15
                            }
                        }
                    }
                }
            });

            const projectProgressChart = new Chart(document.getElementById('projectProgressChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($projectNames) !!},
                    datasets: [{
                        label: 'Progreso (%)',
                        data: {!! json_encode($projectProgress) !!},
                        backgroundColor: '#6366f1'
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            feather.replace();
        </script>
    @endpush
@endsection
