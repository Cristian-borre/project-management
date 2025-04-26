<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Task;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del usuario.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $createdProjects = $user->createdProjects()->with('tasks')->get();
        $assignedProjects = $user->assignedTasks()->with('project')->get()->pluck('project')->unique('id');

        $projects = $createdProjects->merge($assignedProjects);

        $activeProjects = $projects->count();

        $assignedTasks = Task::where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                    ->orWhere(function($subQuery) use ($user) {
                        $subQuery->whereNull('assigned_to')
                                ->where('created_by', $user->id);
                    });
            })
            ->count();

        $completedTasks = $projects
            ->flatMap(function ($project) use ($user) {
                if ($project->creator_id == $user->id) {
                    return $project->tasks->where('status', 'done');
                } else {
                    return $project->tasks->where('status', 'done')->where('assigned_to', $user->id);
                }
            })
            ->count();

        $pendingTasks = $projects
            ->flatMap(function ($project) use ($user) {
                if ($project->creator_id == $user->id) {
                    return $project->tasks->where('status', 'todo');
                } else {
                    return $project->tasks->where('status', 'todo')->where('assigned_to', $user->id)->sortBy('due_date');
                }
            });

        $upcomingTasks = Task::where(function($query) use ($user) {
                $query->where('assigned_to', $user->id)
                      ->orWhere(function($subQuery) use ($user) {
                          $subQuery->whereNull('assigned_to')
                                   ->where('created_by', $user->id);
                      });
            })
            ->where('due_date', '>', now())
            ->where('due_date', '<=', now()->addWeek())
            ->whereIn('status', ['todo', 'in_progress'])
            ->orderBy('due_date')
            ->with(['assignedUser', 'createdUsers'])
            ->get();

        $todoCount = $projects
            ->flatMap(function ($project) use ($user) {
                if ($project->creator_id == $user->id) {
                    return $project->tasks->where('status', 'todo');
                } else {
                    return $project->tasks->where('status', 'todo')->where('assigned_to', $user->id);
                }
            })
            ->count();

        $inProgressCount = $projects
            ->flatMap(function ($project) use ($user) {
                if ($project->creator_id == $user->id) {
                    return $project->tasks->where('status', 'in_progress');
                } else {
                    return $project->tasks->where('status', 'in_progress')->where('assigned_to', $user->id);
                }
            })
            ->count();

        $doneCount = $projects
            ->flatMap(function ($project) use ($user) {
                if ($project->creator_id == $user->id) {
                    return $project->tasks->where('status', 'done');
                } else {
                    return $project->tasks->where('status', 'done')->where('assigned_to', $user->id);
                }
            })
            ->count();

        $projectNames = $projects->pluck('name')->map(function ($name) {
            return Str::limit($name, 10);
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
