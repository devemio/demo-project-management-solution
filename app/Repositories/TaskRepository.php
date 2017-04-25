<?php

namespace App\Repositories;

use App\Task;
use Illuminate\Http\Request;

class TaskRepository extends BaseRepository
{
    private $task;

    public function __construct(Request $request, Task $task)
    {
        parent::__construct($request);
        $this->task = $task;
    }

    public function all()
    {
        return $this->task->where('user_id', $this->getUserID())->orWhere('assigned_to', $this->getUserID())->get();
    }

    public function getAssignedTasks()
    {
        return $this->task->orWhere('assigned_to', $this->getUserID())->get();
    }
}