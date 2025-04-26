<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('assigned_to', auth()->id())
            ->orWhere('created_by', auth()->id())
            ->with(['assignedUser', 'createdUsers'])
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        $projects = Project::where('creator_id', $user->id)->get();
        $users = User::all();
        return view('tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea creada con éxito.');
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Tarea actualizada con éxito.');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tasks,id',
            'status' => 'required|in:todo,in_progress,done',
        ]);

        $task = Task::find($request->id);

        $validTransitions = [
            'todo' => ['in_progress'],
            'in_progress' => ['done'],
            'done' => [],
        ];

        if (!in_array($request->status, $validTransitions[$task->status])) {
            return response()->json(['success' => false, 'error' => 'Transición no permitida'], 403);
        }

        $task->status = $request->status;
        $task->save();

        return response()->json(['success' => true]);
    }
}
