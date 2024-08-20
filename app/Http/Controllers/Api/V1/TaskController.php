<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Gate check
        Gate::authorize('viewAny', Task::class);

        // Get all task from resource
        $tasks = TaskResource::collection(auth()->user()->tasks()->get());

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        // Create Task
        $task = auth()->user()->tasks()->create($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Gate check
        Gate::authorize('view', $task);

        // Get task from resource
        $task = TaskResource::make($task);

        return $task;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        // Gate check
        if($request->user()->cannot('update', $task)) {
            return $this->responseWithError(
                'You are not authorized to update this task.',
                'NOT_AUTHORIZE',
                403);
        }

        // Update Task
        $task->update($request->validated());

        return TaskResource::make($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        // Gate check
        Gate::authorize('delete', $task);

        // Delete Task
        $task->delete();

        return response()->noContent();
    }
}
