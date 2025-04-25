<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Obtener las estadísticas
        $activeProjects = $user->createdProjects()->count(); // Proyectos que ha creado el usuario
        $assignedTasks = $user->assignedTasks()->count(); // Tareas asignadas al usuario
        $completedTasks = $user->assignedTasks()->where('status', 'done')->count(); // Tareas completadas
        $pendingTasks = $user->assignedTasks()->where('status', 'todo')->orderBy('due_date')->get(); // Tareas pendientes

        // Obtener las tareas próximas a vencer
        $upcomingTasks = $user->assignedTasks()->where('due_date', '>', now())->orderBy('due_date')->get();

        // Contadores de tareas por estado (Pendientes, En Progreso, Completadas)
        $todoCount = $user->assignedTasks()->where('status', 'todo')->count();
        $inProgressCount = $user->assignedTasks()->where('status', 'in_progress')->count();
        $doneCount = $user->assignedTasks()->where('status', 'done')->count();

        // Obtener los proyectos y su progreso (esto es un ejemplo y depende de tu implementación)
        $projects = $user->createdProjects()->withCount('tasks')->get();
        $projectNames = $projects->pluck('name')->map(function ($name) {
            return Str::limit($name, 10); // limitar a 20 caracteres
        });
        $projectProgress = $projects->map(function ($project) {
            $completedTasks = $project->tasks()->where('status', 'done')->count();
            $totalTasks = $project->tasks()->count();
            return $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;
        });

        return view('dashboard', compact(
            'activeProjects',
            'assignedTasks',
            'completedTasks',
            'pendingTasks',
            'upcomingTasks',
            'todoCount',
            'inProgressCount',
            'doneCount',
            'projectNames',
            'projectProgress'
        ));
    }
}
