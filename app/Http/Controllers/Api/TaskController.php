<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\UserResource;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        return $this->sendResponse("Request done.", new UserResource($user));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $user = Auth::user();
        $task = $user->tasks()->create($request->validated());
        return $this->sendResponse("Task created successfully.", [
            'task' => $task
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return $this->sendResponse("Request done successfully.", $task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);
        $task->update($request->validated());
        return $this->sendResponse("Task updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('update', $task);
        $task->delete();
        return $this->sendResponse("Task deleted successfully.");
    }
}
