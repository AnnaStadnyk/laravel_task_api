<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskListRequest;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TaskListRequest $request)
    {
        $tasks = Auth::user()->tasks()
            ->where('is_comleted', false)
            ->when($request->priority, function ($query) use ($request) {
                $query->where('priority', '=', $request->priority);
            })
            ->when($request->daysFrom, function ($query) use ($request) {
                $query->where('control_at', '>=', today()->addDays((int) $request->daysFrom));
            })
            ->when($request->daysTo, function ($query) use ($request) {
                $query->where('control_at', '<=', today()->addDays((int) $request->daysTo));
            })
            ->when($request->sortBy && $request->sortOrder, function ($query) use ($request) {
                $query->orderBy(match ($request->sortBy) {
                    'priority' => 'priority',
                    'expiration' => 'control_at'
                }, $request->sortOrder);
            })
            ->orderBy('created_at')
            ->paginate();

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $attributes = $request->validated();

        unset($attributes['file']);

        if (! empty($request->file('file'))) {
            $filePath = $request->file('file')->store('files');
            $attributes['file'] = $filePath;
        }

        return new TaskResource($request->user()->tasks()->create($attributes));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        $attributes = $request->validated();

        unset($attributes['file']);

        if (! empty($request->file('file'))) {
            if (! empty($task->file)) {
                Storage::disk('public')->delete($task->file);
            }
            $filePath = $request->file('file')->store('files');
            $attributes['file'] = $filePath;
        }

        $task->update($attributes);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        if (! empty($task->file)) {
            Storage::disk('public')->delete($task->file);
        }

        $task->delete();

        return response()->json(null, 204);
    }

    /**
     * Change the specified resource in storage.
     */
    public function complete(Task $task)
    {
        $task->update([
            'is_comleted' => true
        ]);

        return new TaskResource($task);
    }
}
