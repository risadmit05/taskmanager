<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->get()->groupBy('status');
        $users = $project->users()->get();
        $modules = $project->modules()->where('is_parent',1)->get();
        return view('tasks.index', compact('project', 'tasks', 'users','modules'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'module_id' => 'required|integer|exists:modules,id',
            'sub_module_id' => 'nullable|integer|exists:modules,id',
            'sub_sub_module_id' => 'nullable|integer|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $project->tasks()->create($request->all());

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $modules = $task->project->modules()->where('is_parent',1)->get(['id','name']);
        $sub_modules = $task->project->modules()->where('is_parent',0)->where('parent_id',$task->module_id)->get(['id','name']);
        $sub_sub_modules = $task->project->modules()->where('is_parent',0)->where('parent_id',$task->sub_module_id)->get(['id','name']);
        return view('tasks.show', compact('task','modules','sub_modules','sub_sub_modules'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        $task->update($request->all());

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $task->status = $request->input('status');
        $task->save();

        return response()->json(['message' => 'Task status updated successfully.']);
    }
}
