<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

        $activeProjects = $user->createdProjects()->count();
        $assignedTasks = $user->assignedTasks()->count();
        $completedTasks = $user->assignedTasks()->where('status', 'done')->count();
        $pendingTasks = $user->assignedTasks()->where('status', 'todo')->orderBy('due_date')->get();

        return view('dashboard', compact('activeProjects', 'assignedTasks', 'completedTasks', 'pendingTasks'));
    }
}
