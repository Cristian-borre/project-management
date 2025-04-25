<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        $createdProjects = Project::where('creator_id', $user->id)->get();
        $assignedProjects = $user->assignedTasks()->with('project')->get()->pluck('project')->unique('id');

        $projects = $createdProjects->merge($assignedProjects);
        
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'creator_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Proyecto creado con éxito.');
    }

    public function show(Project $project)
    {
        $tasks = $project->tasks()->with('assignedUser')->get();
        return view('projects.show', compact('project', 'tasks'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $project->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('projects.index');
    }
}
