<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Task;
use App\Utils\Statuses;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        return $this->taskRepository->all();
    }

    public function getAssignedTasks()
    {
        return $this->taskRepository->getAssignedTasks();
    }

    public function assignTask(Request $request, Task $task)
    {
        $this->validate($request, [
            'assigned_to' => 'required|exists:users,id',
        ]);
        $task->assigned_to = $request->input('assgined_to');
        $task->save();

        // @TODO use transaction and add comment

        return $task;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'name' => 'required|max:255',
            'description' => 'required',
            'status' => ['required', Rule::in(Statuses::all())],
            'deadline' => 'required|date',
        ]);
        $task = new Task($request->all());
        $task->project_id = $request->input('project_id');
        $task->assigned_to = $request->input('assigned_to');
        $request->user()->tasks()->save($task);
        return $task;
    }

    public function show(Task $task)
    {
        return $task;
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->fill($request->all());
        $task->save();
        return $task;
    }

    public function destroy(Task $task)
    {
        $task->delete();
    }
}
