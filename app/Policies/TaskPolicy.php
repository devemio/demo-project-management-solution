<?php

namespace App\Policies;

use App\Project;
use App\User;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\User  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return $user->getID() == $task->user_id;
    }

    public function assign(User $user, Task $task)
    {
        return $user->getID() == $task->project->user_id;
    }
}
