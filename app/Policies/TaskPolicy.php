<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can update or delete any models.
     */
    public function edit(User $user, Task $task): bool
    {
        return $task->user->is($user);
    }
}
