@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary fw-bold">Listado de Proyectos</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-success shadow-sm">
            Nuevo Proyecto
        </a>
    </div>

    @if($projects->isEmpty())
        <div class="alert alert-warning text-center shadow-sm rounded">
            No hay proyectos creados todavía.
        </div>
    @else
        <div class="table-responsive rounded shadow-sm">
            <table class="table table-hover align-middle border rounded overflow-hidden">
                <thead class="bg-gradient text-white" style="background: linear-gradient(90deg, #0d6efd, #6610f2);">
                    <tr class="text-center">
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Creador</th>
                        <th scope="col">Creado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($projects as $project)
                        <tr>
                            <td class="text-start fw-semibold">{{ $project->name }}</td>
                            <td class="text-start text-muted">{{ Str::limit($project->description, 50) }}</td>
                            <td>{{ $project->creator->name }}</td>
                            <td>{{ $project->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-info me-1">
                                    Ver
                                </a>
                                @if(Auth::id() === $project->creator_id)
                                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
