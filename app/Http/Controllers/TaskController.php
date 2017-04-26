<?php

namespace App\Http\Controllers;

use App\Reassignment;
use App\Repositories\TaskRepository;
use App\Task;
use App\Utils\Events;
use App\Utils\Statuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $this->authorize('assign', $task);

        $this->validate($request, [
            'assigned_to' => 'required|exists:users,id',
        ]);

        if ($task->assigned_to == $request->input('assigned_to')) {
            return $task;
        }

        DB::transaction(function () use ($request, $task) {
            $task->assigned_to = $request->input('assigned_to');
            $task->save();

            $reassignment = new Reassignment();
            $reassignment->task_id = $task->id;
            $reassignment->assigned_to = $task->assigned_to;
            $reassignment->comment = $request->input('comment');
            $reassignment->save();
        });

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

        event(Events::TASK_CREATED, $task);

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
